<?php

namespace RyanChandler\LaravelFeatureFlags;

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
}
