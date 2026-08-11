<?php

use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
    $response = $this->get('/terms');

    $response->assertOk();
});

it('renders the terms page', function () {
    $response = $this->get('/terms');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('terms/Terms')
    );
});
