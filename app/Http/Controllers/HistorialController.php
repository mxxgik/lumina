<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialController
{
    public function index()
    {
        $historiales = Historial::all();
        return response()->json(['success' => true, 'data' => $historiales], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aprendiz_equipo_id' => 'required|integer|exists:aprendiz_equipos,id',
            'fecha_entrega' => 'required|date',
            'fecha_devolucion' => 'nullable|date',
            'observaciones_entrega' => 'nullable|string',
            'observaciones_devolucion' => 'nullable|string',
            'path_foto_devolucion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $historial = Historial::create($validator->validated());

        return response()->json(['success' => true, 'data' => $historial], 201);
    }

    public function show(string $id)
    {
        $historial = Historial::find($id);

        if (!$historial) {
            return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $historial], 200);
    }

    public function update(Request $request, string $id)
    {
        $historial = Historial::find($id);

        if (!$historial) {
            return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'aprendiz_equipo_id' => 'sometimes|integer|exists:aprendiz_equipos,id',
            'fecha_entrega' => 'sometimes|date',
            'fecha_devolucion' => 'nullable|date',
            'observaciones_entrega' => 'nullable|string',
            'observaciones_devolucion' => 'nullable|string',
            'path_foto_devolucion' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $historial->update($validator->validated());

        return response()->json(['success' => true, 'data' => $historial], 200);
    }

    public function destroy(string $id)
    {
        $historial = Historial::find($id);

        if (!$historial) {
            return response()->json(['success' => false, 'message' => 'Historial no encontrado'], 404);
        }

        $historial->delete();

        return response()->json(['success' => true, 'message' => 'El historial con id: ' . $id . ' fue eliminado correctamente'], 200);
    }
}
