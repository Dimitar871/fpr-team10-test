<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEmployee
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isEmployee()) {
            return $next($request);
        }

        abort(403, 'Unauthorized: Only employees can access this page.');
    }
}
