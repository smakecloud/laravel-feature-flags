<?php

namespace RyanChandler\LaravelFeatureFlags\Facades;

use Illuminate\Support\Facades\Facade;
use RyanChandler\LaravelFeatureFlags\FeaturesManager;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

/**
 * @method static bool enabled(string $name, HasFeatures $for = null)
 * @method static bool disabled(string $name, HasFeatures $for = null)
 * @method static void enable(string $name, HasFeatures $for = null)
 * @method static void disable(string $name, HasFeatures $for = null)
 * @method static void toggle(string $name, HasFeatures $for = null)
 * @method static void add(string $name, HasFeatures $for = null)
 *
 * @see \RyanChandler\LaravelFeatureFlags\FeaturesManager
 */
class Features extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FeaturesManager::class;
    }
}
