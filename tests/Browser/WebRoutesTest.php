<?php

use App\Models\BlogArticle;
use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use App\Models\User;

it('smoke tests public web routes', function (string $url, string $text) {
    visit($url)
        ->assertSee($text);
})
->with([
    ['/', 'You do great work'],
    ['/portfolio', 'Case studies that show the path'],
    ['/blog', 'Practical ideas for growing'],
    ['/services/lead-generation', 'More of the right people reaching out'],
    ['/services/email-marketing', 'Stay in touch in a way that feels human'],
    ['/services/website-design-and-development', 'A site that looks like you'],
    ['/services/content-creation', 'Blog posts and social writing'],
    ['/services/business-automations', 'Give the copy-paste work to the system'],
    ['/services/custom-software-development', 'When ready-made tools do not fit'],
    ['/login', 'Email address'],
    ['/forgot-password', 'Forgot password'],
]);

it('smoke tests a published blog article route', function () {
    BlogArticle::factory()
        ->create([
            'title' => 'Why your website should feel like a front porch',
            'image' => '/images/blog-article/cover.png',
        ]);

    visit('/blog/article/why-your-website-should-feel-like-a-front-porch')
        ->assertSee('Why your website should feel like a front porch');
});

it('smoke tests a portfolio study case route', function () {
    $service = Service::factory()
                    ->create([
                        'title' => 'Lead generation',
                    ]);

    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'From missed calls to booked jobs',
                    ]);

    $caseStudy->services()
        ->attach($service);

    CaseStudyImage::factory()
        ->for($caseStudy)
        ->create([
            'sort_order' => 0,
            'url' => '/images/portfolio-study-case/cover.png',
        ]);

    visit('/portfolio/study-case/from-missed-calls-to-booked-jobs')
        ->assertSee('From missed calls to booked jobs');
});

it('smoke tests authenticated app routes', function (string $url, string $text) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);
    $this->withSession(['auth.password_confirmed_at' => time()]);

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee($text);
})
->with([
    ['/dashboard', 'Dashboard'],
    ['/settings/profile', 'Update your name and email address'],
    ['/settings/security', 'Update password'],
    ['/settings/appearance', 'The admin panel uses the Front Porch dark brand theme'],
    ['/core/users', 'Users'],
    ['/core/services', 'Services'],
    ['/core/faqs', 'FAQs'],
    ['/core/testimonials', 'Testimonials'],
    ['/core/case-studies', 'Case studies'],
    ['/core/blog/articles', 'Blog articles'],
]);
