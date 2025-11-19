<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoOElementoController
{
    public function index()
    {
        try {
            $equipos = EquipoOElemento::all();
            return response()->json(['success' => true, 'data' => $equipos], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve equipos o elementos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'placa' => 'nullable|string|max:255',
                'serial' => 'nullable|string|max:255',
                'estado' => 'required|string|in:disponible,en_prestamo,de_baja,en_reparacion',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $equipo = EquipoOElemento::create($validator->validated());

            return response()->json(['success' => true, 'data' => $equipo], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create equipo o elemento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $equipo = EquipoOElemento::find($id);

            if (!$equipo) {
                return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $equipo], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve equipo o elemento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $equipo = EquipoOElemento::find($id);

            if (!$equipo) {
                return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string',
                'placa' => 'nullable|string|max:255',
                'serial' => 'nullable|string|max:255',
                'estado' => 'sometimes|string|in:disponible,en_prestamo,de_baja,en_reparacion',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $equipo->update($validator->validated());

            return response()->json(['success' => true, 'data' => $equipo], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update equipo o elemento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $equipo = EquipoOElemento::find($id);

            if (!$equipo) {
                return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
            }

            $equipo->delete();

            return response()->json(['success' => true, 'message' => 'El equipo o elemento con id: ' . $id . ' fue eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete equipo o elemento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getByUser()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            // Cargar equipos con sus elementos adicionales
            $equipos = $user->equipos()->with('elementosAdicionales')->get();

            return response()->json([
                'success' => true,
                'data' => $equipos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve equipos for user',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getByHash(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'hash' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $equipo = EquipoOElemento::where('qr_hash', $request->hash)->with('elementosAdicionales')->first();

            if (!$equipo) {
                return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $equipo], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve equipo by hash',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
