<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AprendizController;
use App\Http\Controllers\AprendizElementoAdicionalController;
use App\Http\Controllers\AprendizEquipoController;
use App\Http\Controllers\ElementoAdicionalController;
use App\Http\Controllers\EquipoAdicionalController;
use App\Http\Controllers\EquipoOElementoController;
use App\Http\Controllers\FormacionController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\HistorialElementoAdicionalController;
use App\Http\Controllers\TipoProgramaController;

//Authentication related routes
Route::prefix('auth')->group(function ()
{
    //Login available for both mobile and desktop web clients
    Route::post("login", [AuthController::class, "login"])->name("login");
    
    //Register only available for mobile client
    Route::post("register", [AuthController::class, "register"])->name("register");
    
    //Logout route, available for both mobile and web clients
    Route::middleware(['auth:sanctum'])->post("logout", [AuthController::class, "logout"])->name("logout");
});

//Routes for 'portero' role
Route::middleware(['auth:sanctum', 'role:portero'])->group(function ()
{
    Route::prefix('portero')->group(function () {
        Route::prefix('historial')->group(function () {
            Route::get("show", [HistorialController::class, "show"]);
            Route::post("create", [HistorialController::class, "store"]);
        }); 
    });
});

//Routes for 'aprendiz' role
Route::middleware(['auth:sanctum', 'role:aprendiz'])->group(function ()
{
    Route::prefix('aprendiz')->group(function () {
        Route::prefix('')->group(function () {
        }); 
    });
});

//Routes for 'admin' role
Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
    Route::prefix('admin')->group(function () {
        Route::prefix('historial')->group(function () {
        }); 
    });

});