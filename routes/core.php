<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('core')->name('core.')->group(function (): void {
    // Domain resource routes are registered in subsequent CMS PRs.
});
