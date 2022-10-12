<?php

use RyanChandler\LaravelFeatureFlags\Facades\Features;
use RyanChandler\LaravelFeatureFlags\Tests\Fixtures\Group;

test('all flags are returned', function () {
    Features::enable('foo');
    Features::disable('bar');
    Features::enable('baz');

    expect(Features::all())
        ->toBe([
            'foo' => true,
            'bar' => false,
            'baz' => true,
        ]);
});

test('all flags for model are returned', function () {
    $a = Group::create();
    $b = Group::create();

    Features::enable('foo', for: $a);
    Features::disable('bar', for: $a);
    Features::enable('baz', for: $b);

    expect(Features::all(for: $a))
        ->toBe([
            'foo' => true,
            'bar' => false,
        ]);
});
