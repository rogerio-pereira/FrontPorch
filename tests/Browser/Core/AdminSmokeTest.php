<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;

it('shows the admin indexes to authenticated users', function (string $url, string $heading) {
    $this->actingAs(User::factory()->create());

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading);
})->with([
    ['/core/users', 'Users'],
    ['/core/services', 'Services'],
    ['/core/faqs', 'FAQs'],
    ['/core/testimonials', 'Testimonials'],
    ['/core/case-studies', 'Case studies'],
    ['/core/blog/articles', 'Blog articles'],
]);

it('shows the admin create forms to authenticated users', function (string $url, string $heading, string $submit) {
    $this->actingAs(User::factory()->create());

    Service::factory()->create(['title' => 'Lead generation']);

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($heading)
        ->assertPresent($submit);
})->with([
    ['/core/users/create', 'New user', '@user-submit'],
    ['/core/services/create', 'New service', '@service-submit'],
    ['/core/faqs/create', 'New FAQ', '@faq-submit'],
    ['/core/testimonials/create', 'New testimonial', '@testimonial-submit'],
    ['/core/case-studies/create', 'New case study', '@case-study-submit'],
    ['/core/blog/articles/create', 'New article', '@article-submit'],
]);

it('shows the admin edit forms to authenticated users', function (string $url, string $heading, string $submit) {
    $this->actingAs(User::factory()->create());

    $user = User::factory()->create(['name' => 'Casey Editor']);
    $service = Service::factory()->create(['title' => 'Lead generation']);
    $faq = Faq::factory()->forService($service)->create(['question' => 'How soon can we start?']);
    $testimonial = Testimonial::factory()->forService($service)->create(['person' => 'Jordan Client']);
    $caseStudy = CaseStudy::factory()->create(['title' => 'From missed calls to booked jobs']);
    $article = BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
        'image' => '/images/blog-article/cover.png',
    ]);

    $resolvedUrl = str_replace(
        [
            '{user}',
            '{service}',
            '{faq}',
            '{testimonial}',
            '{caseStudy}',
            '{article}',
        ],
        [
            $user->id,
            $service->id,
            $faq->id,
            $testimonial->id,
            $caseStudy->id,
            $article->id,
        ],
        $url,
    );

    visit($resolvedUrl)
        ->waitForEvent('networkidle')
        ->assertSee($heading)
        ->assertPresent($submit);
})->with([
    ['/core/users/{user}/edit', 'Edit user', '@user-submit'],
    ['/core/services/{service}/edit', 'Edit service', '@service-submit'],
    ['/core/faqs/{faq}/edit', 'Edit FAQ', '@faq-submit'],
    ['/core/testimonials/{testimonial}/edit', 'Edit testimonial', '@testimonial-submit'],
    ['/core/case-studies/{caseStudy}/edit', 'Edit case study', '@case-study-submit'],
    ['/core/blog/articles/{article}/edit', 'Edit article', '@article-submit'],
]);

it('redirects guests from the admin panel to login', function (string $url) {
    visit($url)->assertPathIs('/login');
})->with([
    '/core/users',
    '/core/users/create',
    '/core/services',
    '/core/services/create',
    '/core/faqs',
    '/core/faqs/create',
    '/core/testimonials',
    '/core/testimonials/create',
    '/core/case-studies',
    '/core/case-studies/create',
    '/core/blog/articles',
    '/core/blog/articles/create',
]);
