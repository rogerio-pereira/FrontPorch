<?php

beforeEach()->flaky();

it('includes analytics scripts in the page when ids are configured', function () {
    config([
        'site.google_analytics_id' => 'G-BROWSERTEST',
        'site.meta_pixel_id' => '1122334455',
    ]);

    $page = visit('/')
        ->waitForEvent('networkidle');

    $page->assertSourceHas('googletagmanager.com')
        ->assertSourceHas('G-BROWSERTEST')
        ->assertSourceHas('fbevents.js')
        ->assertSourceHas('1122334455');
});

it('does not include analytics scripts when ids are unset', function () {
    config([
        'site.google_analytics_id' => null,
        'site.meta_pixel_id' => null,
    ]);

    $page = visit('/')
        ->waitForEvent('networkidle');

    $page->assertSourceMissing('googletagmanager.com')
        ->assertSourceMissing('fbevents.js');
});
