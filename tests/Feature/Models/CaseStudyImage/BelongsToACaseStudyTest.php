<?php

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;

it('belongs to a case study', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $image = CaseStudyImage::factory()
                ->for($caseStudy)
                ->cover()
                ->create();

    $sortOrder = $image->sort_order;
    $parentId = $image->caseStudy->id;

    expect($sortOrder)->toBe(0);
    expect($parentId)->toBe($caseStudy->id);
});
