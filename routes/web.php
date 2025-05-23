<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return 'Lumen is running!';
});

$router->post('/register', 'AuthController@register');
$router->post('/login', 'LoginController@login');

// Secure Wikipedia route
$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/site1', 'WikipediaController@search');
});

$router->get('/site3', 'NumbersController@getFact');
$router->get('/site4', [
    'middleware' => 'auth',
    'uses' => 'DictionaryController@lookup'
]);


// Other open routes (unchanged)




$router->get('/api/quiz', 'QuizController@getQuestions');
$router->get('/api/quiz/categories', 'QuizController@getCategories');

// Study Scheduler (protected)
$router->group(['prefix' => 'site5', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/schedules', 'StudyScheduleController@index');
    $router->post('/schedules', 'StudyScheduleController@store');
    $router->get('/schedules/{id}', 'StudyScheduleController@show');
    $router->put('/schedules/{id}', 'StudyScheduleController@update');
    $router->delete('/schedules/{id}', 'StudyScheduleController@destroy');
});


// Math site (protected)


// CORS preflight handling
$router->options('/{any:.*}', function () {
    return response('', 200);
});
