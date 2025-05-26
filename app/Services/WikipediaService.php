<?php

namespace App\Services;

use GuzzleHttp\Client;

class WikipediaService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('services.wikipedia.base_url');
    }

    public function searchWikipedia($query)
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'action' => 'query',
                'list' => 'search',
                'srsearch' => $query,
                'format' => 'json',
                'origin' => '*',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['query']['search'] ?? [];
    }
}
