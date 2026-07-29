<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('seeds the marketing content and stays idempotent', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(User::where('email', 'test@example.com')->count())->toBe(1);
    expect(Service::count())->toBe(5);
    expect(Service::where('slug', 'website-design-and-development')->exists())->toBeTrue();
    expect(Faq::whereNull('service_id')->count())->toBe(9);
    expect(Testimonial::count())->toBe(10);
    expect(CaseStudy::count())->toBe(6);
    expect(BlogArticle::count())->toBe(3);
});

it('seeds the flagship case study with its gallery and services', function () {
    $this->seed(DatabaseSeeder::class);

    $caseStudy = CaseStudy::where('slug', 'from-missed-calls-to-booked-jobs')->firstOrFail();

    expect($caseStudy->images)->toHaveCount(4);
    expect($caseStudy->images->first()->url)->toBe('/images/portfolio-study-case/cover.png');
    expect($caseStudy->services->pluck('slug')->all())
        ->toContain('website-design-and-development')
        ->toContain('lead-generation');
});

it('credits the seeded articles to the agency', function () {
    $this->seed(DatabaseSeeder::class);

    $article = BlogArticle::where('slug', 'why-your-website-should-feel-like-a-front-porch')->firstOrFail();

    expect($article->published_by)->toBe('Front Porch Creative');
    expect($article->image)->toBe('/images/blog-article/cover.png');
});
