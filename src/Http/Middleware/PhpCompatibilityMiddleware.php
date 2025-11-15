<?php

namespace nplesa\Tracker\Http\Middleware;

use Closure;
use nplesa\Tracker\Services\PhpCompatibilityScanner;

class PhpCompatibilityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!config('tracker.middleware_enabled')) {
            return $next($request);
        }

        $scanner = new PhpCompatibilityScanner();
        $missing = $scanner->checkExtensions();

        if ($missing) {
            abort(503, "Missing PHP extensions: " . implode(', ', $missing));
        }

        return $next($request);
    }
}
