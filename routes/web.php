<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {

    Route::post('', [PostController::class, 'store'])->name('create');
    Route::delete('delete/{post}', [PostController::class, 'delete'])->name('delete');
    Route::put('update/{post}', [PostController::class, 'update'])->name('update');
    Route::get('edit/{post}', [PostController::class, 'edit'])->name('edit');
    Route::get('toggleLike/{post}', [PostController::class, 'toggleLike'])->name('toggleLike');

});
