<?php

namespace App\Services;

use GuzzleHttp\Client;

class WikipediaService
{
    public function searchWikipedia($query)
    {
        $client = new Client();
        $response = $client->get('https://en.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'list' => 'search',
                'srsearch' => $query,
                'format' => 'json',
                'origin' => '*'
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['query']['search'] ?? [];
    }
}
