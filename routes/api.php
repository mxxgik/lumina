<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElementoAdicionalController;
use App\Http\Controllers\EquipoOElementoController;
use App\Http\Controllers\FormacionController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\NivelFormacionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;

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

//Routes for 'portero' role (read-only access to all information)
Route::middleware(['auth:sanctum', 'role:portero'])->group(function ()
{
    Route::prefix('portero')->group(function () {
        // Aprendiz routes (read-only)
        Route::prefix('aprendices')->group(function () {
            Route::get("/", [UsuarioController::class, "index"]);
            Route::get("/{id}", [UsuarioController::class, "show"]);
        });

        // ElementoAdicional routes (read-only)
        Route::prefix('elementos-adicionales')->group(function () {
            Route::get("/", [ElementoAdicionalController::class, "index"]);
            Route::get("/{id}", [ElementoAdicionalController::class, "show"]);
        });

        // EquipoOElemento routes (read-only)
        Route::prefix('equipos-elementos')->group(function () {
            Route::get("/", [EquipoOElementoController::class, "index"]);
            Route::get("/{id}", [EquipoOElementoController::class, "show"]);
        });

        // Formacion routes (read-only)
        Route::prefix('formaciones')->group(function () {
            Route::get("/", [FormacionController::class, "index"]);
            Route::get("/{id}", [FormacionController::class, "show"]);
        });

        // Historial routes (read-only)
        Route::prefix('historial')->group(function () {
            Route::get("/", [HistorialController::class, "index"]);
            Route::get("/{id}", [HistorialController::class, "show"]);
        });

        // TipoPrograma routes (read-only)
        Route::prefix('tipos-programa')->group(function () {
            Route::get("/", [NivelFormacionController::class, "index"]);
            Route::get("/{id}", [NivelFormacionController::class, "show"]);
        });

        // AprendizEquipo routes (read-only)
        Route::prefix('aprendices-equipos')->group(function () {
            Route::get("/", [ElementoAdicionalController::class, "index"]);
            Route::get("/{id}", [ElementoAdicionalController::class, "show"]);
        });

    });
});

//Routes for 'aprendiz' role (access only to own information)
Route::middleware(['auth:sanctum', 'role:aprendiz'])->group(function ()
{
    Route::prefix('aprendiz')->group(function () {
        // Own Aprendiz profile
        Route::get("/profile", [UsuarioController::class, "show"]); // Assuming show is filtered by authenticated user

        // Own equipment assignments
        Route::prefix('equipos')->group(function () {
            Route::get("/", [ElementoAdicionalController::class, "index"]); // Filtered by own aprendiz_id
            Route::get("/{id}", [ElementoAdicionalController::class, "show"]);
        });

        // Own history
        Route::prefix('historial')->group(function () {
            Route::get("/", [HistorialController::class, "index"]); // Filtered by own assignments
            Route::get("/{id}", [HistorialController::class, "show"]);
        });

        // Own training information
        Route::prefix('formaciones')->group(function () {
            Route::get("/", [FormacionController::class, "index"]); // Filtered by own aprendiz_id
            Route::get("/{id}", [FormacionController::class, "show"]);
        });
    });
});

//Routes for 'administrator' role (full access to all endpoints)
Route::middleware(['auth:sanctum', 'role:administrator'])->group(function ()
{
    Route::prefix('admin')->group(function () {
        // Aprendiz routes
        Route::prefix('aprendices')->group(function () {
            Route::get("/", [UsuarioController::class, "index"]);
            Route::post("/", [UsuarioController::class, "store"]);
            Route::get("/{id}", [UsuarioController::class, "show"]);
            Route::put("/{id}", [UsuarioController::class, "update"]);
            Route::delete("/{id}", [UsuarioController::class, "destroy"]);
        });

        // ElementoAdicional routes
        Route::prefix('elementos-adicionales')->group(function () {
            Route::get("/", [ElementoAdicionalController::class, "index"]);
            Route::post("/", [ElementoAdicionalController::class, "store"]);
            Route::get("/{id}", [ElementoAdicionalController::class, "show"]);
            Route::put("/{id}", [ElementoAdicionalController::class, "update"]);
            Route::delete("/{id}", [ElementoAdicionalController::class, "destroy"]);
        });

        // EquipoOElemento routes
        Route::prefix('equipos-elementos')->group(function () {
            Route::get("/", [EquipoOElementoController::class, "index"]);
            Route::post("/", [EquipoOElementoController::class, "store"]);
            Route::get("/{id}", [EquipoOElementoController::class, "show"]);
            Route::put("/{id}", [EquipoOElementoController::class, "update"]);
            Route::delete("/{id}", [EquipoOElementoController::class, "destroy"]);
        });

        // Formacion routes
        Route::prefix('formaciones')->group(function () {
            Route::get("/", [FormacionController::class, "index"]);
            Route::post("/", [FormacionController::class, "store"]);
            Route::get("/{id}", [FormacionController::class, "show"]);
            Route::put("/{id}", [FormacionController::class, "update"]);
            Route::delete("/{id}", [FormacionController::class, "destroy"]);
        });

        // Historial routes
        Route::prefix('historial')->group(function () {
            Route::get("/", [HistorialController::class, "index"]);
            Route::post("/", [HistorialController::class, "store"]);
            Route::get("/{id}", [HistorialController::class, "show"]);
            Route::put("/{id}", [HistorialController::class, "update"]);
            Route::delete("/{id}", [HistorialController::class, "destroy"]);
        });

        // TipoPrograma routes
        Route::prefix('tipos-programa')->group(function () {
            Route::get("/", [NivelFormacionController::class, "index"]);
            Route::post("/", [NivelFormacionController::class, "store"]);
            Route::get("/{id}", [NivelFormacionController::class, "show"]);
            Route::put("/{id}", [NivelFormacionController::class, "update"]);
            Route::delete("/{id}", [NivelFormacionController::class, "destroy"]);
        });

        // AprendizEquipo routes
        Route::prefix('aprendices-equipos')->group(function () {
            Route::get("/", [ElementoAdicionalController::class, "index"]);
            Route::post("/", [ElementoAdicionalController::class, "store"]);
            Route::get("/{id}", [ElementoAdicionalController::class, "show"]);
            Route::put("/{id}", [ElementoAdicionalController::class, "update"]);
            Route::delete("/{id}", [ElementoAdicionalController::class, "destroy"]);
        });

    });
});