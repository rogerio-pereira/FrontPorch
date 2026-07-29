<?php

use App\Models\CaseStudy;

it('regenerates the slug when the title changes', function () {
    $caseStudy = CaseStudy::factory()->create(['title' => 'Porch Light Rebrand']);

    $caseStudy->update(['title' => 'Front Door Refresh']);

    expect($caseStudy->slug)->toBe('front-door-refresh');
});
