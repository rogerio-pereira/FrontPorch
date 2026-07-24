<?php

it('smoke tests the portfolio page', function () {
    visit('/portfolio')
        ->assertSee('Case studies that show the path')
        ->assertPresent('@portfolio-heading')
        ->assertPresent('@portfolio-case-1');
});
