<?php

it('expands a faq item on the home page', function () {
    visit('/')
        ->click('@home-faq-trigger-0')
        ->assertSee('That is a fair question.');
});
