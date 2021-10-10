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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*==================== version 1 ========================*/
Route::group([
    "namespace" => "App\Http\Controllers\API\V1",
    "prefix" => "v1",
], function () {
    /*================== public routes ==================*/
    Route::post("login", "AuthController@login")->name("api.login");
    Route::post("register", "AuthController@register")->name("api.register");

    /*
    |---------------------------------------------------
    |+++++++++++++++++ tags route ++++++++++++++++++++
    |---------------------------------------------------
    |
    */
    Route::get("tag", "Attachments\AttachmentController@index")->name("api.tag.get");
    Route::get("tag/{id}", "Attachments\AttachmentController@show")->name("api.tag.show");

    /*================== private routes ==================*/
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        /*
        |---------------------------------------------------
        |+++++++++++++++++ authentication route ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::post("logout", "AuthController@logout")->name("api.logout");
        Route::delete("user/delete", "AuthController@destroy")->name("api.user.delete");


        /*
        |---------------------------------------------------
        |+++++++++++++++++ addresses route ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("address", "Addresses\AddressController@index")->name("api.address.get");
        Route::get("address/{id}", "Addresses\AddressController@show")->name("api.address.show");
        Route::post("address", "Addresses\AddressController@store")->name("api.address.store");
        Route::put("address/{id}", "Addresses\AddressController@update")->name("api.address.update");
        Route::delete("address/{id}", "Addresses\AddressController@destroy")->name("api.address.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ comments route ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("comment", "Comments\CommentController@index")->name("api.comment.get");
        Route::get("comment/{id}", "Comments\CommentController@show")->name("api.comment.show");
        Route::post("comment", "Comments\CommentController@store")->name("api.comment.store");
        Route::put("comment/{id}", "Comments\CommentController@update")->name("api.comment.update");
        Route::delete("comment/{id}", "Comments\CommentController@destroy")->name("api.comment.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ attachments route ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("attachment", "Attachments\AttachmentController@index")->name("api.attachment.get");
        Route::get("attachment/{id}", "Attachments\AttachmentController@show")->name("api.attachment.show");
        Route::post("attachment", "Attachments\AttachmentController@store")->name("api.attachment.store");
        Route::put("attachment/{id}", "Attachments\AttachmentController@update")->name("api.attachment.update");
        Route::delete("attachment/{id}", "Attachments\AttachmentController@destroy")->name("api.attachment.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ tags route ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("tag", "Attachments\AttachmentController@index")->name("api.tag.get");
        Route::get("tag/{id}", "Attachments\AttachmentController@show")->name("api.tag.show");
        Route::post("tag", "Attachments\AttachmentController@store")->name("api.tag.store");
        Route::put("tag/{id}", "Attachments\AttachmentController@update")->name("api.tag.update");
        Route::delete("tag/{id}", "Attachments\AttachmentController@destroy")->name("api.tag.delete");

    });
});

