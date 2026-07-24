<?php

it('smoke tests the portfolio study case page', function () {
    visit('/portfolio/study-case/1')
        ->assertSee('From missed calls to booked jobs')
        ->assertPresent('@study-case-heading')
        ->assertPresent('@study-case-challenge')
        ->assertPresent('@study-case-solution')
        ->assertPresent('@study-case-carousel')
        ->assertPresent('@study-case-quote')
        ->assertPresent('@study-case-closing');
});
