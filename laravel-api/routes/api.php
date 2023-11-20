<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Route::resource("todo", TodoController::class);

// Public routes
    // Auth
    Route::post("/register", [AuthController::class,"register"]);
    Route::post("/login", [AuthController::class,"login"]);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Todo
    Route::post("/addSnippet", [TodoController::class,"store"]);
    Route::put("/update/{id}/{user}", [TodoController::class,"update"]);
    Route::get("/getAll/{userId}", [TodoController::class,"index"]);
    Route::get("/getSnippet/{id}/{user}", [TodoController::class,"show"]);
    //Auth
    Route::post("/logout", [AuthController::class,"logout"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
