<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the lead generation service landing page', function () {
    $this->get('/services/lead-generation')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-lead-generation/ServiceLeadGeneration')
        );
});
