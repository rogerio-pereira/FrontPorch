<?php

it('smoke tests the privacy page', function () {
    visit('/privacy')
        ->assertSee('Privacy Policy')
        ->assertPresent('@privacy-heading')
        ->assertPresent('@privacy-content')
        ->assertSee('Information we collect')
        ->assertSee('Cookies and analytics');
});

it('exposes the privacy link in the site footer', function () {
    visit('/')
        ->assertPresent('@footer-privacy')
        ->assertAttributeContains('@footer-privacy', 'href', '/privacy');
});
