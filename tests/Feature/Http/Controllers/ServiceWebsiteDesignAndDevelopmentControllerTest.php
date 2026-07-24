<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the website design and development service landing page', function () {
    $this->get('/services/website-design-and-development')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-website-design-and-development/ServiceWebsiteDesignAndDevelopment')
        );
});
