<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the "admin" role
        if ($request->user() ) {
            return $next($request);
        }

        // If not an admin, redirect or return an error response
        return response()->json(['error' => 'Unauthorized not authenticated'], 403);
    }
}
