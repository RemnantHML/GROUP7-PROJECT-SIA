<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizController extends Controller
{
    /**
     * Get trivia questions from OpenTDB
     */
    public function getQuestions(Request $request)
    {
        $amount = $request->input('amount', 5); // Default: 5 questions
        $category = $request->input('category'); // Optional category ID
        $difficulty = $request->input('difficulty'); // easy, medium, hard
        $type = $request->input('type', 'multiple'); // 'multiple' or 'boolean'

        // Base API URL
        $url = "https://opentdb.com/api.php?amount=$amount&type=$type";

        // Add optional filters
        if ($category) {
            $url .= "&category=" . urlencode($category);
        }

        if ($difficulty) {
            $url .= "&difficulty=" . urlencode($difficulty);
        }

        // Make the API request
        $response = Http::get($url);

        // Handle the response
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch quiz questions'], 500);
    }

    /**
     * Get available trivia categories from OpenTDB
     */
    public function getCategories()
    {
        $response = Http::get("https://opentdb.com/api_category.php");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch categories'], 500);
    }
}
