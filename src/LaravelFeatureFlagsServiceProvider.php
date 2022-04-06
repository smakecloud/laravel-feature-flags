<?php

namespace RyanChandler\LaravelFeatureFlags;

use Illuminate\Support\Facades\Blade;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelFeatureFlagsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-feature-flags')
            ->hasConfigFile()
            ->hasMigration('create_feature_flags_table');
    }

    public function packageRegistered()
    {
        $this->app->scoped(FeaturesManager::class);
    }

    public function packageBooted()
    {
        Blade::if('feature', function (string $name, HasFeatures $for = null) {
            return Features::enabled($name, for: $for);
        });
    }
}
