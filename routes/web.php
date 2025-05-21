<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return 'Lumen is running!';
});

$router->get('/site1', ['middleware' => 'auth:api', 'uses' => 'WikipediaController@search']);


$router->get('/codewars/{username}', 'CodewarsController@show');

$router->get('/breeds', function (\App\Services\DogApiService $dogApiService) {
    return response()->json($dogApiService->getBreeds());
});
$router->get('/breeds/search/{name}', function ($name, \App\Services\DogApiService $dogApiService) {
    return response()->json($dogApiService->searchBreed($name));
});
$router->get('/api/quiz', 'QuizController@getQuestions');
$router->get('/api/quiz/categories', 'QuizController@getCategories');
$router->post('/login', 'LoginController@login');


$router->get('/api/schedules', 'StudyScheduleController@index');
$router->post('/api/schedules', 'StudyScheduleController@store');
$router->get('/api/schedules/{id}', 'StudyScheduleController@show');
$router->put('/api/schedules/{id}', 'StudyScheduleController@update');
$router->delete('/api/schedules/{id}', 'StudyScheduleController@destroy');
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

// Example of a protected route
$router->get('/user-info', ['middleware' => 'auth:api', function () {
    return auth()->user();
}]);


$router->get('/site4', [
    'middleware' => 'auth:api',
    'uses' => 'MathController@evaluate'
]);




$router->get('/', function () {
    return redirect('/frontend/index.html');
});
$router->options('/{any:.*}', function () {
    return response('', 200);
});
