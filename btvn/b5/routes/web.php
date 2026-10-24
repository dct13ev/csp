<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $danhSachBaiViet = [
        [
            'title' => 'BÀI VIẾT MỚI', 
            'date' => '22/10/2026', 
            'content' => ''
        ],
        [
            'title' => 'TITLE HEADING', 
            'date' => 'Sep 2, 2017', 
            'content' => 'Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.'
        ]
    ];

    return view('home', ['posts' => $danhSachBaiViet]);
});