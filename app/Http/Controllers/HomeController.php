<?php

namespace App\Http\Controllers;

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $faqs = Faq::whereNull('service_id')
                    ->orderBy('sort_order')
                    ->get();

        $services = Service::orderBy('sort_order')
                        ->get();

        $testimonials = Testimonial::inRandomOrder()
                            ->limit(10)
                            ->get();

        $caseStudies = CaseStudy::with('images')
                           ->inRandomOrder()
                           ->limit(6)
                           ->get();

        $articles = BlogArticle::orderByDesc('created_at')
                        ->limit(3)
                        ->get();

        return Inertia::render('home/Home', compact(
            'faqs',
            'services',
            'testimonials',
            'caseStudies',
            'articles',
        ));
    }
}
