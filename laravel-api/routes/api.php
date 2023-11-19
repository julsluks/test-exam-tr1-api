<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Route::resource("todo", TodoController::class);

// Public routes
    // Todo
    Route::get('/todo', [TodoController::class, 'index']);
    Route::get('/todo/{id}', [TodoController::class, 'show']);
    Route::get("/todo/search/{title}", [TodoController::class,"search"]);
    // Auth
    Route::post("/register", [AuthController::class,"register"]);
    Route::post("/login", [AuthController::class,"login"]);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Todo
    Route::post("/todo", [TodoController::class,"store"]);
    Route::put("/todo/{id}", [TodoController::class,"update"]);
    Route::delete("/todo/{id}", [TodoController::class,"destroy"]);
    //Auth
    Route::post("/logout", [AuthController::class,"logout"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
