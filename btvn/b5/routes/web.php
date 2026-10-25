<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\http\Controllers\HomeController;

Route::get('/', function () {
    $danhSachBaiViet = [
        [
            'title' => 'BÀI VIẾT MỚI', 
            'date' => '22/10/2026', 
            'content' => 'Text demo'
        ]
    ];

    return view('home', ['posts' => $danhSachBaiViet]);
});