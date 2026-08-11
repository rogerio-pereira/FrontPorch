<?php

use App\Models\BlogArticle;

beforeEach()->flaky();

it('smoke tests the blog page', function () {
    BlogArticle::factory()
        ->create([
            'title' => 'Why your website should feel like a front porch',
            'image' => '/images/blog-article/cover.png',
        ]);

    visit('/blog')
        ->assertSee('Practical ideas for growing')
        ->assertPresent('@blog-heading')
        ->assertPresent('@blog-article-0')
        ->assertSee('Why your website should feel like a front porch');
});

it('shows the empty state when there are no articles', function () {
    visit('/blog')
        ->assertPresent('@blog-empty')
        ->assertSee('Articles are on the way');
});
