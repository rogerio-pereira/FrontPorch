<?php

use App\Models\CaseStudy;

it('uses the first gallery image as cover', function () {
    $caseStudy = CaseStudy::factory()->withImages(3)->create();

    $cover = $caseStudy->coverImage();

    expect($cover)->not->toBeNull();
    expect($cover->sort_order)->toBe(0);
    expect($caseStudy->images()->pluck('sort_order')->all())->toBe([0, 1, 2]);
});
