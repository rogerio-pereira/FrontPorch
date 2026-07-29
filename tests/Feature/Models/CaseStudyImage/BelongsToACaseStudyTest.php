<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;

it('belongs to a case study', function () {
    $caseStudy = CaseStudy::factory()->create();

    $image = CaseStudyImage::factory()->for($caseStudy)->cover()->create();

    expect($image->sort_order)->toBe(0);
    expect($image->caseStudy->id)->toBe($caseStudy->id);
});
