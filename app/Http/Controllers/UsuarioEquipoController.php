<?php

namespace App\Http\Controllers;

use App\Models\UsuarioEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioEquipoController extends Controller
{
    /**
     * Display a listing of the usuario_equipos.
     */
    public function index()
    {
        try {
            $usuarioEquipos = UsuarioEquipo::with(['usuario', 'equipo'])->get();
            return response()->json(['success' => true, 'data' => $usuarioEquipos], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuario equipos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created usuario_equipo in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usuario_id' => 'required|exists:usuarios,id',
                'equipos_o_elementos_id' => 'required|exists:equipos_o_elementos,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Check if assignment already exists
            $existing = UsuarioEquipo::where('usuario_id', $data['usuario_id'])
                ->where('equipos_o_elementos_id', $data['equipos_o_elementos_id'])
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'This usuario-equipo assignment already exists'
                ], 409);
            }

            $usuarioEquipo = UsuarioEquipo::create($data);

            return response()->json(['success' => true, 'data' => $usuarioEquipo->load(['usuario', 'equipo'])], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create usuario equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified usuario_equipo.
     */
    public function show(string $id)
    {
        try {
            $usuarioEquipo = UsuarioEquipo::with(['usuario', 'equipo'])->find($id);

            if (!$usuarioEquipo) {
                return response()->json(['success' => false, 'message' => 'Usuario equipo not found'], 404);
            }

            return response()->json(['success' => true, 'data' => $usuarioEquipo], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuario equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified usuario_equipo in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $usuarioEquipo = UsuarioEquipo::find($id);

            if (!$usuarioEquipo) {
                return response()->json(['success' => false, 'message' => 'Usuario equipo not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'usuario_id' => 'sometimes|exists:usuarios,id',
                'equipos_o_elementos_id' => 'sometimes|exists:equipos_o_elementos,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Check for duplicates if updating
            if (isset($data['usuario_id']) || isset($data['equipos_o_elementos_id'])) {
                $newUsuarioId = $data['usuario_id'] ?? $usuarioEquipo->usuario_id;
                $newEquipoId = $data['equipos_o_elementos_id'] ?? $usuarioEquipo->equipos_o_elementos_id;

                $existing = UsuarioEquipo::where('usuario_id', $newUsuarioId)
                    ->where('equipos_o_elementos_id', $newEquipoId)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existing) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This usuario-equipo assignment already exists'
                    ], 409);
                }
            }

            $usuarioEquipo->update($data);

            return response()->json(['success' => true, 'data' => $usuarioEquipo->fresh()->load(['usuario', 'equipo'])], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update usuario equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified usuario_equipo from storage.
     */
    public function destroy(string $id)
    {
        try {
            $usuarioEquipo = UsuarioEquipo::find($id);

            if (!$usuarioEquipo) {
                return response()->json(['success' => false, 'message' => 'Usuario equipo not found'], 404);
            }

            $usuarioEquipo->delete();

            return response()->json(['success' => true, 'message' => 'Usuario equipo assignment removed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete usuario equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}