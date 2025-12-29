<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')
    
    ->group(function () {
        Route::resource('posts', AdminPostController::class)->names('admin.posts');
    });
