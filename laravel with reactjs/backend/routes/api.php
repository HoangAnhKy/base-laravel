<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\IdeasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get('/user', [UserController::class, "getUser"]);
    Route::post('/logout', [UserController::class, "logout"]);


    Route::post('/post-idea', [IdeasController::class, "postIdea"]);
    Route::post('/comment', [CommentsController::class, "comment"]);
});
Route::get('/get-ideas', [IdeasController::class, "getIdeas"]);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
