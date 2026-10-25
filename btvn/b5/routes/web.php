<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;

route::get('post', [PostController::class,'index'])->name('post.index');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.update');
Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');