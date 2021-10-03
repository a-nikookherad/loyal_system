<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*--------------------- version 1 --------------------*/
Route::group([
    "namespace" => "\App\Http\Controllers\V1"
], function () {
    /*------------------ public routes for CMS ----------------*/
    Route::group([
        "namespace" => "Blog",
        "prefix" => "blog"
    ], function () {
        Route::get("/", "HomeController@index")->name("blog.landing");

    });

    /*------------------ public routes for CMS ----------------*/
    Route::group([
        "namespace" => "Commerce",
//        "prefix" => "productions"
    ], function () {
        Route::get("/", "HomeController@index")->name("commerce.landing");

    });
});

