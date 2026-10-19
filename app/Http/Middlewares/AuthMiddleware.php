<?php

namespace App\Http\Middlewares;

use Spark\Foundation\Http\Middlewares\AuthMiddleware as Middleware;
use Spark\Http\Request;

class AuthMiddleware extends Middleware
{
    /**
     * Handle an unauthenticated request.
     */
    protected function failed(Request $request, array $guards): mixed
    {
        if ($request->expectsJson()) {
            abort(401, 'Unauthenticated.');
        }

        return redirect(route('login'));
    }
}