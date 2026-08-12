<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\BlogArticlesSeeder;
use Database\Seeders\CaseStudiesSeeder;
use Database\Seeders\FaqHomeSeeder;
use Database\Seeders\ServicesSeeder;
use Database\Seeders\TestimonialsSeeder;
use Database\Seeders\UserLocalSeeder;

/**
 * These tests intentionally skip UserSeeder: it inserts production founder
 * accounts with fixed bcrypt cost-12 hashes, which conflict with phpunit's
 * BCRYPT_ROUNDS=4 via the Eloquent "hashed" cast. Catalog + local demo data
 * are covered here instead.
 */
it('seeds the real catalog and stays idempotent for real data', function () {
    $this->seed([
        ServicesSeeder::class,
        FaqHomeSeeder::class,
        UserLocalSeeder::class,
    ]);

    $this->seed([
        ServicesSeeder::class,
        FaqHomeSeeder::class,
        UserLocalSeeder::class,
    ]);

    $userCount = User::where('email', 'test@example.com')
                    ->count();

    expect($userCount)->toBe(1);

    $serviceCount = Service::count();

    expect($serviceCount)->toBe(6);

    $websiteExists = Service::where('slug', 'website-design-and-development')
                        ->exists();

    expect($websiteExists)->toBeTrue();

    $contentCreationExists = Service::where('slug', 'content-creation')
                                ->exists();

    expect($contentCreationExists)->toBeTrue();

    $homeFaqCount = Faq::whereNull('service_id')
                        ->count();

    expect($homeFaqCount)->toBe(10);

    $serviceFaqCount = Faq::whereNotNull('service_id')
                        ->count();

    expect($serviceFaqCount)->toBe(61);

    $leadGeneration = Service::where('slug', 'lead-generation')
                        ->firstOrFail();

    $leadGenerationFaqCount = Faq::where('service_id', $leadGeneration->id)
                                ->count();

    expect($leadGenerationFaqCount)->toBe(9);

    $contentCreation = Service::where('slug', 'content-creation')
                        ->firstOrFail();

    $contentCreationFaqCount = Faq::where('service_id', $contentCreation->id)
                                ->count();

    expect($contentCreationFaqCount)->toBe(9);
});

it('seeds fake local content for testimonials case studies and articles', function () {
    $this->seed([
        ServicesSeeder::class,
        FaqHomeSeeder::class,
        UserLocalSeeder::class,
        TestimonialsSeeder::class,
        CaseStudiesSeeder::class,
        BlogArticlesSeeder::class,
    ]);

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
