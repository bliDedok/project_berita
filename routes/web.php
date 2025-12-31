<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\KategoriController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    
    ->group(function () {
        Route::resource('posts', AdminPostController::class)->names('admin.posts');
    });

Route::prefix('admin')->group(function () {
    Route::resource('kategori', KategoriController::class)->names('admin.kategori');
});