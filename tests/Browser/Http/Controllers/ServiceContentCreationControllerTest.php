<?php

beforeEach()->flaky();

it('renders the content creation service landing page', function () {
    visit('/services/content-creation')
        ->assertSee('Blog posts and social writing')
        ->assertVisible('@service-heading')
        ->assertVisible('@service-schedule')
        ->assertVisible('@service-hero-visual')
        ->assertVisible('@service-mid-cta')
        ->assertVisible('@service-closing-cta');
});
