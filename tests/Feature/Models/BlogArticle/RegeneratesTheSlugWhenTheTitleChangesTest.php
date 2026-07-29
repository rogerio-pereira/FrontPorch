<?php

use App\Models\BlogArticle;

it('regenerates the slug when the title changes', function () {
    $article = BlogArticle::factory()->create(['title' => 'Five Ways To Automate Intake']);

    $article->update(['title' => 'Three Ways To Automate Intake']);

    expect($article->slug)->toBe('three-ways-to-automate-intake');
});
