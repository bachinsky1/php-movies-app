<?php
namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authorized = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
        $currentPath = $request->path();
        // var_dump($authorized);
        if (!$authorized && !in_array($currentPath, ['login', 'import-movies'])) {
            // The user is not authorized, send him to the login page
            return new Response('Unauthorized', 302, ['Location' => '/login']);
        }

        // The user is authorized, we continue processing the request
        return $next($request);
    }
}
