<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('users', AdminUserController::class);
});

Route::get('/bai-viet/{slug}', [App\Http\Controllers\HomeController::class, 'show'])->name('post.show');
Route::get('/danh-muc/{id}', [App\Http\Controllers\HomeController::class, 'category'])->name('category.show');
Route::post('/bai-viet/{post}/binh-luan', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::get('/tag/{slug}', [App\Http\Controllers\HomeController::class, 'tag'])->name('tag.show');
Route::delete('/binh-luan/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
Route::get('/admin', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

require __DIR__.'/auth.php';