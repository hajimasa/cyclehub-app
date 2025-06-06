<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class SupabaseService
{
    protected Client $client;
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = Config::get('services.supabase.url');
        $this->apiKey = Config::get('services.supabase.key');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=minimal'
            ]
        ]);
    }

    public function select(string $table, array $columns = ['*'], array $filters = [])
    {
        $query = implode(',', $columns);
        $url = "/rest/v1/{$table}?select={$query}";
        
        foreach ($filters as $key => $value) {
            $url .= "&{$key}=eq.{$value}";
        }
        
        $response = $this->client->get($url);
        return json_decode($response->getBody(), true);
    }

    public function insert(string $table, array $data)
    {
        $url = "/rest/v1/{$table}";
        
        $response = $this->client->post($url, [
            'json' => $data
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function update(string $table, array $data, array $filters)
    {
        $url = "/rest/v1/{$table}";
        
        $queryParams = [];
        foreach ($filters as $key => $value) {
            $queryParams[] = "{$key}=eq.{$value}";
        }
        
        if (!empty($queryParams)) {
            $url .= '?' . implode('&', $queryParams);
        }
        
        $response = $this->client->patch($url, [
            'json' => $data
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function delete(string $table, array $filters)
    {
        $url = "/rest/v1/{$table}";
        
        $queryParams = [];
        foreach ($filters as $key => $value) {
            $queryParams[] = "{$key}=eq.{$value}";
        }
        
        if (!empty($queryParams)) {
            $url .= '?' . implode('&', $queryParams);
        }
        
        $response = $this->client->delete($url);
        return json_decode($response->getBody(), true);
    }

    public function uploadFile(string $bucket, string $path, $file)
    {
        $url = "/storage/v1/object/{$bucket}/{$path}";
        
        $response = $this->client->post($url, [
            'body' => $file,
            'headers' => [
                'Content-Type' => 'application/octet-stream'
            ]
        ]);
        
        return json_decode($response->getBody(), true);
    }

    public function getPublicUrl(string $bucket, string $path): string
    {
        return "{$this->baseUrl}/storage/v1/object/public/{$bucket}/{$path}";
    }
}