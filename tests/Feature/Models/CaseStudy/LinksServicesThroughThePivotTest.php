<?php

use App\Models\CaseStudy;
use App\Models\Service;

it('links services through the pivot', function () {
    $caseStudy = CaseStudy::factory()
                    ->create();

    $services = Service::factory()
                    ->count(2)
                    ->create();

    $serviceIds = $services->pluck('id');

    $caseStudy->services()->sync($serviceIds);

    $linkedIds = $caseStudy->services()
                    ->pluck('services.id')
                    ->sort()
                    ->values()
                    ->all();

    $expectedIds = $serviceIds
                    ->sort()
                    ->values()
                    ->all();

    expect($linkedIds)->toBe($expectedIds);

    $this->assertDatabaseCount('case_study_service', 2);
});
