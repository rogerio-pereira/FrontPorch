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
]);
