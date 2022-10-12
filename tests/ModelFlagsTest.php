<?php

use function Pest\Laravel\assertDatabaseHas;

use RyanChandler\LaravelFeatureFlags\Facades\Features;

use RyanChandler\LaravelFeatureFlags\Tests\Fixtures\Group;

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

test('a model flag can be added', function () {
    $group = Group::create();

    Features::add('foo', for: $group);

    assertDatabaseHas('feature_flags', [
        'flaggable_type' => Group::class,
        'flaggable_id' => $group->getKey(),
        'name' => 'foo',
        'enabled' => false,
    ]);
});
