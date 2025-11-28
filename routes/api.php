<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElementoAdicionalController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PasswordResetController;
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
            Route::post("/", [UsuarioController::class, "getByIdentification"]);
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
            Route::post("/", [EquipoOElementoController::class, "getByHash"]);
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

            //Recieves userId and equipoId, in case of exit, check for entrance date and time field
            //if null or greater than current date send error, set exit date and time to current
            Route::post("/", [HistorialController::class, "registerEntrance"]);
        });

        // TipoPrograma routes (read-only)
        Route::prefix('tipos-programa')->group(function () {
            Route::get("/", [NivelFormacionController::class, "index"]);
            Route::get("/{id}", [NivelFormacionController::class, "show"]);
        });

        // AprendizEquipo routes (read-only)
        Route::prefix('aprendices-equipos')->group(function () {
            Route::get("/", [EquipoOElementoController::class, "index"]);
            Route::get("/{id}", [EquipoOElementoController::class, "show"]);
        });

    });
});

//Routes for 'aprendiz' role (access only to own information)
Route::middleware(['auth:sanctum', 'role:usuario'])->group(function ()
{
    Route::prefix('usuario')->group(function () {
        // Own usuario profile
        Route::get("/profile", [UsuarioController::class, "profile"]);

        // Own equipment assignments
        Route::prefix('equipos')->group(function () {
            Route::get("/", [EquipoOElementoController::class, "getByUser"]);
            Route::get("/{id}", [EquipoOElementoController::class, "show"]);
        });

        // Own history
        Route::prefix('historial')->group(function () {
            Route::get("/", [HistorialController::class, "getByAuthUser"]);
            Route::get("/{id}", [HistorialController::class, "show"]);
        });

        // Own training information
        Route::prefix('formaciones')->group(function () {
            Route::get("/", [FormacionController::class, "index"]); // Filtered by own usuario_id
            Route::get("/{id}", [FormacionController::class, "show"]);
        });
    });
});

//Routes for 'administrator' role (full access to all endpoints)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
    Route::prefix('admin')->group(function () {
        Route::apiResource('users', UsuarioController::class);
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::apiResource('elementos-adicionales', ElementoAdicionalController::class);
        Route::apiResource('equipos-elementos', EquipoOElementoController::class);
        Route::apiResource('formaciones', FormacionController::class);
        Route::apiResource('historial', HistorialController::class);
        Route::apiResource('tipos-programa', NivelFormacionController::class);
    });
});

Route::get('/images/{filename}', [ImageController::class, 'show']);

// ============================================
// PASSWORD RECOVERY ROUTES (PUBLIC)
// ============================================
Route::prefix('password')->group(function () {
    Route::post('/forgot', [PasswordResetController::class, 'sendResetCode']);
    Route::post('/verify-code', [PasswordResetController::class, 'verifyResetCode']);
    Route::post('/reset', [PasswordResetController::class, 'resetPassword']);
});
