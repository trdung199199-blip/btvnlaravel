<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return redirect()->route('post.index');
});

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/detail/{slug}', [PostController::class, 'show'])->name('post.show');

Route::middleware('guest')->group(function () {
    Route::get('/forgot_password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot_password', [AuthController::class, 'processForgotPassword'])->name('password.email');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // CRUD Bài viết
    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');

    // Thùng rác bài viết
    Route::get('/my-trash', [PostController::class, 'trash'])->name('post.trash');
    Route::post('/posts/{id}/restore', [PostController::class, 'restore'])->name('post.restore');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('post.forceDelete');


    Route::post('/posts/{post_id}/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
});

Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
});