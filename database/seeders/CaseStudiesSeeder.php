<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Database\Seeder;

class CaseStudiesSeeder extends Seeder
{
    /**
     * Seed fake case studies for each catalog service.
     */
    public function run(): void
    {
        $services = Service::all();

        foreach ($services as $service) {
            $count = random_int(1, 2);

            $caseStudies = CaseStudy::factory($count)
                            ->withImages(2)
                            ->create();

            foreach ($caseStudies as $caseStudy) {
                $caseStudy->services()->attach($service->id);
            }
        }
    }
}
