<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
Route::put('/products/{id}', [ProductController::class, 'update']);
