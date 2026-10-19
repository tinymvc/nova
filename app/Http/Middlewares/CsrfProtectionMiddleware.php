<?php

namespace App\Http\Middlewares;

use Spark\Foundation\Http\Middlewares\CsrfProtection as Middleware;
use Spark\Http\Request;

class CsrfProtectionMiddleware extends Middleware
{
    /**
     * An array of URI paths that should be excluded from CSRF verification.
     */
    protected array $except = [
        '/api/*',
        '/webhook/*',
    ];

    /**
     * Handle incoming request with testing bypass.
     */
    public function handle(Request $request, \Closure $next): mixed
    {
        // Bypass CSRF in testing environment unless explicitly enabled
        if (app()->isTesting() && empty($request->header('X-Enable-Csrf'))) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
