<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EquipoOElementoController
{
    public function index()
    {
        try {
            $equipos = EquipoOElemento::with('usuarios')->get();
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
                'sn_equipo' => 'required|string|max:255',
                'marca' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255',
                'tipo_elemento' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'qr_hash' => 'required|string|max:255|unique:equipos_o_elementos,qr_hash',
                'path_foto_equipo_implemento' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('path_foto_equipo_implemento')) {
                $path = $request->file('path_foto_equipo_implemento')->store('fotos_equipos', 'local');
                $data['path_foto_equipo_implemento'] = basename($path);
            }

            // Fix PostgreSQL sequence if needed
            \DB::statement("SELECT setval('equipos_o_elementos_id_seq', (SELECT MAX(id) FROM equipos_o_elementos))");

            $equipo = EquipoOElemento::create($data);

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
                'sn_equipo' => 'sometimes|string|max:255',
                'marca' => 'nullable|string|max:255',
                'color' => 'nullable|string|max:255',
                'tipo_elemento' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string',
                'qr_hash' => 'sometimes|string|max:255|unique:equipos_o_elementos,qr_hash,' . $id,
                'path_foto_equipo_implemento' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('path_foto_equipo_implemento')) {
                $path = $request->file('path_foto_equipo_implemento')->store('fotos_equipos', 'local');
                $data['path_foto_equipo_implemento'] = basename($path);
            }

            $equipo->update($data);

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
