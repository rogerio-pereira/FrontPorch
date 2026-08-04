<?php

use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
    $response = $this->get('/privacy');

    $response->assertOk();
});

it('renders the privacy page', function () {
    $response = $this->get('/privacy');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('privacy/Privacy')
    );
});
