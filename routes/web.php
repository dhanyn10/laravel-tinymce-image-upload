<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;

Route::get('', [HomeController::class, 'view_home'])->name('home');
Route::post('upload', [ImageController::class, 'upload']);
