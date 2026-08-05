<?php

it('injects analytics script tags when ids are configured', function () {
    config([
        'site.google_analytics_id' => 'G-BROWSERTEST',
        'site.meta_pixel_id' => '1122334455',
    ]);

    $page = visit('/')
        ->waitForEvent('networkidle');

    $page->assertSourceHas('G-BROWSERTEST')
        ->assertSourceHas('1122334455')
        ->assertScript('document.getElementById("ga-gtag-js") !== null', true)
        ->assertScript('document.getElementById("meta-pixel-js") !== null', true);
});

it('does not inject analytics script tags when ids are unset', function () {
    config([
        'site.google_analytics_id' => null,
        'site.meta_pixel_id' => null,
    ]);

    $page = visit('/')
        ->waitForEvent('networkidle');

    $page->assertScript('document.getElementById("ga-gtag-js") === null', true)
        ->assertScript('document.getElementById("meta-pixel-js") === null', true);
});
