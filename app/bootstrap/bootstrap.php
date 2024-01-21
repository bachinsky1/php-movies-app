<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use App\Middleware\AuthMiddleware;
use App\Services\ViteService;

// Setting up Eloquent
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => $_ENV['DB_CHARSET'],
    'collation' => $_ENV['DB_COLLATION'],
    'prefix'    => $_ENV['DB_PREFIX'],
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Create a container, router and event dispatcher
$container = new Container;
$events = new Dispatcher($container);
$router = new Router($events, $container);

// Defining controllers
define('CONTROLLER_NAMESPACE', 'App\\Controllers\\');
function controller($className) {
    return CONTROLLER_NAMESPACE . $className;
}

function app($make = null) {
    global $container;
    if (!is_null($make)) {
        return $container->make($make);
    }
    return $container;
}

$container->singleton('ViteService', function ($container) {
    return new ViteService();
});

// Import routes
require __DIR__ . '/../routes/web.php';

// Create a request object from PHP global variables
$request = Request::capture();

// Creating and setting up a pipeline for middleware
$pipeline = new Pipeline($container);

// Processing the request through the middleware pipeline and router
$response = $pipeline->send($request)
    ->through([
        AuthMiddleware::class,
    ])
    ->then(function ($request) use ($router) {
        return $router->dispatch($request);
    });

// Send a response to the client
$response->send();
