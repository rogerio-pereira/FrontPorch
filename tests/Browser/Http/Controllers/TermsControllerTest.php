<?php

beforeEach()->flaky();

it('smoke tests the terms page', function () {
    visit('/terms')
        ->assertSee('Terms of Service')
        ->assertPresent('@terms-heading')
        ->assertPresent('@terms-content')
        ->assertSee('No guarantee of results')
        ->assertSee('Governing law');
});

it('exposes the terms link in the site footer', function () {
    visit('/')
        ->assertPresent('@footer-terms')
        ->assertAttributeContains('@footer-terms', 'href', '/terms');
});
