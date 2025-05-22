<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NumbersService;

class NumbersController extends Controller
{
    protected $numbersService;

    public function __construct(NumbersService $numbersService)
    {
        $this->numbersService = $numbersService;
    }

    public function getFact(Request $request)
{
    $number = $request->input('number', 'random');
    $type = $request->input('type', 'trivia'); // trivia, math, date, year

    $fact = $this->numbersService->fetchFact($number, $type);

    // Return the raw fact array directly, NOT nested in 'fact'
    return response()->json($fact);
}

}
