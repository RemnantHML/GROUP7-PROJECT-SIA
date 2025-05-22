<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NumbersService
{
    public function fetchFact($number, $type)
    {
        $url = "http://numbersapi.com/{$number}/{$type}?json";

        try {
            $response = Http::get($url);
            return $response->json();
        } catch (\Exception $e) {
            return [
                'error' => 'Unable to fetch fact.',
                'message' => $e->getMessage()
            ];
        }
    }
}
