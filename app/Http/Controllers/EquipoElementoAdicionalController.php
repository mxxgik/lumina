<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use App\Models\ElementoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoElementoAdicionalController
{
    /**
     * Obtener todas las asignaciones de elementos adicionales a equipos
     */
    public function index()
    {
        try {
            $equipos = EquipoOElemento::with('elementosAdicionales')->get();
            return response()->json([
                'success' => true,
                'data' => $equipos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve asignaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener elementos adicionales de un equipo específico
     */
    public function show(string $equipoId)
    {
        try {
            $equipo = EquipoOElemento::with('elementosAdicionales')->find($equipoId);

            if (!$equipo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipo no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $equipo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve equipo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Asignar elementos adicionales a un equipo
     */
    public function assign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
            'elementos_adicionales_ids' => 'required|array',
            'elementos_adicionales_ids.*' => 'integer|exists:elementos_adicionales,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $equipo = EquipoOElemento::find($request->equipos_o_elementos_id);
        $equipo->elementosAdicionales()->syncWithoutDetaching($request->elementos_adicionales_ids);

        return response()->json([
            'success' => true,
            'message' => 'Elementos adicionales asignados correctamente',
            'data' => $equipo->load('elementosAdicionales')
        ], 200);
    }

    /**
     * Quitar elementos adicionales de un equipo
     */
    public function detach(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
            'elementos_adicionales_ids' => 'required|array',
            'elementos_adicionales_ids.*' => 'integer|exists:elementos_adicionales,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $equipo = EquipoOElemento::find($request->equipos_o_elementos_id);
        $equipo->elementosAdicionales()->detach($request->elementos_adicionales_ids);

        return response()->json([
            'success' => true,
            'message' => 'Elementos adicionales removidos correctamente',
            'data' => $equipo->load('elementosAdicionales')
        ], 200);
    }
}
