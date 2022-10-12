<?php

use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

use RyanChandler\LaravelFeatureFlags\Enums\MiddlewareBehaviour;
use RyanChandler\LaravelFeatureFlags\Facades\Features;

use RyanChandler\LaravelFeatureFlags\Middleware\HasFeature;

beforeEach(function () {
    Route::get('/features', function () {
    })->middleware(HasFeature::class . ':foo');

    Route::get('/multi-features', function () {
    })->middleware(HasFeature::class . ':foo,bar');
});

test('the middleware correctly aborts', function () {
    Features::enable('foo');

    get('/features')
        ->assertOk();

    Features::disable('foo');

    get('/features')
        ->assertForbidden();
});

test('the middleware correctly aborts with custom code', function () {
    config(['feature-flags.middleware.code' => 404]);

    Features::enable('foo');

    get('/features')
        ->assertOk();

    Features::disable('foo');

    get('/features')
        ->assertNotFound();
});

test('the middleware correctly redirects', function () {
    config([
        'feature-flags.middleware.behaviour' => MiddlewareBehaviour::Redirect,
        'feature-flags.middleware.redirect' => '/bar',
    ]);

    Features::enable('foo');

    get('/features')
        ->assertOk();

    Features::disable('foo');

    get('/features')
        ->assertRedirect('/bar');
});

test('the middleware allows multiple features', function () {
    Features::enable('foo');
    Features::enable('bar');

    get('/multi-features')
        ->assertOk();
});

test('the middleware correctly aborts for multiple features if one is not enabled', function () {
    Features::enable('foo');
    Features::enable('bar');

    get('/multi-features')
        ->assertOk();

    Features::disable('bar');

    get('/multi-features')
        ->assertForbidden();
});

test('the middleware correctly aborts with custom code for multiple features if one is not enabled', function () {
    config(['feature-flags.middleware.code' => 404]);

    Features::enable('foo');
    Features::enable('bar');

    get('/multi-features')
        ->assertOk();

    Features::disable('bar');

    get('/multi-features')
        ->assertNotFound();
});

test('the middleware correctly redirects for multiple features if one is not enabled', function () {
    config([
        'feature-flags.middleware.behaviour' => MiddlewareBehaviour::Redirect,
        'feature-flags.middleware.redirect' => '/bar',
    ]);

    Features::enable('foo');
    Features::enable('bar');

    get('/multi-features')
        ->assertOk();

    Features::disable('foo');

    get('/multi-features')
        ->assertRedirect('/bar');
});
