<?php

namespace App\Http\Controllers;

use App\Models\AprendizEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AprendizEquipoController
{
    public function index()
    {
        $asignaciones = AprendizEquipo::all();
        return response()->json(['success' => true, 'data' => $asignaciones], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aprendiz_id' => 'required|integer|exists:aprendiz,id',
            'equipo_id' => 'required|integer|exists:equipos_o_elementos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $asignacion = AprendizEquipo::create($validator->validated());

        return response()->json(['success' => true, 'data' => $asignacion], 201);
    }

    public function show(string $id)
    {
        $asignacion = AprendizEquipo::find($id);

        if (!$asignacion) {
            return response()->json(['success' => false, 'message' => 'Asignación no encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $asignacion], 200);
    }

    public function update(Request $request, string $id)
    {
        $asignacion = AprendizEquipo::find($id);

        if (!$asignacion) {
            return response()->json(['success' => false, 'message' => 'Asignación no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'aprendiz_id' => 'sometimes|integer|exists:aprendiz,id',
            'equipo_id' => 'sometimes|integer|exists:equipos_o_elementos,id',
            'cantidad' => 'sometimes|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $asignacion->update($validator->validated());

        return response()->json(['success' => true, 'data' => $asignacion], 200);
    }

    public function destroy(string $id)
    {
        $asignacion = AprendizEquipo::find($id);

        if (!$asignacion) {
            return response()->json(['success' => false, 'message' => 'Asignación no encontrada'], 404);
        }

        $asignacion->delete();

        return response()->json(['success' => true, 'message' => 'La asignación con id: ' . $id . ' fue eliminada correctamente'], 200);
    }
}
