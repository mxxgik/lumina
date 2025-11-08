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

//Routes for 'portero' role (read-only access to all information)
Route::middleware(['auth:sanctum', 'role:portero'])->group(function ()
{
    Route::prefix('portero')->group(function () {
        // Aprendiz routes (read-only)
        Route::prefix('aprendices')->group(function () {
            Route::get("/", [AprendizController::class, "index"]);
            Route::get("/{id}", [AprendizController::class, "show"]);
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
            Route::get("/", [TipoProgramaController::class, "index"]);
            Route::get("/{id}", [TipoProgramaController::class, "show"]);
        });

        // AprendizEquipo routes (read-only)
        Route::prefix('aprendices-equipos')->group(function () {
            Route::get("/", [AprendizEquipoController::class, "index"]);
            Route::get("/{id}", [AprendizEquipoController::class, "show"]);
        });

        // AprendizElementoAdicional routes (read-only)
        Route::prefix('aprendices-elementos-adicionales')->group(function () {
            Route::get("/", [AprendizElementoAdicionalController::class, "index"]);
            Route::get("/{id}", [AprendizElementoAdicionalController::class, "show"]);
        });

        // HistorialElementoAdicional routes (read-only)
        Route::prefix('historial-elementos-adicionales')->group(function () {
            Route::get("/", [HistorialElementoAdicionalController::class, "index"]);
            Route::get("/{id}", [HistorialElementoAdicionalController::class, "show"]);
        });
    });
});

//Routes for 'aprendiz' role (access only to own information)
Route::middleware(['auth:sanctum', 'role:aprendiz'])->group(function ()
{
    Route::prefix('aprendiz')->group(function () {
        // Own Aprendiz profile
        Route::get("/profile", [AprendizController::class, "show"]); // Assuming show is filtered by authenticated user

        // Own equipment assignments
        Route::prefix('equipos')->group(function () {
            Route::get("/", [AprendizEquipoController::class, "index"]); // Filtered by own aprendiz_id
            Route::get("/{id}", [AprendizEquipoController::class, "show"]);
        });

        // Own additional elements assignments
        Route::prefix('elementos-adicionales')->group(function () {
            Route::get("/", [AprendizElementoAdicionalController::class, "index"]); // Filtered by own aprendiz_id
            Route::get("/{id}", [AprendizElementoAdicionalController::class, "show"]);
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
            Route::get("/", [AprendizController::class, "index"]);
            Route::post("/", [AprendizController::class, "store"]);
            Route::get("/{id}", [AprendizController::class, "show"]);
            Route::put("/{id}", [AprendizController::class, "update"]);
            Route::delete("/{id}", [AprendizController::class, "destroy"]);
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
            Route::get("/", [TipoProgramaController::class, "index"]);
            Route::post("/", [TipoProgramaController::class, "store"]);
            Route::get("/{id}", [TipoProgramaController::class, "show"]);
            Route::put("/{id}", [TipoProgramaController::class, "update"]);
            Route::delete("/{id}", [TipoProgramaController::class, "destroy"]);
        });

        // AprendizEquipo routes
        Route::prefix('aprendices-equipos')->group(function () {
            Route::get("/", [AprendizEquipoController::class, "index"]);
            Route::post("/", [AprendizEquipoController::class, "store"]);
            Route::get("/{id}", [AprendizEquipoController::class, "show"]);
            Route::put("/{id}", [AprendizEquipoController::class, "update"]);
            Route::delete("/{id}", [AprendizEquipoController::class, "destroy"]);
        });

        // AprendizElementoAdicional routes
        Route::prefix('aprendices-elementos-adicionales')->group(function () {
            Route::get("/", [AprendizElementoAdicionalController::class, "index"]);
            Route::post("/", [AprendizElementoAdicionalController::class, "store"]);
            Route::get("/{id}", [AprendizElementoAdicionalController::class, "show"]);
            Route::put("/{id}", [AprendizElementoAdicionalController::class, "update"]);
            Route::delete("/{id}", [AprendizElementoAdicionalController::class, "destroy"]);
        });

        // HistorialElementoAdicional routes
        Route::prefix('historial-elementos-adicionales')->group(function () {
            Route::get("/", [HistorialElementoAdicionalController::class, "index"]);
            Route::post("/", [HistorialElementoAdicionalController::class, "store"]);
            Route::get("/{id}", [HistorialElementoAdicionalController::class, "show"]);
            Route::put("/{id}", [HistorialElementoAdicionalController::class, "update"]);
            Route::delete("/{id}", [HistorialElementoAdicionalController::class, "destroy"]);
        });
    });
});