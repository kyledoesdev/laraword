<?php

use App\Livewire\Leaderboard;
use App\Livewire\WordBank;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::view('/', 'welcome')->name('welcome');

Route::get('/leaderboards', Leaderboard::class)->name('leaderboards');
Route::get('/word-bank', WordBank::class)->name('word-bank');

Route::supportBubble();
