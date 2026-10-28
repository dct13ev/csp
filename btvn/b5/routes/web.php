<?php

use Illuminate\Support\Facades\Route;

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