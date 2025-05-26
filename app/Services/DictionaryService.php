<?php

namespace App\Services;

use GuzzleHttp\Client;

class DictionaryService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = rtrim(config('services.dictionary.base_url'), '/');
    }

    public function getDefinition(string $word)
    {
        $url = $this->baseUrl . '/' . urlencode($word);

        $response = $this->client->get($url);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody()->getContents(), true);
        }

        return ['error' => 'Could not fetch dictionary definition'];
    }
}
