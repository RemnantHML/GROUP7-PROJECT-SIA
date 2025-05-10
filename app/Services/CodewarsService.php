<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CodewarsService
{
    protected $client;
    protected $baseUrl = 'https://www.codewars.com/api/v1/';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getUserProfile($username)
    {
        try {
            $response = $this->client->get($this->baseUrl . "users/{$username}");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => 'Failed to retrieve data from Codewars.'];
        }
    }
}
