<?php

namespace RyanChandler\LaravelFeatureFlags;

use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;
use RyanChandler\LaravelFeatureFlags\Models\FeatureFlag;

class FeaturesManager
{
    public function enabled(string $name, HasFeatures $for = null): bool
    {
        return (bool) FeatureFlag::query()->for($for)->name($name)->first()?->enabled;
    }

    public function disabled(string $name, HasFeatures $for = null): bool
    {
        return ! $this->enabled($name, $for);
    }

    public function enable(string $name, HasFeatures $for = null): void
    {
        FeatureFlag::query()->updateOrCreate([
            'flaggable_type' => $for ? $for::class : null,
            'flaggable_id' => $for?->getKey(),
            'name' => $name,
        ], [
            'enabled' => true,
        ]);
    }

    public function disable(string $name, HasFeatures $for = null): void
    {
        FeatureFlag::query()->updateOrCreate([
            'flaggable_type' => $for ? $for::class : null,
            'flaggable_id' => $for?->getKey(),
            'name' => $name,
        ], [
            'enabled' => false,
        ]);
    }

    public function toggle(string $name, HasFeatures $for = null): void
    {
        $flag = FeatureFlag::query()->firstOrCreate([
            'flaggable_type' => $for ? $for::class : null,
            'flaggable_id' => $for?->getKey(),
            'name' => $name,
        ], [
            'enabled' => false,
        ]);

        $flag->enabled = ! $flag->enabled;
        $flag->save();
    }
}
