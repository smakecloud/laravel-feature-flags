<?php

namespace RyanChandler\LaravelFeatureFlags\Middleware;

use Closure;
use Illuminate\Http\Request;
use RyanChandler\LaravelFeatureFlags\Facades\Features;

class HasFeature
{
    public function handle(Request $request, Closure $next, string $name)
    {
        if (Features::enabled($name)) {
            return $next($request);
        }

        abort(403);
    }
}
