<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    /**
     * Seed the testimonials sampled on the home page and service landings.
     */
    public function run(): void
    {
        foreach ($this->testimonials() as $testimonial) {
            $service = Service::where('slug', $testimonial['service'])->first();

            if ($service === null) {
                continue;
            }

            Testimonial::updateOrCreate(
                ['testimonial' => $testimonial['testimonial']],
                [
                    'person' => $testimonial['person'],
                    'service_id' => $service->id,
                ],
            );
        }
    }

    /**
     * @return list<array{person: string, testimonial: string, service: string}>
     */
    protected function testimonials(): array
    {
        return [
            [
                'person' => 'What we aim for',
                'testimonial' => 'They actually listened, and explained things in a way that made sense.',
                'service' => 'website-design-and-development',
            ],
            [
                'person' => 'What we aim for',
                'testimonial' => 'We always knew what was happening next. No surprises.',
                'service' => 'lead-generation',
            ],
            [
                'person' => 'Owner, Plant City lawn care',
                'testimonial' => 'The calls we get now are from people who already know what we do and what it costs.',
                'service' => 'lead-generation',
            ],
            [
                'person' => 'Owner, Lakeland boutique',
                'testimonial' => 'Our monthly email brings people back into the shop without feeling pushy.',
                'service' => 'email-marketing',
            ],
            [
                'person' => 'Manager, Brandon dental office',
                'testimonial' => 'New patients say the site made booking feel simple, which is exactly what we wanted.',
                'service' => 'website-design-and-development',
            ],
            [
                'person' => 'Owner, Tampa roofing crew',
                'testimonial' => 'Our old site looked fine on a laptop and terrible on a phone. That is fixed now.',
                'service' => 'website-design-and-development',
            ],
            [
                'person' => 'Owner, Wesley Chapel cleaning service',
                'testimonial' => 'Quotes and reminders go out on their own, so my evenings are mine again.',
                'service' => 'business-automations',
            ],
            [
                'person' => 'Office lead, Sarasota HVAC company',
                'testimonial' => 'We stopped re-typing the same customer details into three different tools.',
                'service' => 'business-automations',
            ],
            [
                'person' => 'Founder, Central Florida logistics startup',
                'testimonial' => 'They built the one piece the off-the-shelf software could never handle for us.',
                'service' => 'custom-software-development',
            ],
            [
                'person' => 'Owner, Plant City feed store',
                'testimonial' => 'Every follow-up email sounds like us, not like a template someone bought online.',
                'service' => 'email-marketing',
            ],
        ];
    }
}
