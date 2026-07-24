<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the custom software development service landing page', function () {
    $this->get('/services/custom-software-development')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-custom-software-development/ServiceCustomSoftwareDevelopment')
        );
});
