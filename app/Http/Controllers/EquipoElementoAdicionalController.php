<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use App\Models\ElementoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoElementoAdicionalController
{
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
