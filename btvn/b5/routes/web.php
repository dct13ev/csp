<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home', [
        'posts' => [
            [
                'title' => 'Bài viết mẫu',
                'date' => now()->format('d/m/Y'),
                'content' => 'Nội dung bài viết mẫu.',
            ],
        ],
    ]);
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');