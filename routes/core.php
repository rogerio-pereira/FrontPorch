<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Core (admin CMS) routes
|--------------------------------------------------------------------------
|
| Authenticated back-office under /core. Domain resources (services,
| case studies, blog, etc.) are registered in subsequent CMS PRs.
|
*/
Route::middleware(['auth'])
    ->prefix('core')
    ->name('core.')
    ->group(function (): void {
        // Domain resource routes are registered in subsequent CMS PRs.
    });
