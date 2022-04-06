<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\Models\Concerns\WithFeatures;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

class Group extends Model implements HasFeatures
{
    use WithFeatures;

    public static function booted()
    {
        if (! Schema::hasTable('groups')) {
            Schema::create('groups', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }
    }
}

test('a model flag can be enabled', function () {
    $group = Group::create();

    expect(Features::enabled('foo', for: $group))->toBeFalse();

    Features::enable('foo', for: $group);

    expect(Features::enabled('foo', for: $group))->toBeTrue();
    expect(Features::enabled('foo'))->toBeFalse();
});

test('a model flag can be disabled', function () {
    $group = Group::create();

    Features::enable('foo', for: $group);

    expect(Features::enabled('foo', for: $group))->toBeTrue();

    Features::disable('foo', for: $group);

    expect(Features::enabled('foo', for: $group))->toBeFalse();
    expect(Features::disabled('foo', for: $group))->toBeTrue();
});

test('a model flag can be toggled', function () {
    $group = Group::create();

    Features::toggle('foo', for: $group);

    expect(Features::enabled('foo', for: $group))->toBeTrue();

    Features::toggle('foo', for: $group);

    expect(Features::enabled('foo', for: $group))->toBeFalse();
    expect(Features::disabled('foo', for: $group))->toBeTrue();
});
