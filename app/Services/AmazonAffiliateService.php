<?php

namespace App\Services;

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Condition;
use App\Models\AffiliateSetting;

class AmazonAffiliateService
{
    private $apiClient;
    private $accessKey;
    private $secretKey;
    private $associateTag;
    private $region;

    public function __construct()
    {
        $this->accessKey = AffiliateSetting::get('amazon_access_key', env('AMAZON_ACCESS_KEY'));
        $this->secretKey = AffiliateSetting::get('amazon_secret_key', env('AMAZON_SECRET_KEY'));
        $this->associateTag = AffiliateSetting::get('amazon_associate_tag', env('AMAZON_ASSOCIATE_TAG'));
        $this->region = AffiliateSetting::get('amazon_region', env('AMAZON_REGION', 'us-east-1'));

        if ($this->isConfigured()) {
            $this->initializeApiClient();
        }
    }

    /**
     * Amazon API設定が完了しているかチェック
     */
    public function isConfigured(): bool
    {
        return !empty($this->accessKey) && 
               !empty($this->secretKey) && 
               !empty($this->associateTag);
    }

    /**
     * API クライアントを初期化
     */
    private function initializeApiClient(): void
    {
        $config = new Configuration();
        
        // Set your access key here
        $config->setAccessKey($this->accessKey);
        $config->setSecretKey($this->secretKey);
        
        // Set the region here
        $config->setHost($this->getRegionHost());
        $config->setRegion($this->region);
        
        $this->apiClient = new DefaultApi(
            new \GuzzleHttp\Client(),
            $config
        );
    }

    /**
     * リージョンに対応するホストを取得
     */
    private function getRegionHost(): string
    {
        $hosts = [
            'us-east-1' => 'webservices.amazon.com',
            'us-west-2' => 'webservices.amazon.com',
            'eu-west-1' => 'webservices.amazon.co.uk',
            'ap-northeast-1' => 'webservices.amazon.co.jp',
        ];

        return $hosts[$this->region] ?? 'webservices.amazon.com';
    }

    /**
     * 商品名でAmazonの商品を検索
     */
    public function searchProducts(string $keyword, int $itemCount = 5): array
    {
        if (!$this->isConfigured()) {
            return [];
        }

        try {
            $searchItemsRequest = new SearchItemsRequest();
            $searchItemsRequest->setSearchIndex('All');
            $searchItemsRequest->setKeywords($keyword);
            $searchItemsRequest->setItemCount($itemCount);
            $searchItemsRequest->setPartnerTag($this->associateTag);
            $searchItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
            $searchItemsRequest->setCondition(Condition::NEW_);

            // Set resources
            $searchItemsRequest->setResources([
                SearchItemsResource::ITEM_INFOTITLE,
                SearchItemsResource::ITEM_INFOFEATURES,
                SearchItemsResource::OFFERSLISTINGSPRICE,
                SearchItemsResource::IMAGESPREVIEWIMAGE,
                SearchItemsResource::ITEM_INFOBY_LINE_INFO
            ]);

            $searchItemsResponse = $this->apiClient->searchItems($searchItemsRequest);

            if ($searchItemsResponse->getSearchResult()) {
                return $this->formatSearchResults($searchItemsResponse->getSearchResult()->getItems());
            }

        } catch (ApiException $exception) {
            \Log::error('Amazon PA API Error: ' . $exception->getMessage());
        } catch (\Exception $exception) {
            \Log::error('Amazon Affiliate Service Error: ' . $exception->getMessage());
        }

        return [];
    }

    /**
     * 検索結果をフォーマット
     */
    private function formatSearchResults($items): array
    {
        $results = [];

        if ($items) {
            foreach ($items as $item) {
                $result = [
                    'asin' => $item->getASIN(),
                    'title' => '',
                    'url' => '',
                    'price' => '',
                    'image_url' => '',
                    'features' => []
                ];

                // タイトル
                if ($item->getItemInfo() && $item->getItemInfo()->getTitle()) {
                    $result['title'] = $item->getItemInfo()->getTitle()->getDisplayValue();
                }

                // URL
                if ($item->getDetailPageURL()) {
                    $result['url'] = $item->getDetailPageURL();
                }

                // 価格
                if ($item->getOffers() && 
                    $item->getOffers()->getListings() && 
                    count($item->getOffers()->getListings()) > 0) {
                    $listing = $item->getOffers()->getListings()[0];
                    if ($listing->getPrice() && $listing->getPrice()->getDisplayAmount()) {
                        $result['price'] = $listing->getPrice()->getDisplayAmount();
                    }
                }

                // 画像
                if ($item->getImages() && 
                    $item->getImages()->getPrimary() && 
                    $item->getImages()->getPrimary()->getLarge()) {
                    $result['image_url'] = $item->getImages()->getPrimary()->getLarge()->getURL();
                }

                // 特徴
                if ($item->getItemInfo() && $item->getItemInfo()->getFeatures()) {
                    $features = $item->getItemInfo()->getFeatures()->getDisplayValues();
                    $result['features'] = array_slice($features ?? [], 0, 3); // 最大3つの特徴
                }

                $results[] = $result;
            }
        }

        return $results;
    }

    /**
     * アフィリエイトリンクを生成
     */
    public function generateAffiliateLink(string $asin): string
    {
        if (!$this->isConfigured()) {
            return '';
        }

        $baseUrl = $this->getRegionBaseUrl();
        return "{$baseUrl}/dp/{$asin}?tag={$this->associateTag}";
    }

    /**
     * リージョンに対応するAmazonのベースURLを取得
     */
    private function getRegionBaseUrl(): string
    {
        $urls = [
            'us-east-1' => 'https://www.amazon.com',
            'us-west-2' => 'https://www.amazon.com',
            'eu-west-1' => 'https://www.amazon.co.uk',
            'ap-northeast-1' => 'https://www.amazon.co.jp',
        ];

        return $urls[$this->region] ?? 'https://www.amazon.com';
    }

    /**
     * 商品に最適なAmazon商品を1つ取得
     */
    public function getBestMatchProduct(string $productName): ?array
    {
        $results = $this->searchProducts($productName, 1);
        return !empty($results) ? $results[0] : null;
    }

    /**
     * 設定を更新
     */
    public function updateConfiguration(array $config): void
    {
        if (isset($config['access_key'])) {
            AffiliateSetting::set('amazon_access_key', $config['access_key'], true, 'Amazon PA API Access Key');
            $this->accessKey = $config['access_key'];
        }

        if (isset($config['secret_key'])) {
            AffiliateSetting::set('amazon_secret_key', $config['secret_key'], true, 'Amazon PA API Secret Key');
            $this->secretKey = $config['secret_key'];
        }

        if (isset($config['associate_tag'])) {
            AffiliateSetting::set('amazon_associate_tag', $config['associate_tag'], false, 'Amazon Associate Tag');
            $this->associateTag = $config['associate_tag'];
        }

        if (isset($config['region'])) {
            AffiliateSetting::set('amazon_region', $config['region'], false, 'Amazon API Region');
            $this->region = $config['region'];
        }

        // 再初期化
        if ($this->isConfigured()) {
            $this->initializeApiClient();
        }
    }
}