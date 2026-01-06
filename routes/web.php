<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DaftarBacaanController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')
  ->middleware(['auth', 'can:access-admin'])
  ->group(function () {
      Route::resource('posts', AdminPostController::class)->names('admin.posts');
      Route::resource('kategori', KategoriController::class)->names('admin.kategori');
      Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
      Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

Route::get('/berita/{post:slug}', [HomeController::class, 'show'])->name('berita.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware('auth')->group(function () {
    Route::post('/daftar-bacaan/{post}/toggle', [DaftarBacaanController::class, 'toggle'])
        ->name('daftar-bacaan.toggle');

    Route::delete('/daftar-bacaan/{post}', [DaftarBacaanController::class, 'destroy'])
        ->name('daftar-bacaan.destroy');
});

