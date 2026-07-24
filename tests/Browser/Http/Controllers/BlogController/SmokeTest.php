<?php

it('smoke tests the blog page', function () {
    visit('/blog')
        ->assertSee('Practical ideas for growing')
        ->assertPresent('@blog-heading')
        ->assertPresent('@blog-article-1');
});
