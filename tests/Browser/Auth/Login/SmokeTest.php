<?php

beforeEach()->flaky();

it('smoke tests the login page', function () {
    visit('/login')
        ->assertSee('Email address')
        ->assertPresent('@login-button');
});
