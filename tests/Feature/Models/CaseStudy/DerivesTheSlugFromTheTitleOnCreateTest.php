<?php

use App\Models\CaseStudy;

it('derives the slug from the title on create', function () {
    $first = CaseStudy::factory()->create(['title' => 'Porch Light Rebrand']);
    $second = CaseStudy::factory()->create(['title' => 'Porch Light Rebrand']);

    expect($first->slug)->toBe('porch-light-rebrand');
    expect($second->slug)->toBe('porch-light-rebrand-2');
});
