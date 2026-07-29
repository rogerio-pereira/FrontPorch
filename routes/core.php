<?php

use App\Http\Controllers\Core\FaqController;
use App\Http\Controllers\Core\ServiceController;
use App\Http\Controllers\Core\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('core')->name('core.')->group(function (): void {
    Route::resource('services', ServiceController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('testimonials', TestimonialController::class);
});
