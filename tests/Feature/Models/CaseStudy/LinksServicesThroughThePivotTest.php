<?php

use App\Models\CaseStudy;
use App\Models\Service;

it('links services through the pivot', function () {
    $caseStudy = CaseStudy::factory()->create();
    $services = Service::factory()->count(2)->create();

    $caseStudy->services()->sync($services->pluck('id'));

    expect($caseStudy->services()->pluck('services.id')->sort()->values()->all())
        ->toBe($services->pluck('id')->sort()->values()->all());

    $this->assertDatabaseCount('case_study_service', 2);
});
