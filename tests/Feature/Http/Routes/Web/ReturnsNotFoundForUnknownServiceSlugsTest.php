<?php

it('returns not found for unknown service slugs', function () {
    $this->get('/services/not-a-real-service')->assertNotFound();
});
