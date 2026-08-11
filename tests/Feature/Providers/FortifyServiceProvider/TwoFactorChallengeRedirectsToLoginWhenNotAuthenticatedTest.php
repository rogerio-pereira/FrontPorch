<?php

use Laravel\Fortify\Features;

it('two factor challenge redirects to login when not authenticated', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    $this->get(route('two-factor.login'))
        ->assertRedirect(route('login'));
});
