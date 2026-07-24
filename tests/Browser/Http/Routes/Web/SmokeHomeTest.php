<?php

it('smoke tests the home page', function () {
    visit('/')
        ->assertSee('Log in');
});
