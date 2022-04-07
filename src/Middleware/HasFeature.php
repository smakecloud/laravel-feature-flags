<?php

namespace RyanChandler\LaravelFeatureFlags\Middleware;

use Closure;
use Illuminate\Http\Request;
use RyanChandler\LaravelFeatureFlags\Enums\MiddlewareBehaviour;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\FeaturesManager;

class HasFeature
{
    public function __construct(
        protected FeaturesManager $features
    ) {
    }

    public function handle(Request $request, Closure $next, string ...$features)
    {
        foreach ($features as $feature) {
            if (! Features::enabled($feature)) {
                if ($this->features->getMiddlewareBehaviour() === MiddlewareBehaviour::Abort) {
                    abort($this->features->getMiddlewareAbortCode());
                }

                return redirect()->to($this->features->getMiddlewareRedirect());
            }
        }

        return $next($request);
    }
}
