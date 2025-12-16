<?php

use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;

Route::get('/connect/{type}', [ConnectionController::class, 'connect'])->name('connect');
Route::get('/connect/{type}/callback', [ConnectionController::class, 'processConnection'])->name('connect.callback');
