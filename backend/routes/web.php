<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('index'))
    ->name('index');

Route::namespace('login')
    ->group(fn() => [
        Route::get('/login', fn() => view('login')),
        Route::post('/login', [LoginController::class, 'authenticate']),
    ]);