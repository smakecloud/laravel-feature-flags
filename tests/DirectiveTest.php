<?php

use Illuminate\Support\Facades\Blade;
use RyanChandler\LaravelFeatureFlags\Facades\Features;

test('the @feature blade directive works', function () {
    Features::enable('foo');

    expect(Blade::render(<<<'blade'
    @feature('foo')
        Hello, world!
    @endfeature
    blade))
        ->toContain('Hello, world!');
});
