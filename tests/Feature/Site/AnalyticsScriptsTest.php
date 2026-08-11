<?php

it('does not include analytics scripts when ids are unset', function () {
    config([
        'site.google_analytics_id' => null,
        'site.meta_pixel_id' => null,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertDontSee('googletagmanager.com', false);
    $response->assertDontSee('fbevents.js', false);
    $response->assertDontSee('G-TEST', false);
});

it('does not include analytics scripts when ids are empty', function () {
    config([
        'site.google_analytics_id' => '',
        'site.meta_pixel_id' => '',
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertDontSee('googletagmanager.com', false);
    $response->assertDontSee('fbevents.js', false);
});

it('includes analytics scripts when ids are configured', function () {
    config([
        'site.google_analytics_id' => 'G-TEST1234',
        'site.meta_pixel_id' => '9876543210',
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('googletagmanager.com', false);
    $response->assertSee('G-TEST1234', false);
    $response->assertSee('fbevents.js', false);
    $response->assertSee('9876543210', false);
});
