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

/*--------------------- public routes version 1 --------------------*/
Route::group([
    "namespace" => "\App\Http\Controllers\V1"
], function () {
    Route::get("/", "HomeController@index")->name("welcome");

    /*------------------ blog routes ----------------*/
    Route::group([
        "namespace" => "Blog",
        "prefix" => "blog"
    ], function () {
        Route::get("/", "LandingController@index")->name("blog.landing");

    });

    /*------------------ commerce routes ----------------*/
    Route::group([
        "namespace" => "Commerce",
        "prefix" => "commerce"
    ], function () {
        Route::get("/", "LandingController@index")->name("commerce.landing");

    });

    /*------------------ news routes ----------------*/
    Route::group([
        "namespace" => "News",
        "prefix" => "news"
    ], function () {
        Route::get("/", "LandingController@index")->name("news.landing");

    });
});

