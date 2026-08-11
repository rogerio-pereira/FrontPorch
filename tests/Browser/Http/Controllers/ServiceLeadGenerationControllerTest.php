<?php

beforeEach()->flaky();

it('renders the lead generation service landing page', function () {
    visit('/services/lead-generation')
        ->assertSee('More of the right people reaching out')
        ->assertVisible('@service-heading')
        ->assertVisible('@service-schedule')
        ->assertVisible('@service-hero-visual')
        ->assertVisible('@service-mid-cta')
        ->assertVisible('@service-closing-cta');
});
