<?php

use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use RyanChandler\LaravelFeatureFlags\Enums\MiddlewareBehaviour;
use RyanChandler\LaravelFeatureFlags\Facades\Features;

use RyanChandler\LaravelFeatureFlags\Middleware\HasFeature;

beforeEach(function () {
    Route::get('/features', function () {
    })->middleware(HasFeature::class . ':foo');
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
