<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DictionaryService
{
    protected $baseUrl = 'https://api.dictionaryapi.dev/api/v2/entries/en/';

    public function lookupWord($word)
    {
        $url = $this->baseUrl . urlencode($word);
        $response = Http::get($url);

        if ($response->failed()) {
            return ['error' => 'Word not found or API error'];
        }

        return $response->json();
    }
}
