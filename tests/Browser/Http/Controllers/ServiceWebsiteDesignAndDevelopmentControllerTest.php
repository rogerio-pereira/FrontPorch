<?php

it('renders the website design and development service landing page', function () {
    visit('/services/website-design-and-development')
        ->assertSee('A site that looks like you')
        ->assertVisible('@service-heading')
        ->assertVisible('@service-schedule')
        ->assertVisible('@service-contact')
        ->assertVisible('@service-hero-visual')
        ->assertVisible('@service-mid-cta')
        ->assertVisible('@service-closing-cta');
});
