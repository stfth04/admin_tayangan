<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// HALAMAN ADMIN (WAJIB LOGIN)
Route::get('/admin', [ContentController::class, 'index'])
    ->middleware('auth')
    ->name('admin');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// UPLOAD KONTEN
Route::post('/upload', [ContentController::class, 'store'])->name('upload.store');

Route::fallback(function () {
    return 'Fallback route KEPAKE — tandanya masih ada request ke /contents';
});

Route::delete('/contents/{id}', [ContentController::class, 'destroy'])
    ->name('contents.destroy');

Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');

Route::post('/playlist/store', [PlaylistController::class, 'store'])->name('playlist.store');

Route::post('/playlist/add/{playlist_id}/{content_id}', 
    [PlaylistController::class, 'addContent'])->name('playlist.add');


use App\Http\Controllers\PlaylistController;

Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');
Route::post('/playlist/content/add', [PlaylistController::class, 'addContent'])->name('playlist.addContent');

Route::post('/playlist/store', [PlaylistController::class, 'store'])
     ->name('playlist.store');