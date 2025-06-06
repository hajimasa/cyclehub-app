<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected ImageManager $imageManager;
    protected string $disk;
    protected string $basePath;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->disk = config('filesystems.default', 'public');
        $this->basePath = 'review-images';
    }

    /**
     * 画像をアップロードしてWebP形式に変換
     */
    public function uploadAndConvert(UploadedFile $file, string $directory = null): array
    {
        // ファイル名を生成
        $fileName = $this->generateFileName();
        $webpFileName = $fileName . '.webp';
        
        // ディレクトリパスを構築
        $path = $this->basePath;
        if ($directory) {
            $path .= '/' . $directory;
        }
        $filePath = $path . '/' . $webpFileName;

        // 画像を読み込み
        $image = $this->imageManager->read($file->getPathname());

        // 画像のリサイズ（最大幅1200px、高さは比例）
        $image = $image->scaleDown(width: 1200);

        // WebP形式でエンコード（品質90%）
        $webpData = $image->toWebp(90);

        // ストレージに保存
        Storage::disk($this->disk)->put($filePath, $webpData);

        // 公開URLを生成
        $publicUrl = Storage::disk($this->disk)->url($filePath);

        return [
            'path' => $filePath,
            'url' => $publicUrl,
            'size' => strlen($webpData),
            'width' => $image->width(),
            'height' => $image->height(),
        ];
    }

    /**
     * 複数の画像をアップロード
     */
    public function uploadMultiple(array $files, string $directory = null): array
    {
        $results = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                try {
                    $results[] = $this->uploadAndConvert($file, $directory);
                } catch (\Exception $e) {
                    // ログに記録してスキップ
                    \Log::error('Image upload failed: ' . $e->getMessage());
                    continue;
                }
            }
        }

        return $results;
    }

    /**
     * 画像を削除
     */
    public function delete(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * 複数の画像を削除
     */
    public function deleteMultiple(array $paths): array
    {
        $results = [];
        
        foreach ($paths as $path) {
            $results[$path] = $this->delete($path);
        }

        return $results;
    }

    /**
     * サムネイル画像を生成
     */
    public function createThumbnail(string $originalPath, int $width = 300, int $height = 300): array
    {
        if (!Storage::disk($this->disk)->exists($originalPath)) {
            throw new \Exception('Original image not found: ' . $originalPath);
        }

        // 元画像を読み込み
        $imageData = Storage::disk($this->disk)->get($originalPath);
        $image = $this->imageManager->read($imageData);

        // サムネイルを生成（アスペクト比を維持してクロップ）
        $thumbnail = $image->cover($width, $height);

        // サムネイル用のファイル名を生成
        $pathInfo = pathinfo($originalPath);
        $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['filename'] . '.webp';

        // WebP形式でエンコード
        $webpData = $thumbnail->toWebp(85);

        // サムネイルを保存
        Storage::disk($this->disk)->put($thumbnailPath, $webpData);

        // 公開URLを生成
        $publicUrl = Storage::disk($this->disk)->url($thumbnailPath);

        return [
            'path' => $thumbnailPath,
            'url' => $publicUrl,
            'size' => strlen($webpData),
            'width' => $thumbnail->width(),
            'height' => $thumbnail->height(),
        ];
    }

    /**
     * 画像の基本情報を取得
     */
    public function getImageInfo(string $path): ?array
    {
        if (!Storage::disk($this->disk)->exists($path)) {
            return null;
        }

        try {
            $imageData = Storage::disk($this->disk)->get($path);
            $image = $this->imageManager->read($imageData);

            return [
                'width' => $image->width(),
                'height' => $image->height(),
                'size' => Storage::disk($this->disk)->size($path),
                'mime_type' => 'image/webp',
                'url' => Storage::disk($this->disk)->url($path),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * ファイル名を生成
     */
    protected function generateFileName(): string
    {
        return date('Y/m/d') . '/' . Str::uuid();
    }

    /**
     * アップロードされたファイルのバリデーション
     */
    public function validateImage(UploadedFile $file): array
    {
        $errors = [];

        // ファイルサイズチェック（10MB）
        if ($file->getSize() > 10 * 1024 * 1024) {
            $errors[] = 'ファイルサイズが10MBを超えています。';
        }

        // MIMEタイプチェック
        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $errors[] = 'サポートされていないファイル形式です。';
        }

        // 画像の寸法チェック
        try {
            $imageSize = getimagesize($file->getPathname());
            if (!$imageSize) {
                $errors[] = '有効な画像ファイルではありません。';
            } else {
                // 最大解像度チェック（5000x5000px）
                if ($imageSize[0] > 5000 || $imageSize[1] > 5000) {
                    $errors[] = '画像の解像度が大きすぎます（最大5000x5000px）。';
                }
            }
        } catch (\Exception $e) {
            $errors[] = '画像ファイルの読み込みに失敗しました。';
        }

        return $errors;
    }
}