<?php

namespace RyanChandler\LaravelFeatureFlags;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RyanChandler\LaravelFeatureFlags\Commands\LaravelFeatureFlagsCommand;

class LaravelFeatureFlagsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-feature-flags')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-feature-flags_table')
            ->hasCommand(LaravelFeatureFlagsCommand::class);
    }
}
