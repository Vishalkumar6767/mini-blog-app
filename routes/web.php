
<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Authentication routes (generated by Laravel UI)
Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('home');

Route::get('/', [PostController::class, 'index'])->name('posts.index');

// Post routes
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Public route for viewing a single post
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// AJAX search route
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');

// Comment routes
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});
