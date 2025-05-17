<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuizService;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function getQuestions(Request $request)
    {
        $amount = $request->input('amount', 5);
        $category = $request->input('category');
        $difficulty = $request->input('difficulty');
        $type = $request->input('type', 'multiple');

        $questions = $this->quizService->getQuestions($amount, $category, $difficulty, $type);

        if ($questions) {
            return response()->json($questions);
        }

        return response()->json(['error' => 'Failed to fetch quiz questions'], 500);
    }

    public function getCategories()
    {
        $categories = $this->quizService->getCategories();

        if ($categories) {
            return response()->json($categories);
        }

        return response()->json(['error' => 'Unable to fetch categories'], 500);
    }
}
