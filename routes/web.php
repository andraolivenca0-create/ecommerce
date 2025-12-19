<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');

});

Auth::routes();

// routes/web.php

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});


Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('auth.google');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

});
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')
        ->name('auth.google');

    // ================================================
    // ROUTE 2: CALLBACK DARI GOOGLE
    // ================================================
    // URL: /auth/google/callback
    // Dipanggil oleh Google setelah user klik "Allow"
    // URL ini HARUS sama dengan yang didaftarkan di Google Console!
    // ================================================
    Route::get('/auth/google/callback', 'callback')
        ->name('auth.google.callback');
});


