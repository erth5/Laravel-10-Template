<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PersonController;

/*
|--------------------------------------------------------------------------
| Web Routes Resources
|--------------------------------------------------------------------------
|
| This routes file register resource routes to follow default CRUD operations
|
*/

Route::resource('users', UserController::class);
Route::resource('people', PersonController::class);
Route::resource('tags', TagController::class)->only('list');
Route::resource('images', ImageController::class);
