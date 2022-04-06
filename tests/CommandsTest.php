<?php

use Illuminate\Support\Facades\Artisan;
use RyanChandler\LaravelFeatureFlags\Facades\Features;

use function Pest\Laravel\artisan;

test('feature:enable command works', function () {
    artisan('feature:enable', ['name' => 'foo']);

    expect(Features::enabled('foo'))->toBeTrue();
});

test('feature:toggle command works', function () {
    artisan('feature:toggle', ['name' => 'foo']);

    expect(Features::enabled('foo'))->toBeTrue();

    artisan('feature:toggle', ['name' => 'foo']);

    expect(Features::disabled('foo'))->toBeTrue();
});
