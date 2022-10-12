<?php

use RyanChandler\LaravelFeatureFlags\Facades\Features;

use function Pest\Laravel\assertDatabaseHas;

test('global flags can be enabled', function () {
    expect(Features::enabled('foo'))->toBeFalse();

    Features::enable('foo');

    expect(Features::enabled('foo'))->toBeTrue();
});

test('global flags can be disabled', function () {
    Features::enable('foo');

    expect(Features::enabled('foo'))->toBeTrue();

    Features::disable('foo');

    expect(Features::disabled('foo'))->toBeTrue();
});

test('global flags can be toggled', function () {
    Features::toggle('foo');

    expect(Features::enabled('foo'))->toBeTrue();

    Features::toggle('foo');

    expect(Features::enabled('foo'))->toBeFalse();
});

test('global flags can be added', function () {
    Features::add('foo');

    assertDatabaseHas('feature_flags', [
        'name' => 'foo',
        'enabled' => false,
    ]);
});
