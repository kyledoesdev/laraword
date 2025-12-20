<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\WordBankController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::view('/', 'welcome')->name('home');

// Leaderboards Page
Route::get('/leaderboards', function () {
    return view('leaderboards');
})->name('leaderboards');

Route::get('/word-bank', WordBankController::class)->name('word-bank');


Route::get('/connect/{type}', [ConnectionController::class, 'connect'])->name('connect');
Route::get('/connect/{type}/callback', [ConnectionController::class, 'processConnection'])->name('connect.callback');

Route::supportBubble();
