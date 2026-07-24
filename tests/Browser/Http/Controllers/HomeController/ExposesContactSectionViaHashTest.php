<?php

it('exposes the contact section via hash', function () {
    visit('/#contact')
        ->assertSee('We would love to hear from you')
        ->assertPresent('@home-contact-schedule');
});
