<?php

use RyanChandler\LaravelFeatureFlags\Facades\Features;

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
