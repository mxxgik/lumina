<?php

namespace App\Http\Controllers;

use App\Models\Formacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormacionController
{
    /**
     * Display a listing of the formaciones.
     */
    public function index()
    {
        $formaciones = Formacion::with(['nivelFormacion', 'usuarios'])->get();
        return response()->json(['success' => true, 'data' => $formaciones], 200);
    }

    /**
     * Store a newly created formacion in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nivel_formacion_id' => 'required|integer|exists:nivel_formacion,id',
            'ficha' => 'required|string|max:255',
            'nombre_programa' => 'required|string|max:255',
            'fecha_inicio_programa' => 'required|date',
            'fecha_fin_programa' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $formacion = Formacion::create($validator->validated());

        return response()->json([
            'success' => true, 
            'data' => $formacion->load('nivelFormacion')
        ], 201);
    }

    /**
     * Display the specified formacion.
     */
    public function show(string $id)
    {
        $formacion = Formacion::with(['nivelFormacion', 'usuarios'])->find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $formacion], 200);
    }

    /**
     * Update the specified formacion in storage.
     */
    public function update(Request $request, string $id)
    {
        $formacion = Formacion::find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nivel_formacion_id' => 'sometimes|integer|exists:nivel_formacion,id',
            'ficha' => 'sometimes|string|max:255',
            'nombre_programa' => 'sometimes|string|max:255',
            'fecha_inicio_programa' => 'sometimes|date',
            'fecha_fin_programa' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $formacion->update($validator->validated());

        return response()->json([
            'success' => true, 
            'data' => $formacion->fresh()->load('nivelFormacion')
        ], 200);
    }

    /**
     * Remove the specified formacion from storage.
     */
    public function destroy(string $id)
    {
        $formacion = Formacion::find($id);

        if (!$formacion) {
            return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
        }

        $formacion->delete();

        return response()->json([
            'success' => true, 
            'message' => 'La formación con id: ' . $id . ' fue eliminada correctamente'
        ], 200);
    }

    /**
     * Get formaciones by nivel de formacion
     */
    public function getByNivelFormacion(string $nivelFormacionId)
    {
        $formaciones = Formacion::with(['nivelFormacion', 'usuarios'])
            ->where('nivel_formacion_id', $nivelFormacionId)
            ->get();

        return response()->json(['success' => true, 'data' => $formaciones], 200);
    }
}
