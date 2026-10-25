<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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