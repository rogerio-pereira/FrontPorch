<?php

beforeEach()->flaky();

it('smoke tests the home page', function () {
    visit('/')
        ->assertSee('You do great work')
        ->assertPresent('@home-hero-headline');
});
