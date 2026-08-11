<?php

it('login screen can be rendered', function () {
    $this->get(route('login'))->assertOk();
});
