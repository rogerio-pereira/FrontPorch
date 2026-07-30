<?php

it('redirects guests from the admin panel to the login page', function (string $url) {
    $loginUrl = route('login');

    $this->get($url)
        ->assertRedirect($loginUrl);
})->with([
    '/core/users',
    '/core/users/create',
    '/core/services',
    '/core/services/create',
    '/core/faqs',
    '/core/faqs/create',
    '/core/testimonials',
    '/core/testimonials/create',
    '/core/case-studies',
    '/core/case-studies/create',
    '/core/blog/articles',
    '/core/blog/articles/create',
]);
