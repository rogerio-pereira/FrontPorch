<?php

use App\Console\Commands\GenerateWeeklyBlogArticleCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(GenerateWeeklyBlogArticleCommand::class)
    ->weeklyOn(1, '08:00')
    ->timezone('America/New_York')
    ->when(fn (): bool => (bool) config('blog.weekly_article_enabled'));
