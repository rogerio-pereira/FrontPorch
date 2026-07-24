<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders portfolio listing from backend props', function () {
    $this->get('/portfolio')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('portfolio/Portfolio')
            ->has('items', 1)
            ->has('items.0', fn (Assert $item) => $item
                ->has('id')
                ->has('title')
                ->has('excerpt')
                ->has('client')
                ->has('service')
                ->has('coverImage')
                ->has('href')
                ->where('href', '/portfolio/study-case/1')
            )
        );
});
