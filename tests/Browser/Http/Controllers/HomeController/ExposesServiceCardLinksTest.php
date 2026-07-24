<?php

it('exposes service card links on the home page', function () {
    visit('/')
        ->assertPresent('@home-service-lead-generation')
        ->assertPresent('@home-service-email-marketing')
        ->assertPresent('@home-service-website-design-and-development');
});
