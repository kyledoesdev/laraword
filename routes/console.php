<?php

use App\Console\Commands\DailyDigest;
use Illuminate\Support\Facades\Log;
use App\Console\Commands\SetDailyWord;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SetDailyWord::class)
    ->timezone('America/New_York')
    ->monthly()
    ->onSuccess(function () {
        Log::channel('discord_status_updates')->info('Laraword word set successfully.');
    })
    ->onFailure(function () {
        Log::channel('discord_status_updates')->info('Something went wrong setting laraword word.');
    });

Schedule::command(DailyDigest::class)
    ->timezone('America/New_York')
    ->daily()
    ->onSuccess(function () {
        Log::channel('discord_status_updates')->info('Laraword word set successfully.');
    })
    ->onFailure(function () {
        Log::channel('discord_status_updates')->info('Something went wrong setting laraword word.');
    });