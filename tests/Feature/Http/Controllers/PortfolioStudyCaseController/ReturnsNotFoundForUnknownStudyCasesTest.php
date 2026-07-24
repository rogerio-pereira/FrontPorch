<?php

it('returns not found for unknown study cases', function () {
    $this->get('/portfolio/study-case/99')->assertNotFound();
});
