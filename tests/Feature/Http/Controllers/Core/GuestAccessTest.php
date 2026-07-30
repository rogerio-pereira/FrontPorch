<?php

it('redirects guests from the admin panel to the login page', function (string $url) {
    $loginUrl = route('login');

    $this->get($url)
        ->assertRedirect($loginUrl);
})->with([
    '/core/services',
    '/core/services/create',
    '/core/faqs',
    '/core/faqs/create',
    '/core/testimonials',
    '/core/testimonials/create',
    '/core/case-studies',
    '/core/case-studies/create',
]);
