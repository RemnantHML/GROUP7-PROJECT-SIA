<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MathService;

class MathController extends Controller
{
    protected $mathService;

    public function __construct(MathService $mathService)
    {
        $this->mathService = $mathService;
    }

    public function evaluate(Request $request)
    {
        $expression = $request->query('expr');

        if (!$expression) {
            return response()->json(['error' => 'No expression provided'], 400);
        }

        try {
            $result = $this->mathService->evaluate($expression);

            return response()->json([
                'expression' => $expression,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Math API error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
