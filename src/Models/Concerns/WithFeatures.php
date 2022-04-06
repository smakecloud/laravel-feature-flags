<?php

namespace RyanChandler\LaravelFeatureFlags\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\Models\FeatureFlag;

/**
 * @mixin \Illuminate\Database\Eloquent\Model & \RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures
 */
trait WithFeatures
{
    public function features(): MorphMany
    {
        return $this->morphMany(FeatureFlag::class);
    }

    public function enableFeature(string $name): void
    {
        Features::enable($name, for: $this);
    }

    public function disableFeature(string $name): void
    {
        Features::disable($name, for: $this);
    }

    public function toggleFeature(string $name): void
    {
        Features::toggle($name, for: $this);
    }
}
