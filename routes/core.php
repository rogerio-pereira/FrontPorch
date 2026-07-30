<?php

use App\Http\Controllers\Core\BlogArticleController;
use App\Http\Controllers\Core\CaseStudyController;
use App\Http\Controllers\Core\FaqController;
use App\Http\Controllers\Core\ServiceController;
use App\Http\Controllers\Core\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Core (admin CMS) routes
|--------------------------------------------------------------------------
|
| Authenticated back-office under /core.
|
*/
Route::middleware(['auth'])
    ->prefix('core')
    ->name('core.')
    ->group(function (): void {
        Route::resource('services', ServiceController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('case-studies', CaseStudyController::class);

        Route::prefix('blog')
            ->name('blog.')
            ->group(function (): void {
                Route::resource('articles', BlogArticleController::class);
            });
    });
