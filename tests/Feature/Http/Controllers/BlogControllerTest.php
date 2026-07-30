<?php

use App\Models\BlogArticle;
use Inertia\Testing\AssertableInertia as Assert;

it('renders blog listing from articles', function () {
    $article = BlogArticle::factory()
                    ->create([
                        'title' => 'Why your website should feel like a front porch',
                        'description' => 'A calm, clear online presence helps small businesses earn trust.',
                        'category' => 'Website strategy',
                        'image' => '/images/blog-article/cover.png',
                    ]);

    $response = $this->get('/blog');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('blog/Blog')
        ->has('articles.data', 1)
        ->has('articles.data.0', fn (Assert $item) => $item
            ->where('id', $article->id)
            ->where('title', 'Why your website should feel like a front porch')
            ->where('description', 'A calm, clear online presence helps small businesses earn trust.')
            ->where('category', 'Website strategy')
            ->where('image', '/images/blog-article/cover.png')
            ->where('slug', 'why-your-website-should-feel-like-a-front-porch')
            ->has('created_at')
            ->etc()
        )
        ->where('articles.current_page', 1)
        ->where('articles.last_page', 1)
        ->where('articles.prev_page_url', null)
        ->where('articles.next_page_url', null)
    );
});

it('paginates the blog at fifteen articles per page', function () {
    BlogArticle::factory(16)
        ->create();

    $response = $this->get('/blog');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('articles.data', 15)
        ->where('articles.current_page', 1)
        ->where('articles.last_page', 2)
        ->where('articles.prev_page_url', null)
        ->has('articles.next_page_url')
    );
});

it('hides soft deleted articles from the blog', function () {
    $article = BlogArticle::factory()
                    ->create();

    $article->delete();

    $response = $this->get('/blog');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page->has('articles.data', 0));
});
