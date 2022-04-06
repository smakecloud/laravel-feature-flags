<?php

namespace RyanChandler\LaravelFeatureFlags;

use Illuminate\Support\Facades\Artisan;
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

        Artisan::command('feature:enable {name}', function () {
            /** @var \Illuminate\Foundation\Console\ClosureCommand $this */
            Features::enable($this->argument('name'));

            $this->info('Global flag `' . $this->argument('name') . '` enabled.');
        })->describe('Enable a global feature flag.');

        Artisan::command('feature:disable {name}', function () {
            /** @var \Illuminate\Foundation\Console\ClosureCommand $this */
            Features::disable($this->argument('name'));

            $this->info('Global flag `' . $this->argument('name') . '` disabled.');
        })->describe('Disable a global feature flag.');

        Artisan::command('feature:toggle {name}', function () {
            /** @var \Illuminate\Foundation\Console\ClosureCommand $this */
            Features::toggle($this->argument('name'));

            $this->info('Global flag `' . $this->argument('name') . '` toggled.');
        })->describe('Toggle a global feature flag.');

        Artisan::command('feature:status {name}', function () {
            /** @var \Illuminate\Foundation\Console\ClosureCommand $this */
            $name = $this->argument('name');

            $this->info('Global flag `' . $name . '` is ' . (Features::enabled($name) ? 'enabled.' : 'disabled.'));
        });
    }
}
