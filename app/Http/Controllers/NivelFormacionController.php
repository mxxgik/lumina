<?php

namespace App\Http\Controllers;

use App\Models\NivelFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NivelFormacionController
{
    /**
     * Display a listing of the niveles de formacion.
     */
    public function index()
    {
        $nivelesFormacion = NivelFormacion::all();
        return response()->json(['success' => true, 'data' => $nivelesFormacion], 200);
    }

    /**
     * Store a newly created nivel de formacion in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nivel_formacion' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $nivelFormacion = NivelFormacion::create($validator->validated());

        return response()->json(['success' => true, 'data' => $nivelFormacion], 201);
    }

    /**
     * Display the specified nivel de formacion.
     */
    public function show(string $id)
    {
        $nivelFormacion = NivelFormacion::with(['formaciones'])->find($id);

        if (!$nivelFormacion) {
            return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $nivelFormacion], 200);
    }

    /**
     * Update the specified nivel de formacion in storage.
     */
    public function update(Request $request, string $id)
    {
        $nivelFormacion = NivelFormacion::find($id);

        if (!$nivelFormacion) {
            return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nivel_formacion' => 'sometimes|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $nivelFormacion->update($validator->validated());

        return response()->json(['success' => true, 'data' => $nivelFormacion], 200);
    }

    /**
     * Remove the specified nivel de formacion from storage.
     */
    public function destroy(string $id)
    {
        $nivelFormacion = NivelFormacion::find($id);

        if (!$nivelFormacion) {
            return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
        }

        $nivelFormacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'El nivel de formación con id: ' . $id . ' fue eliminado correctamente'
        ], 200);
    }
}
