<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesCaseStudyCover;
use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    use ResolvesCaseStudyCover;

    public function __invoke(): Response
    {
        $faq = $this->faq();
        $services = $this->services();
        $testimonials = $this->testimonials();
        $portfolioPreview = $this->portfolioPreview();
        $blogPreview = $this->blogPreview();

        return Inertia::render('home/Home', [
            'faq' => $faq,
            'services' => $services,
            'testimonials' => $testimonials,
            'portfolioPreview' => $portfolioPreview,
            'blogPreview' => $blogPreview,
        ]);
    }

    /**
     * The FAQs that are not attached to a service landing page.
     *
     * @return list<array{question: string, answer: string}>
     */
    private function faq(): array
    {
        $faq = [];

        $items = Faq::whereNull('service_id')
                    ->orderBy('sort_order')
                    ->get();

        foreach ($items as $item) {
            $faq[] = [
                'question' => $item->question,
                'answer' => $item->answer,
            ];
        }

        return $faq;
    }

    /**
     * The service catalog, in the order it is displayed.
     *
     * @return list<array{slug: string, title: string, teaser: string}>
     */
    private function services(): array
    {
        $services = [];

        $items = Service::orderBy('sort_order')
                        ->get();

        foreach ($items as $service) {
            $services[] = [
                'slug' => $service->slug,
                'title' => $service->title,
                'teaser' => $service->description,
            ];
        }

        return $services;
    }

    /**
     * Up to ten testimonials, sampled across every service.
     *
     * @return list<array{quote: string, attribution: string}>
     */
    private function testimonials(): array
    {
        $testimonials = [];

        $sample = Testimonial::inRandomOrder()
                        ->limit(10)
                        ->get();

        foreach ($sample as $testimonial) {
            $testimonials[] = [
                'quote' => $testimonial->testimonial,
                'attribution' => $testimonial->person,
            ];
        }

        return $testimonials;
    }

    /**
     * Six random case studies with their cover image.
     *
     * @return list<array{title: string, description: string, image: string}>
     */
    private function portfolioPreview(): array
    {
        $preview = [];

        $caseStudies = CaseStudy::with('images')
                        ->inRandomOrder()
                        ->limit(6)
                        ->get();

        foreach ($caseStudies as $caseStudy) {
            $coverImage = $this->coverImage($caseStudy);

            $preview[] = [
                'title' => $caseStudy->title,
                'description' => $caseStudy->description,
                'image' => $coverImage,
            ];
        }

        return $preview;
    }

    /**
     * The three latest articles.
     *
     * @return list<array{title: string, description: string, image: string}>
     */
    private function blogPreview(): array
    {
        $preview = [];

        $articles = BlogArticle::orderByDesc('created_at')
                        ->limit(3)
                        ->get();

        foreach ($articles as $article) {
            $preview[] = [
                'title' => $article->title,
                'description' => $article->description,
                'image' => $article->image,
            ];
        }

        return $preview;
    }
}
