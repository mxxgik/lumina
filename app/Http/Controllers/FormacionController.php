<?php

namespace App\Http\Controllers;

use App\Models\Formacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormacionController
{
    public function index()
    {
        $formaciones = Formacion::all();
        return response()->json(['success' => true, 'data' => $formaciones], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'aprendiz_id' => 'required|integer|exists:aprendiz,id',
            'tipo_programa_id' => 'required|integer|exists:tipos_programas,id',
            'ficha' => 'required|string|max:255',
            'fecha_fin_lectiva' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $formacion = Formacion::create($validator->validated());

        return response()->json(['success' => true, 'data' => $formacion], 201);
    }

    public function show(string $id)
    {
        $formacion = Formacion::find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $formacion], 200);
    }

    public function update(Request $request, string $id)
    {
        $formacion = Formacion::find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|integer|exists:users,id',
            'aprendiz_id' => 'sometimes|integer|exists:aprendiz,id',
            'tipo_programa_id' => 'sometimes|integer|exists:tipos_programas,id',
            'ficha' => 'sometimes|string|max:255',
            'fecha_fin_lectiva' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $formacion->update($validator->validated());

        return response()->json(['success' => true, 'data' => $formacion], 200);
    }

    public function destroy(string $id)
    {
        $formacion = Formacion::find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        $formacion->delete();

        return response()->json(['success' => true, 'message' => 'La formación con id: ' . $id . ' fue eliminada correctamente'], 200);
    }
}
