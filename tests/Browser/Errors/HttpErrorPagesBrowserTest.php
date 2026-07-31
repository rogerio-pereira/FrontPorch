<?php

use Illuminate\Support\Facades\Route;

it('shows the branded 404 page in the browser', function () {
    visit('/this-page-does-not-exist-front-porch')
        ->waitForEvent('networkidle')
        ->assertSee('This page is not on the porch')
        ->assertPresent('@error-home')
        ->assertPresent('@error-contact')
        ->assertDontSee('Stack');
});

it('shows the branded 500 page in the browser', function () {
    Route::get('/__http-error-500', function () {
        abort(500);
    });

    visit('/__http-error-500')
        ->waitForEvent('networkidle')
        ->assertSee('Something went sideways on the porch')
        ->assertPresent('@error-home')
        ->assertDontSee('Stack');
});

it('shows the branded 503 page in the browser', function () {
    Route::get('/__http-error-503', function () {
        abort(503);
    });

    visit('/__http-error-503')
        ->waitForEvent('networkidle')
        ->assertSee('We will be right back')
        ->assertPresent('@error-home')
        ->assertDontSee('Stack');
});
