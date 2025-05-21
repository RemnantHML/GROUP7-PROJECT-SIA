<?php

namespace App\Services;

use GuzzleHttp\Client;

class MathService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Evaluate a math expression using Math.js API.
     *
     * @param string $expression
     * @return string
     * @throws \Exception
     */
    public function evaluate(string $expression): string
    {
        $url = 'https://api.mathjs.org/v4/?expr=' . urlencode($expression);

        $response = $this->client->get($url);

        return (string) $response->getBody();
    }
}
