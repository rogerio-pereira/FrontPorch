<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    /**
     * Seed fake testimonials for each catalog service.
     */
    public function run(): void
    {
        $services = Service::all();

        foreach ($services as $service) {
            $count = random_int(1, 3);

            Testimonial::factory($count)
                        ->create([
                            'service_id' => $service->id,
                        ]);
        }
    }
}
