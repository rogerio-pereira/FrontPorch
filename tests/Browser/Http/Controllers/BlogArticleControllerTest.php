<?php

it('smoke tests a published blog article page', function () {
    visit('/blog/article/1')
        ->assertSee('Why your website should feel like a front porch')
        ->assertPresent('@article-heading');
});

it('smoke tests an unpublished blog article page by slug', function () {
    visit('/blog/why-your-website-should-feel-like-a-front-porch')
        ->assertSee('Why Your Website Should Feel Like A Front Porch')
        ->assertSee('This article is not published yet')
        ->assertPresent('@article-heading')
        ->assertPresent('@article-schedule');
});
