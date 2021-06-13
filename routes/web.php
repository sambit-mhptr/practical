<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  //dd(file_exists(public_path('storage/products/ab.jpg')) );
  //dd(auth()->user()->categories);
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'] );
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'] );
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'] );
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'] );
Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'] );
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'] );
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'] );

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'] );
Route::get('/categories/create', [App\Http\Controllers\CategoryController::class, 'create'] );
Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'] );
Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'] );
Route::get('/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'] );
Route::put('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'] );
Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'] );