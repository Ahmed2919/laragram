<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/explore', [PostController::class, 'explore'])->name('explore');
Route::get('/{user:username}', [UserController::class, 'index'])->name('user_profile')->middleware('auth');
Route::get('/{user:username}/edit', [UserController::class, 'edit'])->name('edit_profile')->middleware('auth');
Route::patch('/{user:username}/update', [UserController::class, 'update'])->name('update_profile')->middleware('auth');

//posts
Route::controller(PostController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('home_page');
    Route::get('/p/create',  'create')->name('post.create');
    Route::post('/p/create', 'store')->name('post.store');
    Route::get('/p/{post:slug}',  'show')->name('post.show');
    Route::get('/p/{post:slug}/edit',  'edit')->name('post.edit');
    Route::patch('/p/{post:slug}/update',  'update')->name('post.update');
    Route::delete('/p/{post:slug}/delete', 'destroy')->name('post.delete');
});

//comments
Route::post('/p/{post:slug}/comment', [CommentController::class, 'store'])->name('comment.store')->middleware('auth');
