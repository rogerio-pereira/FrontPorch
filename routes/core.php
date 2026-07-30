<?php

use App\Http\Controllers\Core\ServiceController;
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
        Route::resource('services', ServiceController::class);
    });
