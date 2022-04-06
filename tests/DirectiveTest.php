<?php

use Illuminate\Support\Facades\Blade;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\Tests\Fixtures\Group;

test('the @feature blade directive works', function () {
    Features::enable('foo');

    expect(Blade::render(<<<'blade'
    @feature('foo')
        Hello, world!
    @endfeature
    blade))
        ->toContain('Hello, world!');
});

test('the @feature blade directive works for models', function () {
    $group = Group::create();

    Features::enable('foo', for: $group);

    expect(Blade::render(<<<'blade'
    @feature('foo', $group)
        Hello, world!
    @endfeature
    blade, ['group' => $group]))
        ->toContain('Hello, world!');

    expect(Blade::render(<<<'blade'
    @feature('foo', for: $group)
        Hello, world!
    @endfeature
    blade, ['group' => $group]))
        ->toContain('Hello, world!');
});
