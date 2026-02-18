<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('editoriales', App\Http\Controllers\EditorialController::class)->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route ::resource('editoriales.update', App\Http\Controllers\EditorialController::class)->middleware('auth');




Route::resource('products', App\Http\Controllers\ProductController::class)->middleware('auth');
Route::resource('clients', App\Http\Controllers\ClientController::class)->middleware('auth');
Route::resource('client_debts', App\Http\Controllers\ClientDebtController::class)->middleware('auth');
