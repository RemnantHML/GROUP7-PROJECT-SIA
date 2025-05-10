<?php

namespace App\Http\Controllers;

use App\Services\CodewarsService;

class CodewarsController extends Controller
{
    protected $codewars;

    public function __construct(CodewarsService $codewars)
    {
        $this->codewars = $codewars;
    }

    public function show($username)
    {
        $data = $this->codewars->getUserProfile($username);
        return response()->json($data);
    }
}
