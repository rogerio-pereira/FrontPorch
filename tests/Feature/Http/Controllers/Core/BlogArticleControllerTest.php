<?php

use App\Models\BlogArticle;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->admin = User::factory()->create(['name' => 'Amelia Porch']);

    $this->actingAs($this->admin);

    Storage::fake();
});

it('lists the articles', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
        'category' => 'Website strategy',
    ]);

    $this->get('/core/blog/articles')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/blog-articles/Index')
            ->has('articles', 1)
            ->has('articles.0', fn (Assert $props) => $props
                ->where('id', $article->id)
                ->where('title', 'Why your website should feel like a front porch')
                ->where('slug', 'why-your-website-should-feel-like-a-front-porch')
                ->where('category', 'Website strategy')
                ->etc()
            )
        );
});

it('shows the form to create an article', function () {
    $this->get('/core/blog/articles/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/blog-articles/Form')
            ->where('article', null)
        );
});

it('creates an article with a cover image and credits the author', function () {
    $this->post('/core/blog/articles', [
        'title' => 'Why your website should feel like a front porch',
        'description' => 'A calm, clear online presence earns trust.',
        'category' => 'Website strategy',
        'content' => '<p>Most people meet your business online.</p>',
        'image' => UploadedFile::fake()->create('cover.jpg', 12),
    ])->assertRedirect('/core/blog/articles');

    $article = BlogArticle::where('slug', 'why-your-website-should-feel-like-a-front-porch')->firstOrFail();

    expect($article->published_by)->toBe('Amelia Porch');
    expect($article->image)->toContain('blog/');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});

it('moves inline content images to object storage', function () {
    $payload = base64_encode('inline-image');

    $this->post('/core/blog/articles', [
        'title' => 'Small automations that save time',
        'description' => 'Start with the tasks you do every week.',
        'category' => 'Automation',
        'content' => '<p>Before</p><img src="data:image/png;base64,'.$payload.'">',
        'image' => UploadedFile::fake()->create('cover.jpg', 12),
    ])->assertRedirect('/core/blog/articles');

    $article = BlogArticle::where('slug', 'small-automations-that-save-time')->firstOrFail();

    expect($article->content)->not->toContain('data:image');
    expect(Storage::allFiles('blog'))->toHaveCount(2);
});

it('requires an image when creating an article', function () {
    $this->post('/core/blog/articles', [
        'title' => '',
        'description' => '',
        'category' => '',
        'content' => '',
    ])->assertSessionHasErrors(['title', 'description', 'category', 'content', 'image']);
});

it('shows the form to edit an article', function () {
    $article = BlogArticle::factory()->create(['title' => 'Why your website should feel like a front porch']);

    $this->get("/core/blog/articles/{$article->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('core/blog-articles/Form')
            ->has('article', fn (Assert $props) => $props
                ->where('id', $article->id)
                ->where('title', 'Why your website should feel like a front porch')
                ->etc()
            )
        );
});

it('updates an article and keeps the current image', function () {
    $article = BlogArticle::factory()->create([
        'title' => 'Why your website should feel like a front porch',
        'image' => '/images/blog-article/cover.png',
    ]);

    $this->put("/core/blog/articles/{$article->id}", [
        'title' => 'Why your website should feel like a porch swing',
        'description' => 'A calm, clear online presence earns trust.',
        'category' => 'Website strategy',
        'content' => '<p>Updated body.</p>',
    ])->assertRedirect('/core/blog/articles');

    $article->refresh();

    expect($article->slug)->toBe('why-your-website-should-feel-like-a-porch-swing');
    expect($article->image)->toBe('/images/blog-article/cover.png');
    expect($article->content)->toBe('<p>Updated body.</p>');
});

it('replaces the image of an article when a new one is uploaded', function () {
    $article = BlogArticle::factory()->create(['image' => '/images/blog-article/cover.png']);

    $this->put("/core/blog/articles/{$article->id}", [
        'title' => $article->title,
        'description' => $article->description,
        'category' => $article->category,
        'content' => $article->content,
        'image' => UploadedFile::fake()->create('new-cover.jpg', 12),
    ])->assertRedirect('/core/blog/articles');

    expect($article->refresh()->image)->toContain('blog/');
    expect(Storage::allFiles('blog'))->toHaveCount(1);
});

it('soft deletes an article', function () {
    $article = BlogArticle::factory()->create();

    $this->delete("/core/blog/articles/{$article->id}")->assertRedirect('/core/blog/articles');

    expect(BlogArticle::find($article->id))->toBeNull();
    expect(BlogArticle::withTrashed()->find($article->id))->not->toBeNull();
});

it('has no detail page for articles', function () {
    $article = BlogArticle::factory()->create();

    $this->get("/core/blog/articles/{$article->id}")->assertNotFound();
});
