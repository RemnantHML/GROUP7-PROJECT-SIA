<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QuizService
{
    public function getQuestions($amount = 5, $category = null, $difficulty = null, $type = 'multiple')
    {
        $url = "https://opentdb.com/api.php?amount=$amount&type=$type";

        if ($category) {
            $url .= "&category=" . urlencode($category);
        }

        if ($difficulty) {
            $url .= "&difficulty=" . urlencode($difficulty);
        }

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getCategories()
    {
        $response = Http::get("https://opentdb.com/api_category.php");

        if ($response->successful()) {
            $json = $response->json();
            return $json['trivia_categories'] ?? null;
        }

        return null;
    }
}
