<?php

use App\Console\Commands\DailyDigest;
use App\Console\Commands\SetDailyWord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SetDailyWord::class)
    ->timezone('America/New_York')
    ->monthlyOn(1)
    ->onSuccess(function () {
        //Log::channel('discord_status_updates')->info('Laraword word set successfully.');
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