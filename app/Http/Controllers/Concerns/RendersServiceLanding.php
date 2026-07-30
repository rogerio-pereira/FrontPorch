<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

trait RendersServiceLanding
{
    /**
     * Testimonials sampled on a service landing page.
     */
    protected const TESTIMONIAL_SAMPLE = 5;

    /**
     * Render a service landing page; the copy itself lives in the Vue page.
     */
    protected function renderServiceLanding(string $slug, string $component): Response
    {
        $service = Service::where('slug', $slug)
                        ->first();

        if ($service === null) {
            return Inertia::render($component, [
                'faqs' => [],
                'testimonials' => [],
            ]);
        }

        $faqs = $service->faqs;

        $testimonials = $service->testimonials()
                            ->inRandomOrder()
                            ->limit(self::TESTIMONIAL_SAMPLE)
                            ->get();

        return Inertia::render($component, compact('faqs', 'testimonials'));
    }
}
