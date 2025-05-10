<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DogApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('dogapi.base_url');
        $this->apiKey = config('dogapi.key');
    }

    public function getBreeds()
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey
        ])->get($this->baseUrl . 'breeds');

        return $response->json();
    }
    public function searchBreed($query)
{
    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey
    ])->get($this->baseUrl . 'breeds/search', [
        'q' => $query
    ]);

    return $response->json();
}    
}