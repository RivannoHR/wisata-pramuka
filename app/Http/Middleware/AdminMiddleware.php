<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is an admin
        if (auth()->user()->is_admin) {
            return $next($request);
        }

        // Redirect to a different page or show a 403 Forbidden error
        return redirect('/')->with('error', 'You do not have administrative access.');
    }
}
