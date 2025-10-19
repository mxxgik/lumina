<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Route to login into the system, available for both the web and mobile clients
Route::post("login", [AuthController::class, "login"])->name("login");

//Route to register new users MOBILE ONLY
Route::post("register", [AuthController::class, "register"])->name("register");

Route::middleware(['auth:sanctum'])->group(function () {
    //TODO: agregar roles
    Route::prefix('admin')->group(function () {});
    Route::prefix('portero')->group(function () {});
    Route::prefix('aprendiz')->group(function () {});
});
