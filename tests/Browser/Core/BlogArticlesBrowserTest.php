<?php

use App\Models\BlogArticle;
use App\Models\User;

it('shows the article create form with the image field', function () {
    $this->actingAs(User::factory()->create());

    visit('/core/blog/articles/create')
        ->waitForEvent('networkidle')
        ->assertSee('New article')
        ->assertSee('Title')
        ->assertSee('Description')
        ->assertSee('Category')
        ->assertSee('Content')
        ->assertSee('Image')
        ->assertPresent('@article-image')
        ->assertPresent('@article-submit');
});

it('edits a blog article from the admin form', function () {
    $this->actingAs(User::factory()->create());

    $article = BlogArticle::factory()->create([
        'title' => 'Original article title',
        'description' => 'Original description.',
        'category' => 'Strategy',
        'content' => '<p>Original content.</p>',
        'image' => '/images/blog-article/cover.png',
    ]);

    visit("/core/blog/articles/{$article->id}/edit")
        ->waitForEvent('networkidle')
        ->type('title', 'Updated article title')
        ->click('@article-submit')
        ->waitForText('Updated article title')
        ->assertPathIs('/core/blog/articles');

    expect($article->refresh()->slug)->toBe('updated-article-title');
});

it('deletes a blog article from the admin index', function () {
    $this->actingAs(User::factory()->create());

    $article = BlogArticle::factory()->create([
        'title' => 'Delete this article',
        'image' => '/images/blog-article/cover.png',
    ]);

    visit('/core/blog/articles')
        ->waitForEvent('networkidle')
        ->assertSee('Delete this article')
        ->click("@article-delete-{$article->id}")
        ->waitForText('No articles yet.')
        ->assertDontSee('Delete this article');

    expect(BlogArticle::find($article->id))->toBeNull();
});
