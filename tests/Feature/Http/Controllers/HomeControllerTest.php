<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertOk();
});

it('renders the home page with content from the database', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                        'description' => 'Reach the right people with a clear reason to reach out.',
                        'sort_order' => 1,
                    ]);

    Faq::factory(4)
        ->create([
            'service_id' => null,
        ]);

    Faq::factory()
        ->create([
            'service_id' => $service->id,
        ]);

    Testimonial::factory(2)
        ->create([
            'service_id' => $service->id,
        ]);

    BlogArticle::factory(2)
        ->create();

    $caseStudy = CaseStudy::factory()
                    ->create();

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->cover()
        ->create([
            'url' => '/images/home/portfolio-b.png',
        ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('home/Home')
        ->has('faqs', 4)
        ->has('faqs.0', fn (Assert $item) => $item
            ->has('question')
            ->has('answer')
            ->etc()
        )
        ->has('services', 1)
        ->has('services.0', fn (Assert $item) => $item
            ->where('slug', 'lead-generation')
            ->where('title', 'Lead generation')
            ->where('description', 'Reach the right people with a clear reason to reach out.')
            ->etc()
        )
        ->has('testimonials', 2)
        ->has('testimonials.0', fn (Assert $item) => $item
            ->has('testimonial')
            ->has('person')
            ->etc()
        )
        ->has('caseStudies', 1)
        ->has('caseStudies.0', fn (Assert $item) => $item
            ->has('title')
            ->has('description')
            ->has('images', 1)
            ->where('images.0.url', '/images/home/portfolio-b.png')
            ->etc()
        )
        ->has('articles', 2)
        ->has('articles.0', fn (Assert $item) => $item
            ->has('title')
            ->has('description')
            ->has('image')
            ->etc()
        )
    );
});

it('renders empty listings when there is no content yet', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('home/Home')
        ->has('faqs', 0)
        ->has('services', 0)
        ->has('testimonials', 0)
        ->has('caseStudies', 0)
        ->has('articles', 0)
    );
});

it('caps the previews shown on the home page', function () {
    Testimonial::factory(12)
        ->create();

    CaseStudy::factory(8)
        ->has(CaseStudyImage::factory()->cover(), 'images')
        ->create();

    BlogArticle::factory(5)
        ->create();

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('testimonials', 10)
        ->has('caseStudies', 6)
        ->has('articles', 3)
    );
});
