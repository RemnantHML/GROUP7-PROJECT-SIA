<?php

return [

    'wikipedia' => [
        'base_url' => env('SITE_1_APP_URL', 'https://en.wikipedia.org/w/api.php'),
    ],

    'opentdb' => [
        'base_url' => env('SITE_2_APP_URL', 'https://opentdb.com/api.php'),
    ],

    'numberfacts' => [
        'base_url' => env('SITE_3_APP_URL', 'http://numbersapi.com/'),
    ],

    'dictionary' => [
        'base_url' => env('SITE_4_APP_URL', 'https://api.dictionaryapi.dev/api/v2/entries/en/')
    ],
    'schedule' => [
        'base_url' => env('SITE_5_APP_URL', 'http://schedulerapi.com/')
    ]
    // Add more as needed
];
