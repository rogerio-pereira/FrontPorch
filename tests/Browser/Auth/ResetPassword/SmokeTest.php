<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Features;

it('smoke tests the reset password page', function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());

    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    visit('/reset-password/'.$token.'?email='.urlencode($user->email))
        ->assertSee('Reset password')
        ->assertSee('Email')
        ->assertPresent('@reset-password-button');
});
