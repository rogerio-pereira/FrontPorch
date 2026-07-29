<?php

it('redirects guests from the admin panel to the login page', function (string $url) {
    $this->get($url)->assertRedirect(route('login'));
})->with([
    '/core/services',
    '/core/services/create',
    '/core/faqs',
    '/core/faqs/create',
]);
