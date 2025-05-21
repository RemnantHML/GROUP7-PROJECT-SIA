<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WikipediaService;

class WikipediaController extends Controller
{
    protected $wikipediaService;

    public function __construct(WikipediaService $wikipediaService)
    {
        $this->wikipediaService = $wikipediaService;
    }

    public function search(Request $request)
    {
        $keyword = $request->query('query');

        if (!$keyword) {
            return response()->json(['message' => 'Missing query parameter.'], 400);
        }

        try {
            $results = $this->wikipediaService->searchWikipedia($keyword);
            return response()->json($results, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Wikipedia search failed.'], 500);
        }
    }
}
