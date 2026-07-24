<?php

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Features;

it('two factor challenge is rate limited', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->withTwoFactor()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    RateLimiter::increment(md5('two-factor'.$user->id), amount: 5);

    $response = $this->post(route('two-factor.login.store'), [
        'code' => '000000',
    ]);

    $response->assertTooManyRequests();
});
