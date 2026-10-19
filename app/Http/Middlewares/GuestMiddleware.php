<?php

namespace App\Http\Middlewares;

use Spark\Contracts\Http\MiddlewareInterface;
use Spark\Facades\Auth;
use Spark\Http\Request;

class GuestMiddleware implements MiddlewareInterface
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next, string $guard = 'default'): mixed
    {
        if (Auth::guard($guard)->check()) {
            if ($request->expectsJson()) {
                abort(400, 'Already authenticated.');
            }

            return redirect(route('dashboard'));
        }

        return $next($request);
    }
}
