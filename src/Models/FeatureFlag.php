<?php

namespace RyanChandler\LaravelFeatureFlags\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

class FeatureFlag extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'bool',
    ];

    public function flaggable()
    {
        return $this->morphTo();
    }

    public function scopeName(Builder $query, string $name): void
    {
        $query->where('name', $name);
    }

    public function scopeFor(Builder $query, ?HasFeatures $for): void
    {
        $query->when($for,
            fn (Builder $query) => $query->whereMorphedTo('flaggable', $for),
            default: fn (Builder $query) => $query->where([
                'flaggable_type' => null,
                'flaggable_id' => null,
            ])
        );
    }
}
