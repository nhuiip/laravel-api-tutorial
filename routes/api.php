<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // group route for product
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products', 'index')->middleware('abilities:read');
        Route::post('/products', 'store')->middleware('abilities:create');
        Route::get('/products/{id}', 'show')->middleware('abilities:read');
        Route::put('/products/{id}', 'update')->middleware('abilities:update');
        Route::delete('/products/{id}', 'destroy')->middleware('abilities:delete');
    });
});
