<?php

it('renders the business automations service landing page', function () {
    visit('/services/business-automations')
        ->assertSee('Give the copy-paste work to the system')
        ->assertVisible('@service-heading')
        ->assertVisible('@service-schedule')
        ->assertVisible('@service-hero-visual')
        ->assertVisible('@service-mid-cta')
        ->assertVisible('@service-closing-cta');
});
