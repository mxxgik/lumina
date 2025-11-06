<?php

namespace App\Http\Controllers;

use App\Models\HistorialElementoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialElementoAdicionalController
{
    public function index()
    {
        $historialEntradas = HistorialElementoAdicional::all();
        return response()->json(['success' => true, 'data' => $historialEntradas], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'historial_id' => 'required|integer|exists:historial,id',
            'aprendiz_elemento_adicional_id' => 'required|integer|exists:aprendiz_elementos_adicionales,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $historialEntrada = HistorialElementoAdicional::create($validator->validated());

        return response()->json(['success' => true, 'data' => $historialEntrada], 201);
    }

    public function show(string $id)
    {
        $historialEntrada = HistorialElementoAdicional::find($id);

        if (!$historialEntrada) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $historialEntrada], 200);
    }

    public function update(Request $request, string $id)
    {
        $historialEntrada = HistorialElementoAdicional::find($id);

        if (!$historialEntrada) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'historial_id' => 'sometimes|integer|exists:historial,id',
            'aprendiz_elemento_adicional_id' => 'sometimes|integer|exists:aprendiz_elementos_adicionales,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $historialEntrada->update($validator->validated());

        return response()->json(['success' => true, 'data' => $historialEntrada], 200);
    }

    public function destroy(string $id)
    {
        $historialEntrada = HistorialElementoAdicional::find($id);

        if (!$historialEntrada) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrada'], 404);
        }

        $historialEntrada->delete();

        return response()->json(['success' => true, 'message' => 'La entrada en el historial correspondiente al id: ' . $id . ' fue eliminada correctamente'], 200);
    }
}
