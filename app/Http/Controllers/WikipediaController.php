<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WikipediaController extends Controller
{
    public function search(Request $request)
    {
        $response = Http::get('https://en.wikipedia.org/w/api.php', [
            'action'   => 'query',
            'format'   => 'json',
            'list'     => 'search',
            'srsearch' => $request->input('srsearch'),
            'srlimit'  => $request->input('srlimit', 5),
        ]);

        return response()->json($response->json());
    }
}