<?php

namespace App\Services;

use GuzzleHttp\Client;

class QuizService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('services.opentdb.base_url');
    }

    public function getQuestions($amount = 10, $category = null, $difficulty = null, $type = null)
    {
        $queryParams = [
            'amount' => $amount,
        ];

        if ($category) $queryParams['category'] = $category;
        if ($difficulty) $queryParams['difficulty'] = $difficulty;
        if ($type) $queryParams['type'] = $type;

        $response = $this->client->get($this->baseUrl, [
            'query' => $queryParams,
        ]);

        return json_decode($response->getBody(), true);
    }
}
