<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WikipediaService
{
    public function search($query, $limit = 5)
    {
        $response = Http::get('https://en.wikipedia.org/w/api.php', [
            'action'   => 'query',
            'format'   => 'json',
            'list'     => 'search',
            'srsearch' => $query,
            'srlimit'  => $limit,
        ]);

        return $response->json();
    }
}
