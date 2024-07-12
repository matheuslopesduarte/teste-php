<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('home');

Route::get('/login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [Auth\LoginController::class, 'login'])->name('login.submit');

Route::any('/logout', [Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [Auth\RegisterController::class, 'register'])->name('register.submit');

