<?php

namespace RyanChandler\LaravelFeatureFlags;

use Illuminate\Database\Eloquent\Builder;
use RyanChandler\LaravelFeatureFlags\Enums\MiddlewareBehaviour;
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

    public function add(string $name, bool $enabled = false, HasFeatures $for = null): void
    {
        FeatureFlag::create([
            'flaggable_type' => $for ? $for::class : null,
            'flaggable_id' => $for?->getKey(),
            'name' => $name,
            'enabled' => $enabled,
        ]);
    }

    public function all(HasFeatures $for = null): array
    {
        return FeatureFlag::query()
            ->when(
                $for !== null,
                fn (Builder $query) =>
                $query->whereMorphedTo('flaggable', $for)
            )
            ->pluck('enabled', 'name')
            ->all();
    }

    /** @internal */
    public function getMiddlewareBehaviour(): MiddlewareBehaviour
    {
        return config('feature-flags.middleware.behaviour', MiddlewareBehaviour::Abort);
    }

    /** @internal */
    public function getMiddlewareAbortCode(): int
    {
        return (int) config('feature-flags.middleware.code', 403);
    }

    /** @internal */
    public function getMiddlewareRedirect(): ?string
    {
        return config('feature-flags.middleware.redirect');
    }
}
