<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use App\Models\HistorialElementoAdicional;
use Illuminate\Support\Facades\Validator;

class HistorialElementoAdicionalController
{
    public function index()
    {
        $AdditElementHistory = HistorialElementoAdicional::all();
        return response()->json(['success' => true, 'data' => $AdditElementHistory], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'historial_id' => 'required|string',
            'aprendiz_elemento_adicional_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $AdditElementEntrance = HistorialElementoAdicional::create($validator->validated());

        return response()->json(['success' => true, 'data' => $AdditElementEntrance], 200);
    }

    public function show(string $id)
    {
        $AdditElementEntrace = HistorialElementoAdicional::where('id', $id);

        if (!$AdditElementEntrace) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrado'], 400);
        }

        return response()->json(['success' => true, 'data' => $AdditElementEntrace], 200);
    }

    public function update(Request $request, string $id)
    {
        $AdditElementEntrace = HistorialElementoAdicional::where('id', $id);

        if (!$AdditElementEntrace) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrada'], 400);
        }

        $validator = Validator::make($request->all(), [
            'nivel_formacion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $AdditElementEntrace->update($validator->validated());

        return response()->json(['success' => true, 'data' => $AdditElementEntrace], 200);
    }

    public function destroy(string $id)
    {
        $AdditElementEntrace = HistorialElementoAdicional::where('id', $id);

        if (!$AdditElementEntrace) {
            return response()->json(['success' => false, 'message' => 'Entrada en el historial no encontrada'], 400);
        }

        $AdditElementEntrace->delete();

        return response()->json(['success' => true, 'message' => 'La entrada en el historial correspondiente al id: ' . $id . ' fue eliminada correctamente'], 200);
    }
}
