<?php

use App\Http\Controllers\TempImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('blog', [BlogController::class,'store']);
Route::get('blog', [BlogController::class,'index']);
Route::get('blog/{id}', [BlogController::class,'show']);

Route::post('save-temp-image', [TempImageController::class,'store']);

