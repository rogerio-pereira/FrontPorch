<?php

use App\Models\CaseStudy;

it('keeps the slug when the title is unchanged', function () {
    $caseStudy = CaseStudy::factory()->create(['title' => 'Porch Light Rebrand']);

    $caseStudy->update(['client' => 'Porch Light Co.']);

    expect($caseStudy->slug)->toBe('porch-light-rebrand');
});
