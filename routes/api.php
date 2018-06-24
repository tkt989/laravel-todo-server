<?php

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

Route::group(["middleware" => "guest:api"], function () {
    Route::post("/register", "ApiController@register");
    Route::post("/login", "ApiController@login");
});

Route::group(["middleware" => "auth:api"], function () {
    Route::get("/me", "ApiController@me");
    Route::get("/validate", "ApiController@validation");

    Route::get("/todos", "TodoController@listTodos");
    Route::post("/todos", "TodoController@createTodo");
    Route::get("/todos/{id}", "TodoController@getTodo");
    Route::put("/todos/{id}", "TodoController@updateTodo");
    Route::delete("/todos/{id}", "TodoController@deleteTodo");
});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
});
 */
