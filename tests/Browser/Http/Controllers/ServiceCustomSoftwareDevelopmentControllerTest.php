<?php

beforeEach()->flaky();

it('renders the custom software development service landing page', function () {
    visit('/services/custom-software-development')
        ->assertSee('When ready-made tools do not fit')
        ->assertVisible('@service-heading')
        ->assertVisible('@service-schedule')
        ->assertVisible('@service-hero-visual')
        ->assertVisible('@service-mid-cta')
        ->assertVisible('@service-closing-cta');
});
