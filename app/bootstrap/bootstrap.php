<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// setlocale(LC_COLLATE, 'uk_UA.utf8');

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use App\Middleware\AuthMiddleware;
use App\Services\ViteService;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();
// var_dump($_ENV); 
// Setting up Eloquent
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => getenv('DB_CONNECTION') ?: 'mysql',
    'host' => getenv('DB_HOST') ?: 'db',
    'database' => getenv('DB_DATABASE') ?: 'movies_db',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: 'root',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_0900_ai_ci',
    'prefix' => getenv('DB_PREFIX') ?: '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Create a container, router and event dispatcher
$container = new Container;
$events = new Dispatcher($container);
$router = new Router($events, $container);

// Defining controllers
define('CONTROLLER_NAMESPACE', 'App\\Controllers\\');
function controller($className)
{
    return CONTROLLER_NAMESPACE . $className;
}

function app($make = null)
{
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
