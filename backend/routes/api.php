<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function(){
    Route::post("/store", "App\Http\Controllers\AccountController@store");
    Route::post("/login", "App\Http\Controllers\AccountController@login");

    Route::prefix("account")->group(function(){
        Route::prefix("logo")->group(function(){
            Route::get("/", "App\Http\Controllers\AccountController@getLogo");
            Route::post("/upload", "App\Http\Controllers\AccountController@uploadLogo");
        }); 
    });
});
