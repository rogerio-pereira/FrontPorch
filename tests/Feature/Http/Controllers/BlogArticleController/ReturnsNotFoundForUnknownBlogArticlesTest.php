<?php

it('returns not found for unknown blog articles', function () {
    $this->get('/blog/article/99')->assertNotFound();
});
