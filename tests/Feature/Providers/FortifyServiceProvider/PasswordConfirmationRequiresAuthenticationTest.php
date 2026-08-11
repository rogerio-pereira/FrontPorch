<?php

it('password confirmation requires authentication', function () {
    $this->get(route('password.confirm'))
        ->assertRedirect(route('login'));
});
