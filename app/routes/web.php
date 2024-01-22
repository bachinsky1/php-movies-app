<?php

use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;


$router->group(['middleware' => AuthMiddleware::class], function ($router) {
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/import-movies', [HomeController::class, 'importMovies']);
    $router->post('/search-by-title', [HomeController::class, 'searchByTitle']);
    $router->post('/search-by-actor', [HomeController::class, 'searchByActor']);
    $router->post('/delete-movie/{id}', [HomeController::class, 'deleteMovie']);
    $router->get('/movie-info/{id}', [HomeController::class, 'getMovieInfo']);
    $router->post('/add-movie', [HomeController::class, 'addMovie']);
});

$router->get('/login', [HomeController::class, 'login']);
$router->post('/login', [HomeController::class, 'authenticate']);
$router->get('/logout', [HomeController::class, 'logout']);

