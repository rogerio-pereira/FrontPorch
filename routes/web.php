<?php

use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioStudyCaseController;
use App\Http\Controllers\ServiceEmailMarketingController;
use App\Http\Controllers\ServiceLeadGenerationController;
use App\Http\Controllers\ServiceWebsiteDesignAndDevelopmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/portfolio', PortfolioController::class)->name('portfolio');

Route::get('/portfolio/study-case/{id}', PortfolioStudyCaseController::class)
    ->whereNumber('id')
    ->name('portfolio.study-case');

Route::get('/blog', BlogController::class)->name('blog');
Route::get('/blog/article/{id}', [BlogArticleController::class, 'show'])
    ->whereNumber('id')
    ->name('blog.article');
Route::get('/blog/{slug}', [BlogArticleController::class, 'showBySlug'])->name('blog.show');

Route::get('/services/lead-generation', ServiceLeadGenerationController::class)->name('services.lead-generation');
Route::get('/services/email-marketing', ServiceEmailMarketingController::class)->name('services.email-marketing');
Route::get('/services/website-design-and-development', ServiceWebsiteDesignAndDevelopmentController::class)->name('services.website-design-and-development');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
