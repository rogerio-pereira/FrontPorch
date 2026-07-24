<?php

it('renders email marketing without inventing a reality section heading from lead gen', function () {
    visit('/services/email-marketing')
        ->assertSee('Stay in touch in a way that feels human')
        ->assertDontSee('Busy online, quiet inbox')
        ->assertVisible('@service-schedule');
});
