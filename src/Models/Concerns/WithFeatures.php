<?php

namespace RyanChandler\LaravelFeatureFlags\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
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
}
