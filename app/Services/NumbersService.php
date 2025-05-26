<?php

namespace App\Services;

use GuzzleHttp\Client;

class NumbersService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = rtrim(config('services.numberfacts.base_url'), '/');
    }

    public function getTrivia($number)
    {
        $url = $this->baseUrl . '/' . $number;

        $response = $this->client->get($url);

        if ($response->getStatusCode() === 200) {
            return ['fact' => $response->getBody()->getContents()];
        }

        return ['error' => 'Could not fetch number fact'];
    }

    public function getMathFact($number)
    {
        $url = $this->baseUrl . '/' . $number . '/math';

        $response = $this->client->get($url);

        if ($response->getStatusCode() === 200) {
            return ['fact' => $response->getBody()->getContents()];
        }

        return ['error' => 'Could not fetch math fact'];
    }

    public function fetchFact($number, $type = 'trivia')
    {
        switch (strtolower($type)) {
            case 'math':
                return $this->getMathFact($number);
            case 'trivia':
            default:
                return $this->getTrivia($number);
        }
    }
}
