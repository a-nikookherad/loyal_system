<?php

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

Route::get("test", function () {
    require_once "../app/test.php";
});

/*==================== version 1 ========================*/
Route::group([
    "namespace" => "App\Http\Controllers\API\V1",
    "prefix" => "v1",
], function () {
    /*=================================================================== public routes ===================================================================*/
    Route::get("blog/{category}/{post}", "Routing\RoutingController@blog");

    /*
    |---------------------------------------------------
    |+++++++++++++++++ authentication routes ++++++++++++++++++++
    |---------------------------------------------------
    |
    */
    Route::post("login", "AuthController@login")->name("api.login");
    Route::post("register", "AuthController@register")->name("api.register");

    /*
    |---------------------------------------------------
    |+++++++++++++++++ tags routes ++++++++++++++++++++
    |---------------------------------------------------
    |
    */
    Route::get("tag", "Attachments\AttachmentController@index")->name("api.tag.get");
    Route::get("tag/{id}", "Attachments\AttachmentController@show")->name("api.tag.show");

    /*
    |---------------------------------------------------
    |+++++++++++++++++ comments routes ++++++++++++++++++++
    |---------------------------------------------------
    |
    */
    Route::post("comment", "Comments\CommentController@store")->name("api.comment.store");

    /*
    |---------------------------------------------------
    |+++++++++++++++++ comments routes ++++++++++++++++++++
    |---------------------------------------------------
    |
    */
    Route::post("like", "Likes\LikeController@store")->name("api.like.store");

    /*=================================================================== private routes ===================================================================*/
    Route::group([
        "middleware" => "auth:api"
    ], function () {
        /*
        |---------------------------------------------------
        |+++++++++++++++++ authentication routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::post("logout", "AuthController@logout")->name("api.logout");
        Route::delete("user/delete", "AuthController@destroy")->name("api.user.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ users routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("user", "Users\UserController@index")->name("api.user.get");
        Route::get("user/{id}", "Users\UserController@show")->name("api.user.show");
        Route::post("user", "Users\UserController@store")->name("api.user.store");
        Route::put("user/{id}", "Users\UserController@update")->name("api.user.update");
        Route::delete("user/{id}", "Users\UserController@destroy")->name("api.user.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ posts routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("post", "Posts\PostController@index")->name("api.post.get");
        Route::get("post/{id}", "Posts\PostController@show")->name("api.post.show");
        Route::post("post", "Posts\PostController@store")->name("api.post.store");
        Route::put("post/{id}", "Posts\PostController@update")->name("api.post.update");
        Route::delete("post/{id}", "Posts\PostController@destroy")->name("api.post.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ categories routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("category", "Categories\CategoryController@index")->name("api.category.get");
        Route::get("category/{id}", "Categories\CategoryController@show")->name("api.category.show");
        Route::post("category", "Categories\CategoryController@store")->name("api.category.store");
        Route::put("category/{id}", "Categories\CategoryController@update")->name("api.category.update");
        Route::delete("category/{id}", "Categories\CategoryController@destroy")->name("api.category.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ addresses routes ++++++++++++++++++++
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
        |+++++++++++++++++ comments routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("comment", "Comments\CommentController@index")->name("api.comment.get");
        Route::get("comment/{id}", "Comments\CommentController@show")->name("api.comment.show");
//        Route::post("comment", "Comments\CommentController@store")->name("api.comment.store");
        Route::put("comment/{id}", "Comments\CommentController@update")->name("api.comment.update");
        Route::delete("comment/{id}", "Comments\CommentController@destroy")->name("api.comment.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ attachments routes ++++++++++++++++++++
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
        |+++++++++++++++++ tags routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("tag", "Attachments\AttachmentController@index")->name("api.tag.get");
        Route::get("tag/{id}", "Attachments\AttachmentController@show")->name("api.tag.show");
        Route::post("tag", "Attachments\AttachmentController@store")->name("api.tag.store");
        Route::put("tag/{id}", "Attachments\AttachmentController@update")->name("api.tag.update");
        Route::delete("tag/{id}", "Attachments\AttachmentController@destroy")->name("api.tag.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ role routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("role", "Roles\RoleController@index")->name("api.role.get");
        Route::get("role/{id}", "Roles\RoleController@show")->name("api.role.show");
        Route::post("role", "Roles\RoleController@store")->name("api.role.store");
        Route::put("role/{id}", "Roles\RoleController@update")->name("api.role.update");
        Route::delete("role/{id}", "Roles\RoleController@destroy")->name("api.role.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ permission routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::get("permission", "Permissions\PermissionController@index")->name("api.permission.get");
        Route::get("permission/{id}", "Permissions\PermissionController@show")->name("api.permission.show");
        Route::post("permission", "Permissions\PermissionController@store")->name("api.permission.store");
        Route::put("permission/{id}", "Permissions\PermissionController@update")->name("api.permission.update");
        Route::delete("permission/{id}", "Permissions\PermissionController@destroy")->name("api.permission.delete");

        /*
        |---------------------------------------------------
        |+++++++++++++++++ Authorization routes ++++++++++++++++++++
        |---------------------------------------------------
        |
        */
        Route::post("role/{role_id}/permissions", "Authorizations\AuthorizationController@assign")->name("api.assign.permission.to.role");
        Route::post("role/{role_id}/permission/attach", "Authorizations\AuthorizationController@attach")->name("api.attach.permission.to.role");
        Route::post("role/{role_id}/permission/detach", "Authorizations\AuthorizationController@detach")->name("api.detach.permission.from.role");

    });
});


/*==================== version 2 ========================*/
Route::group([
    "namespace" => "App\Http\Controllers\API\V1",
    "prefix" => "v1",
], function () {

});
