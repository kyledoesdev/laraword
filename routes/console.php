<?php

use App\Console\Commands\SetDailyWord;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SetDailyWord::class)->timezone('America/New_York')->dailyAt('06:00');