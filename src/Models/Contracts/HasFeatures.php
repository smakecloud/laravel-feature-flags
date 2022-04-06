<?php

namespace RyanChandler\LaravelFeatureFlags\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use RyanChandler\LaravelFeatureFlags\Models\FeatureFlag;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
interface HasFeatures
{
    /**
     * @return MorphMany<FeatureFlag>
     */
    public function features(): MorphMany;
}
