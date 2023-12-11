<?php

use App\Http\Controllers\Api\V1\PostController as V1PostController;
use App\Http\Controllers\Api\V2\PostController as V2PostController;
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

// =================================================== Version 1
Route::prefix('V1')->group(function(){

    // ------------------------------------ Posts
    Route::apiResource('posts',V1PostController::class);

});

// =================================================== Version 2
Route::prefix('V2')->group(function(){

    // ------------------------------------ Posts
    Route::apiResource('posts',V2PostController::class);

});
