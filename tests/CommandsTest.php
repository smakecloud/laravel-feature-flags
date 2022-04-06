<?php

use function Pest\Laravel\artisan;

use RyanChandler\LaravelFeatureFlags\Facades\Features;

test('feature:enable command works', function () {
    artisan('feature:enable', ['name' => 'foo']);

    expect(Features::enabled('foo'))->toBeTrue();
});

test('feature:disable command works', function () {
    artisan('feature:disable', ['name' => 'foo']);

    expect(Features::disabled('foo'))->toBeTrue();
});

test('feature:toggle command works', function () {
    artisan('feature:toggle', ['name' => 'foo']);

    expect(Features::enabled('foo'))->toBeTrue();

    artisan('feature:toggle', ['name' => 'foo']);

    expect(Features::disabled('foo'))->toBeTrue();
});
