<?php

it('redirects guests from dashboard to login', function () {
    visit('/dashboard')
        ->assertPathIs('/login');
});
