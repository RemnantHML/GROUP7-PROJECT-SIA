<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DictionaryService;

class DictionaryController extends Controller
{
    protected $dictionaryService;

    public function __construct(DictionaryService $dictionaryService)
    {
        $this->dictionaryService = $dictionaryService;
    }

    public function lookup(Request $request)
    {
        $word = $request->query('word');

        if (!$word) {
            return response()->json(['error' => 'Missing "word" query parameter'], 400);
        }

        $result = $this->dictionaryService->lookupWord($word);
        return response()->json($result);
    }
}
