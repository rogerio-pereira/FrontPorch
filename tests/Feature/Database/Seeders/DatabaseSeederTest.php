<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('seeds the real catalog and stays idempotent for real data', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    $userCount = User::where('email', 'test@example.com')
                    ->count();

    expect($userCount)->toBe(1);

    $serviceCount = Service::count();

    expect($serviceCount)->toBe(5);

    $websiteExists = Service::where('slug', 'website-design-and-development')
                        ->exists();

    expect($websiteExists)->toBeTrue();

    $homeFaqCount = Faq::whereNull('service_id')
                        ->count();

    expect($homeFaqCount)->toBe(9);
});

it('seeds fake local content for testimonials case studies and articles', function () {
    $this->seed(DatabaseSeeder::class);

    $testimonialCount = Testimonial::count();

    expect($testimonialCount)->toBeGreaterThan(0);

    $caseStudyCount = CaseStudy::count();

    expect($caseStudyCount)->toBeGreaterThan(0);

    $articleCount = BlogArticle::count();

    expect($articleCount)->toBe(30);

    $appName = config('app.name');

    $firstArticle = BlogArticle::firstOrFail();
    $publishedBy = $firstArticle->published_by;

    expect($publishedBy)->toBe($appName);
});
