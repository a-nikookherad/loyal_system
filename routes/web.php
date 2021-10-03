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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/*--------------------- version 1 --------------------*/
Route::group([
    "namespace" => "\App\Http\Controllers\V1"
], function () {
    /*------------------ public routes for CMS ----------------*/
    Route::group([
        "namespace" => "CMS",
        "prefix" => "blog"
    ], function () {
        Route::post("/", "HomeController@index")->name("blog");

    });

    /*------------------ public routes for CMS ----------------*/
    Route::group([
        "namespace" => "Commerce",
        "prefix" => "productions"
    ], function () {
        Route::post("/", "HomeController@index")->name("commerce");

    });
});

