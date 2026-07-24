<?php

use Laravel\Fortify\Features;

it('reset password link screen can be rendered', function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());

    $this->get(route('password.request'))->assertOk();
});
