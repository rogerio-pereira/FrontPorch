<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Service;

it('keeps robots.txt in public with a sitemap reference', function () {
    $path = public_path('robots.txt');

    expect(file_exists($path))->toBeTrue();

    $contents = file_get_contents($path);

    expect($contents)->toContain('Sitemap: /sitemap.xml')
        ->and($contents)->toContain('Allow: /');
});

it('keeps llms.txt in public with agency facts', function () {
    $path = public_path('llms.txt');

    expect(file_exists($path))->toBeTrue();

    $contents = file_get_contents($path);

    expect($contents)->toContain('Front Porch Creative')
        ->and($contents)->toContain('Plant City')
        ->and($contents)->toContain('/services/lead-generation');
});

it('serves sitemap.xml with public urls', function () {
    Service::factory()->create([
        'title' => 'Lead generation',
        'slug' => 'lead-generation',
    ]);

    BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
    ]);

    CaseStudy::factory()->create([
        'title' => 'From missed calls to booked jobs',
    ]);

    $response = $this->get('/sitemap.xml');

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    $response->assertSee(url('/'), false);
    $response->assertSee(url('/services/lead-generation'), false);
    $response->assertSee(url('/blog/article/why-your-website-should-feel-like-a-front-porch'), false);
    $response->assertSee(url('/portfolio/study-case/from-missed-calls-to-booked-jobs'), false);
    $response->assertSee(url('/privacy'), false);
    $response->assertSee(url('/terms'), false);
});
