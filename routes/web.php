<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/login', [GoogleAuthController::class, 'login'])->name('login');
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('/profile', function () {
    return redirect()->route('dashboard');
})->name('profile.edit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [GoogleAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [GoogleAuthController::class, 'calendar'])->name('calendar');
    Route::get('/emails', [GoogleAuthController::class, 'emails'])->name('emails');
    Route::get('/todos', [GoogleAuthController::class, 'todos'])->name('todos');
    Route::post('/logout', [GoogleAuthController::class, 'logout'])->name('logout');
});