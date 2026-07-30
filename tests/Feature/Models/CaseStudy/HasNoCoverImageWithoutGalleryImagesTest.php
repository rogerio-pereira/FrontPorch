<?php

use App\Models\CaseStudy;

it('has no cover image without gallery images', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $cover = $caseStudy->coverImage();

    expect($cover)->toBeNull();
});
