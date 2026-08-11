<?php

use App\Models\CaseStudy;

it('uses the first gallery image as cover', function () {
    $caseStudy = CaseStudy::factory()
                    ->withImages(3)
                    ->create();

    $cover = $caseStudy->coverImage();
    $sortOrders = $caseStudy->images()
                    ->pluck('sort_order')
                    ->all();

    expect($cover)->not->toBeNull();
    expect($cover->sort_order)->toBe(0);
    expect($sortOrders)->toBe([0, 1, 2]);
});
