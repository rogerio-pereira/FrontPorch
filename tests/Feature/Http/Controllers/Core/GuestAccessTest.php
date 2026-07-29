<?php

it('redirects guests from the admin panel to the login page', function (string $url) {
    $this->get($url)->assertRedirect(route('login'));
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
