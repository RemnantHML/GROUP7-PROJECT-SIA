<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return 'Lumen is running!';
});

$router->get('/wikipedia/search', 'WikipediaController@search');

$router->get('/codewars/{username}', 'CodewarsController@show');

$router->get('/breeds', function (\App\Services\DogApiService $dogApiService) {
    return response()->json($dogApiService->getBreeds());
});
$router->get('/breeds/search/{name}', function ($name, \App\Services\DogApiService $dogApiService) {
    return response()->json($dogApiService->searchBreed($name));
});
$router->get('/api/quiz', 'QuizController@getQuestions');
$router->get('/api/quiz/categories', 'QuizController@getCategories');

$router->get('/api/schedules', 'StudyScheduleController@index');
$router->post('/api/schedules', 'StudyScheduleController@store');
$router->get('/api/schedules/{id}', 'StudyScheduleController@show');
$router->put('/api/schedules/{id}', 'StudyScheduleController@update');
$router->delete('/api/schedules/{id}', 'StudyScheduleController@destroy');

$router->get('/', function () {
    return redirect('/frontend/index.html');
});
$router->options('/{any:.*}', function () {
    return response('', 200);
});
