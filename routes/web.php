<?php

use App\Http\Middleware\System\IsDeveloper;
use App\Livewire\Leaderboard;
use App\Livewire\WordBank;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::view('/', 'welcome')->name('welcome');

Route::get('/leaderboards', Leaderboard::class)->name('leaderboards');
Route::get('/word-bank', WordBank::class)->name('word-bank');

Route::supportBubble();

Route::middleware(IsDeveloper::class)->group(function() {
    Route::get('/test-error', fn() => abort(500, "something went wrong"));
});
