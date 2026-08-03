<?php

use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioStudyCaseController;
use App\Http\Controllers\ServiceBusinessAutomationsController;
use App\Http\Controllers\ServiceContentCreationController;
use App\Http\Controllers\ServiceCustomSoftwareDevelopmentController;
use App\Http\Controllers\ServiceEmailMarketingController;
use App\Http\Controllers\ServiceLeadGenerationController;
use App\Http\Controllers\ServiceWebsiteDesignAndDevelopmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)
    ->name('home');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:3,1') // max 3 contact submissions per IP per 1 minute
    ->name('contact.store');

Route::get('/portfolio', PortfolioController::class)
    ->name('portfolio');

Route::get('/portfolio/study-case/{caseStudy:slug}', PortfolioStudyCaseController::class)
    ->name('portfolio.study-case');

Route::get('/blog', BlogController::class)
    ->name('blog');

Route::get('/blog/article/{article:slug}', [BlogArticleController::class, 'show'])
    ->name('blog.article');

Route::get('/services/lead-generation', ServiceLeadGenerationController::class)
    ->name('services.lead-generation');

Route::get('/services/email-marketing', ServiceEmailMarketingController::class)
    ->name('services.email-marketing');

Route::get('/services/website-design-and-development', ServiceWebsiteDesignAndDevelopmentController::class)
    ->name('services.website-design-and-development');

Route::get('/services/content-creation', ServiceContentCreationController::class)
    ->name('services.content-creation');

Route::get('/services/business-automations', ServiceBusinessAutomationsController::class)
    ->name('services.business-automations');

Route::get('/services/custom-software-development', ServiceCustomSoftwareDevelopmentController::class)
    ->name('services.custom-software-development');

Route::middleware(['auth', 'verified'])
    ->group(function (): void {
        Route::inertia('dashboard', 'Dashboard')
            ->name('dashboard');
    });

require __DIR__.'/settings.php';

// Admin CMS routes (/core/*) — authenticated back-office shell for CMS resources.
require __DIR__.'/core.php';
