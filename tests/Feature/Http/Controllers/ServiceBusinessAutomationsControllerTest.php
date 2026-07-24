<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the business automations service landing page', function () {
    $this->get('/services/business-automations')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-business-automations/ServiceBusinessAutomations')
        );
});
