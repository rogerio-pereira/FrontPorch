<?php

beforeEach()->flaky();

it('smoke tests the privacy page', function () {
    visit('/privacy')
        ->assertSee('Privacy Policy')
        ->assertPresent('@privacy-heading')
        ->assertPresent('@privacy-content')
        ->assertSee('Information we collect')
        ->assertSee('The service(s) you are interested in')
        ->assertSee('Cookies and analytics')
        ->assertSee('we do not show a cookie consent banner')
        ->assertDontSee('Analytics scripts load only after you accept');
});

it('exposes the privacy link in the site footer', function () {
    visit('/')
        ->assertPresent('@footer-privacy')
        ->assertAttributeContains('@footer-privacy', 'href', '/privacy');
});
