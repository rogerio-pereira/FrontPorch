<?php

it('exposes the contact anchor for navigation', function () {
    visit('/')
        ->assertPresent('@nav-contact');
});
