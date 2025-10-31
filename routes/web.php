<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/info', [InfoController::class, 'index'])->name('info');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
