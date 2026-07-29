<?php

use App\Http\Controllers\Core\FaqController;
use App\Http\Controllers\Core\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('core')->name('core.')->group(function (): void {
    Route::resource('services', ServiceController::class);
    Route::resource('faqs', FaqController::class);
});
