<?php

use Inertia\Testing\AssertableInertia as Assert;

it('does not share analytics ids when unset', function () {
    config([
        'site.google_analytics_id' => null,
        'site.meta_pixel_id' => null,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->where('site.googleAnalyticsId', null)
        ->where('site.metaPixelId', null)
    );
    $response->assertDontSee('googletagmanager.com', false);
    $response->assertDontSee('fbevents.js', false);
    $response->assertDontSee('G-TEST', false);
});

it('treats empty analytics ids as unset', function () {
    config([
        'site.google_analytics_id' => '',
        'site.meta_pixel_id' => '',
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->where('site.googleAnalyticsId', null)
        ->where('site.metaPixelId', null)
    );
});

it('shares analytics ids when configured', function () {
    config([
        'site.google_analytics_id' => 'G-TEST1234',
        'site.meta_pixel_id' => '9876543210',
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->where('site.googleAnalyticsId', 'G-TEST1234')
        ->where('site.metaPixelId', '9876543210')
    );
    $response->assertSee('G-TEST1234', false);
    $response->assertSee('9876543210', false);
});
