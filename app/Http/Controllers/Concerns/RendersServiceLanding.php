<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Service;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

trait RendersServiceLanding
{
    /**
     * Testimonials sampled on a service landing page.
     */
    protected const TESTIMONIAL_SAMPLE = 10;

    /**
     * Render a service landing page; the copy itself lives in the Vue page.
     */
    protected function renderServiceLanding(string $slug, string $component): Response
    {
        $relatedServices = $this->relatedServicesFor($slug);

        $service = Service::where('slug', $slug)
                        ->first();

        if ($service === null) {
            return Inertia::render($component, [
                'faqs' => [],
                'testimonials' => [],
                'relatedServices' => $relatedServices,
            ]);
        }

        $faqs = $service->faqs;

        $testimonials = $service->testimonials()
                            ->inRandomOrder()
                            ->limit(self::TESTIMONIAL_SAMPLE)
                            ->get();

        return Inertia::render($component, compact('faqs', 'testimonials', 'relatedServices'));
    }

    /**
     * Other catalog services linked from the Also explore section.
     *
     * Keys are slugs; values are titles.
     *
     * @return Collection<string, string>
     */
    protected function relatedServicesFor(string $slug): Collection
    {
        return Service::where('slug', '!=', $slug)
                    ->orderBy('sort_order')
                    ->pluck('title', 'slug');  // ['slug' => 'title']
    }
}
