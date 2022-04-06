<?php

namespace RyanChandler\LaravelFeatureFlags\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

/**
 * @property      string    $name
 * @property      bool      $enabled
 * @property-read string    $flaggable_type
 * @property-read int       $flaggable_id
 */
class FeatureFlag extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'bool',
    ];

    public function flaggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeName(Builder $query, string $name): void
    {
        $query->where('name', $name);
    }

    public function scopeFor(Builder $query, ?HasFeatures $for): void
    {
        $query->when(
            $for,
            fn (Builder $query) => $query->whereMorphedTo('flaggable', $for),
            default: fn (Builder $query) => $query->where([
                'flaggable_type' => null,
                'flaggable_id' => null,
            ])
        );
    }
}
