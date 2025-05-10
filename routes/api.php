<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Example test route
Route::get('/ping', function () {
    return response()->json(['status' => 'API is working']);
});
