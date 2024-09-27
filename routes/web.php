<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// User authentication routes
Route::post('/login', [UserController::class, 'login']);
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Public routes
Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('home');
Route::get('posts/approved', [PostController::class, 'approved'])->name('posts.approved');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Routes for managing posts
Route::middleware(['role:author|editor|admin'])->group(function () {
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
});

Route::middleware(['role:editor|admin'])->group(function () {
    Route::post('posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts/{post}/change-status', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::post('posts/{post}/change-category', [PostController::class, 'changeCategory'])->name('posts.changeCategory');
});

Route::resource('posts', PostController::class)->except(['create', 'store'])->middleware('role:author|editor|admin');
