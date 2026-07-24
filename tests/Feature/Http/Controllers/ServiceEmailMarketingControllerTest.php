<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders the email marketing service landing page', function () {
    $this->get('/services/email-marketing')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('service-email-marketing/ServiceEmailMarketing')
        );
});
