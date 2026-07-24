<?php

it('smoke tests a published blog article page', function () {
    visit('/blog/article/1')
        ->assertSee('Why your website should feel like a front porch')
        ->assertPresent('@article-heading');
});
