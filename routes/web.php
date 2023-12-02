<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;

Route::get('', [HomeController::class, 'view_home'])->name('home');

Route::get('image-disk', [HomeController::class, 'view_image_disk'])->name('image-disk');
Route::get('image-blob', [HomeController::class, 'view_image_blob'])->name('image-blob');

Route::post('upload-disk', [ImageController::class, 'upload_disk']);
Route::post('upload-blob', [ImageController::class, 'upload_blob']);
