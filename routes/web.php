<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('productos', ProductoController::class)->middleware('auth');


