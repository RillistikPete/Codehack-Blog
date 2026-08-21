<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminPostsController;
use App\Http\Controllers\AdminCategoriesController;
use App\Http\Controllers\AdminMediaController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\CommentRepliesController;

/* ---------------- Public ---------------- */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/post/{slug}', [HomeController::class, 'post'])->name('home.post');
Route::get('/category/{id}', [HomeController::class, 'categPosts'])->name('home.categ-posts');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitContactEmail'])->name('contact.submit');

// prevents anyone from adding comment or comm reply
Route::middleware('auth')->group(function () {
    Route::post('posts/{post}/comments', [PostCommentsController::class, 'store'])
        ->name('postcomments.store');

    Route::post('comments/{comment}/replies', [CommentRepliesController::class, 'store'])
        ->name('replies.create');
});
/* ---------------- Admin ---------------- */

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('posts', AdminPostsController::class)->names('posts');
    Route::resource('users', AdminUsersController::class)->names('users');

    // no create() method on this controller
    // Route::resource registers all 7 actions - hitting a route whose controller method doesn't exist gives confusing runtime error rather than a clean 404
    Route::resource('categories', AdminCategoriesController::class)
        ->except(['create'])->names('categories');

    // store lives on the public route above
    Route::resource('comments', PostCommentsController::class)
        ->only(['index', 'show', 'edit', 'update', 'destroy'])->names('comments');

    Route::resource('replies', CommentRepliesController::class)
        ->only(['store', 'show', 'update', 'destroy'])->names('replies');

    // media has no edit/update
    Route::get('media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::get('media/create', [AdminMediaController::class, 'create'])->name('media.create');
    Route::post('media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::delete('media/bulk', [AdminMediaController::class, 'deleteMedia'])->name('media.bulk-delete');
    Route::delete('media/{id}', [AdminMediaController::class, 'destroy'])->name('media.destroy');
});