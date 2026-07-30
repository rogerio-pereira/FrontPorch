<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
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

        $faqs = $this->serviceFaqs($service);
        $testimonials = $this->serviceTestimonials($service);

        return Inertia::render($component, [
            'faqs' => $faqs,
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * The FAQs attached to the service.
     *
     * @return list<array{question: string, answer: string}>
     */
    protected function serviceFaqs(Service $service): array
    {
        $faqs = [];

        $items = Faq::where('service_id', $service->id)
                    ->orderBy('sort_order')
                    ->get();

        foreach ($items as $faq) {
            $faqs[] = [
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }

        return $faqs;
    }

    /**
     * Five random testimonials for the service.
     *
     * @return list<array{quote: string, attribution: string}>
     */
    protected function serviceTestimonials(Service $service): array
    {
        $testimonials = [];

        $sample = Testimonial::where('service_id', $service->id)
                    ->inRandomOrder()
                    ->limit(self::TESTIMONIAL_SAMPLE)
                    ->get();

        foreach ($sample as $testimonial) {
            $testimonials[] = [
                'quote' => $testimonial->testimonial,
                'attribution' => $testimonial->person,
            ];
        }

        return $testimonials;
    }
}
