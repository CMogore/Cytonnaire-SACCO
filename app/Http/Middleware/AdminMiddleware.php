<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the "admin" role
        if ($request->user() && $request->user()->role_id === 2) {
            return $next($request);
        }

        // If not an admin, return an error response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
