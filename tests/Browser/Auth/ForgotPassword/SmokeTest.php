<?php

use Laravel\Fortify\Features;

it('smoke tests the forgot password page', function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());

    visit('/forgot-password')
        ->assertSee('Forgot password')
        ->assertSee('Email address')
        ->assertPresent('@email-password-reset-link-button');
});
