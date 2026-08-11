<?php

use App\Models\BlogArticle;

beforeEach()->flaky();

it('smoke tests a published blog article page', function () {
    BlogArticle::factory()
        ->create([
            'title' => 'Why your website should feel like a front porch',
            'content' => '<p>Most people meet your business online.</p>',
            'image' => '/images/blog-article/cover.png',
        ]);

    visit('/blog/article/why-your-website-should-feel-like-a-front-porch')
        ->assertSee('Why your website should feel like a front porch')
        ->assertPresent('@article-heading')
        ->assertPresent('@article-visual')
        ->assertPresent('@article-content')
        ->assertSee('Most people meet your business online.')
        ->assertPresent('@article-schedule');
});
