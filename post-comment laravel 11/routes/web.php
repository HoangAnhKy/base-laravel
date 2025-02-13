<?php

use App\Http\Controllers\AdminDashBoard;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\IdeasController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\AdminPage;
use App\Http\Middleware\lang;
use Illuminate\Support\Facades\Route;


Route::get('/', [IdeasController::class, "index"])->name("dashboard")->middleware([lang::class]);
Route::get('/view/{idea}', [IdeasController::class, "show"])->name("show-ideas")->middleware([lang::class]); // modal binding

Route::group(["middleware" => ["auth:web", lang::class]], function () {

    Route::post('/save-ideas', [IdeasController::class, "save"])->name("save-ideas");
    Route::get('/update/{idea}', [IdeasController::class, "edit"])->name("edit-ideas"); // modal binding
    Route::put('/update-ideas/{id?}', [IdeasController::class, "update"])->name("update-ideas");
    Route::delete('/delete-ideas/{id?}', [IdeasController::class, "delete"])->name("delete-ideas");
    //comment
    Route::post("/post-comment/{idea_id?}", [CommentsController::class, "SaveComment"])->name("post-comments");
    // profile
    Route::get("/profile/{user}", [UsersController::class, "profile"])->name("profile");
    Route::get("/profile-edit/{user}", [UsersController::class, "editProfile"])->name("user-edit");
    Route::put("/profile-edit/{user}", [UsersController::class, "saveEditProfile"])->name("user-save-edit");
    // follow
    Route::post("/follow/{user}", [UsersController::class, "follow"])->name("user-follow");
    Route::post("/unfollow/{user}", [UsersController::class, "unfollow"])->name("user-unfollow");
    //like
    Route::post("/like/{idea}", [UsersController::class, "like"])->name("user-like");
    Route::post("/unlike/{idea}", [UsersController::class, "unlike"])->name("user-unlike");
    // Feed
    Route::get("/feed", FeedController::class)->name("feed");
});

Route::group(["prefix" => "/", "middleware" => [lang::class]], function () {
    Route::get("/register", [UsersController::class, "formRegister"])->name("register");
    Route::get("/login", [UsersController::class, "formLogin"])->name("login");
    Route::get("/logout", [UsersController::class, "logout"])->name("logout");
    Route::post("/register/save", [UsersController::class, "save"])->name("register-save");
    Route::post("/handle-login", [UsersController::class, "handleLogin"])->name("handleLogin");
});

Route::group(["prefix" => "/admin", "middleware" => ["auth:web", "can:admin", lang::class], "as" => "admin-dashboard."], function () {
    Route::get("/", [AdminDashBoard::class, "index"])->name("index");
    Route::get("/users", [AdminDashBoard::class, "user"])->name("user");
    Route::get("/ideas", [AdminDashBoard::class, "ideas"])->name("ideas");
    Route::get("/comments", [AdminDashBoard::class, "comments"])->name("comment");
});

Route::get('language/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
})->name("language");

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
})->name('404');

Route::fallback(function () {
    return response()->view('errors.403', [], 404);
})->name('403');
