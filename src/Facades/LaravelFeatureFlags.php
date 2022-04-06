<?php

namespace RyanChandler\LaravelFeatureFlags\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RyanChandler\LaravelFeatureFlags\LaravelFeatureFlags
 */
class LaravelFeatureFlags extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-feature-flags';
    }
}
