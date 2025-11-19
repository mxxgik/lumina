<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class HistorialController
{
    /**
     * Display a listing of the historiales.
     */
    public function index()
    {
        try {
            $historiales = Historial::with(['usuario', 'equipo'])->get();
            return response()->json(['success' => true, 'data' => $historiales], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve historiales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created historial in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usuario_id' => 'required|integer|exists:usuarios,id',
                'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
                'ingreso' => 'required|date',
                'salida' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $historial = Historial::create($validator->validated());

            return response()->json([
                'success' => true,
                'data' => $historial->load(['usuario', 'equipo'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

        /**
         * Display the specified historial.
         */
    public function show(string $id)
    {
        try {
            $historial = Historial::with(['usuario', 'equipo'])->find($id);

            if (!$historial) {
                return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $historial], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified historial in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $historial = Historial::find($id);

            if (!$historial) {
                return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'usuario_id' => 'sometimes|integer|exists:usuarios,id',
                'equipos_o_elementos_id' => 'sometimes|integer|exists:equipos_o_elementos,id',
                'ingreso' => 'sometimes|date',
                'salida' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $historial->update($validator->validated());

            return response()->json([
                'success' => true,
                'data' => $historial->fresh()->load(['usuario', 'equipo'])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified historial from storage.
     */
    public function destroy(string $id)
    {
        try {
            $historial = Historial::find($id);

            if (!$historial) {
                return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
            }

            $historial->delete();

            return response()->json([
                'success' => true,
                'message' => 'El historial con id: ' . $id . ' fue eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get historial by usuario
     */
    public function getByUsuario(string $usuarioId)
    {
        try {
            // Check if usuario exists
            $usuario = \App\Models\User::find($usuarioId);
            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            $historiales = Historial::with(['usuario', 'equipo'])
                ->where('usuario_id', $usuarioId)
                ->get();

            return response()->json(['success' => true, 'data' => $historiales], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve historial by usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get historial by equipo
     */
    public function getByEquipo(string $equipoId)
    {
        try {
            // Check if equipo exists
            $equipo = \App\Models\EquipoOElemento::find($equipoId);
            if (!$equipo) {
                return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
            }

            $historiales = Historial::with(['usuario', 'equipo'])
                ->where('equipos_o_elementos_id', $equipoId)
                ->get();

            return response()->json(['success' => true, 'data' => $historiales], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve historial by equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register equipment entry (ingreso)
     */
    public function registrarIngreso(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usuario_id' => 'required|integer|exists:usuarios,id',
                'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $historial = Historial::create([
                'usuario_id' => $request->usuario_id,
                'equipos_o_elementos_id' => $request->equipos_o_elementos_id,
                'ingreso' => now(),
            ]);

            // Enviar notificación de ingreso de equipo
            try {
                $equipo = $historial->equipo;
                $notificationController = new NotificationController();
                $notificationController->sendPushNotification(
                    $request->usuario_id,
                    'Entrada Registrada',
                    "Ingreso registrado: {$equipo->tipo_elemento} {$equipo->marca}",
                    [
                        'type' => 'entry_registered',
                        'historial_id' => $historial->id,
                        'equipment_id' => $equipo->id,
                        'timestamp' => now()->toIso8601String(),
                        'navigate_to' => 'historial',
                    ]
                );
            } catch (\Exception $e) {
                \Log::warning('No se pudo enviar notificación de ingreso: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Ingreso registrado correctamente',
                'data' => $historial->load(['usuario', 'equipo'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register ingreso',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register equipment exit (salida)
     */
    public function registrarSalida(string $id)
    {
        try {
            $historial = Historial::find($id);

            if (!$historial) {
                return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
            }

            if ($historial->salida) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya se registró una salida para este historial'
                ], 400);
            }

            $historial->update(['salida' => now()]);

            // Enviar notificación de salida de equipo
            try {
                $equipo = $historial->equipo;
                $notificationController = new NotificationController();
                $notificationController->sendPushNotification(
                    $historial->usuario_id,
                    'Salida Registrada',
                    "Salida registrada: {$equipo->tipo_elemento} {$equipo->marca}",
                    [
                        'type' => 'exit_registered',
                        'historial_id' => $historial->id,
                        'equipment_id' => $equipo->id,
                        'timestamp' => now()->toIso8601String(),
                        'navigate_to' => 'historial',
                    ]
                );
            } catch (\Exception $e) {
                \Log::warning('No se pudo enviar notificación de salida: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Salida registrada correctamente',
                'data' => $historial->fresh()->load(['usuario', 'equipo'])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register salida',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get historial for authenticated user
     */
    public function getByAuthUser()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $historiales = Historial::with(['equipo.elementosAdicionales'])
                ->where('usuario_id', $user->id)
                ->orderBy('ingreso', 'desc')
                ->get()
                ->map(function ($historial) {
                    return [
                        'id' => $historial->id,
                        'ingreso' => $historial->ingreso,
                        'salida' => $historial->salida,
                        'equipo' => $historial->equipo
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $historiales
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve historial for user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function registerEntrance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usuario_id' => 'required|integer|exists:usuarios,id',
                'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
                'datetime' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (Carbon::parse($request->datetime)->isFuture()) {
                return response()->json(['success' => false, 'message' => 'La fecha de entrada no puede ser futura'], 400);
            }

            $historial = Historial::create([
                'usuario_id' => $request->usuario_id,
                'equipos_o_elementos_id' => $request->equipos_o_elementos_id,
                'ingreso' => $request->datetime,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Entrada registrada correctamente',
                'data' => $historial->load(['usuario', 'equipo'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register entrance',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
 