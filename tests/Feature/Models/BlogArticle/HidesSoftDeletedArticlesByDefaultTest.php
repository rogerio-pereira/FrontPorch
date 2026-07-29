<?php

use App\Models\BlogArticle;

it('hides soft deleted articles by default', function () {
    $article = BlogArticle::factory()->softDeleted()->create();

    expect(BlogArticle::count())->toBe(0);
    expect(BlogArticle::withTrashed()->pluck('id')->all())->toBe([$article->id]);
});
