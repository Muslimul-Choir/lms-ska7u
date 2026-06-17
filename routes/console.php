<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled Tasks for Content Release System
Schedule::command('content:check-release')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Content release check completed successfully');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('Content release check failed');
    });

// Auto-publish content based on waktu_rilis
Schedule::command('content:auto-publish')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('Auto-publish content completed successfully');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('Auto-publish content failed');
    });
