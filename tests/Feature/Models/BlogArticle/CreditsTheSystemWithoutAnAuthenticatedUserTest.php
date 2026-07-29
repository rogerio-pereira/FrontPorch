<?php

use App\Models\BlogArticle;

it('credits the system without an authenticated user', function () {
    $article = BlogArticle::factory()->create();

    expect($article->published_by)->toBe('System');
});
