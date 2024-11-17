<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('posts', [PostController::class, 'store'])->name('posts.create');
Route::get('toggleLike/{post}', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
