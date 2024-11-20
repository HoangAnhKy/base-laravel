<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\checkAUTH;
use Illuminate\Support\Facades\Route;

Route::get("/login", [UsersController::class, "login"])->name("users.login");
Route::get("/logout", [UsersController::class, "logout"])->name("users.logout");
Route::post("/login", [UsersController::class, "handleLogin"])->name("users.login-post");

Route::group(["prefix" => "/", "middleware" => checkAUTH::class], function (){
    Route::get("/", [UsersController::class, "index"])->name("users.index");
    Route::get("/create", [UsersController::class, "create"])->name("users.create");
    Route::post("/store", [UsersController::class, "store"])->name("users.store");
    Route::get("/edit/{user}", [UsersController::class, "edit"])->name("users.edit");
    Route::put("/update/{user}", [UsersController::class, "update"])->name("users.update");
    Route::get("/delete/{user}", [UsersController::class, "delete"])->name("users.delete");
});

Route::group(["prefix" => "/course", "middleware" => checkAUTH::class], function (){
    Route::get("/", [CoursesController::class, "index"])->name("courses.index");
    Route::get("/create", [CoursesController::class, "create"])->name("courses.create");
    Route::post("/save", [CoursesController::class, "store"])->name("courses.store");
    Route::get("/edit/{course}", [CoursesController::class, "edit"])->name("courses.edit");
    Route::put("/update/{course}", [CoursesController::class, "update"])->name("courses.update");
    Route::get("/delete/{course}", [CoursesController::class, "delete"])->name("courses.delete");
    Route::match(['get', 'post'],"/register/{course}", [CoursesController::class, "register"])->name("courses.register");
    Route::get("/course-detail/{course}", [CoursesController::class, "viewDetail"])->name("courses.view-detail");
    Route::get("/check-student-in-course", [CoursesController::class, "checkStudentInCourse"])->name("courses.check-student");
    Route::get("/export-course/{course}", [CoursesController::class, "exportCourse"])->name("courses.export-course");
    Route::post("/import-course", [CoursesController::class, "importCourse"])->name("courses.import-course");
});

Route::fallback(function (){
   return view("Layout.404");
});

Route::get("api/read-notification/", [CoursesController::class, "APIReadnotification"])->name("api-read-notification");
