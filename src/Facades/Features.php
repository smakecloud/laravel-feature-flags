<?php

namespace RyanChandler\LaravelFeatureFlags\Facades;

use Illuminate\Support\Facades\Facade;
use RyanChandler\LaravelFeatureFlags\FeaturesManager;

/**
 * @see \RyanChandler\LaravelFeatureFlags\FeaturesManager
 */
class Features extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeaturesManager::class;
    }
}
