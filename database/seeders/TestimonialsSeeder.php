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
        $website = Service::where('slug', 'website-design-and-development')
                        ->first();
        $leadGeneration = Service::where('slug', 'lead-generation')
                        ->first();
        $emailMarketing = Service::where('slug', 'email-marketing')
                        ->first();
        $automations = Service::where('slug', 'business-automations')
                        ->first();
        $customSoftware = Service::where('slug', 'custom-software-development')
                        ->first();

        if ($website === null || $leadGeneration === null || $emailMarketing === null || $automations === null || $customSoftware === null) {
            return;
        }

        // Aim statements
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'They actually listened, and explained things in a way that made sense.',
            ],
            [
                'person' => 'What we aim for',
                'service_id' => $website->id,
            ]
        );

        Testimonial::updateOrCreate(
            [
                'testimonial' => 'We always knew what was happening next. No surprises.',
            ],
            [
                'person' => 'What we aim for',
                'service_id' => $leadGeneration->id,
            ]
        );

        // Lead generation
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'The calls we get now are from people who already know what we do and what it costs.',
            ],
            [
                'person' => 'Owner, Plant City lawn care',
                'service_id' => $leadGeneration->id,
            ]
        );

        // Email marketing
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'Our monthly email brings people back into the shop without feeling pushy.',
            ],
            [
                'person' => 'Owner, Lakeland boutique',
                'service_id' => $emailMarketing->id,
            ]
        );

        Testimonial::updateOrCreate(
            [
                'testimonial' => 'Every follow-up email sounds like us, not like a template someone bought online.',
            ],
            [
                'person' => 'Owner, Plant City feed store',
                'service_id' => $emailMarketing->id,
            ]
        );

        // Website design & development
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'New patients say the site made booking feel simple, which is exactly what we wanted.',
            ],
            [
                'person' => 'Manager, Brandon dental office',
                'service_id' => $website->id,
            ]
        );

        Testimonial::updateOrCreate(
            [
                'testimonial' => 'Our old site looked fine on a laptop and terrible on a phone. That is fixed now.',
            ],
            [
                'person' => 'Owner, Tampa roofing crew',
                'service_id' => $website->id,
            ]
        );

        // Business automations
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'Quotes and reminders go out on their own, so my evenings are mine again.',
            ],
            [
                'person' => 'Owner, Wesley Chapel cleaning service',
                'service_id' => $automations->id,
            ]
        );

        Testimonial::updateOrCreate(
            [
                'testimonial' => 'We stopped re-typing the same customer details into three different tools.',
            ],
            [
                'person' => 'Office lead, Sarasota HVAC company',
                'service_id' => $automations->id,
            ]
        );

        // Custom software
        Testimonial::updateOrCreate(
            [
                'testimonial' => 'They built the one piece the off-the-shelf software could never handle for us.',
            ],
            [
                'person' => 'Founder, Central Florida logistics startup',
                'service_id' => $customSoftware->id,
            ]
        );
    }
}
