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

/*==================== version 1 ========================*/
Route::group([
    "namespace" => "App\Http\Controllers\API\V1",
    "prefix" => "v1",
], function () {
    /*------------------ public routes ----------------*/
    Route::post("login", "AuthController@login")->name("login");
    Route::post("register", "AuthController@register")->name("register");

    /*------------------ private routes ----------------*/
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        Route::post("logout", "AuthController@logout")->name("logout");

    });
});

