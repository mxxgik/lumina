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
        try {
            $nivelesFormacion = NivelFormacion::all();
            return response()->json(['success' => true, 'data' => $nivelesFormacion], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve niveles de formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created nivel de formacion in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nivel_formacion' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $nivelFormacion = NivelFormacion::create($validator->validated());

            return response()->json(['success' => true, 'data' => $nivelFormacion], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create nivel de formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified nivel de formacion.
     */
    public function show(string $id)
    {
        try {
            $nivelFormacion = NivelFormacion::with(['formaciones'])->find($id);

            if (!$nivelFormacion) {
                return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $nivelFormacion], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve nivel de formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified nivel de formacion in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $nivelFormacion = NivelFormacion::find($id);

            if (!$nivelFormacion) {
                return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nivel_formacion' => 'sometimes|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $nivelFormacion->update($validator->validated());

            return response()->json(['success' => true, 'data' => $nivelFormacion], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update nivel de formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified nivel de formacion from storage.
     */
    public function destroy(string $id)
    {
        try {
            $nivelFormacion = NivelFormacion::find($id);

            if (!$nivelFormacion) {
                return response()->json(['success' => false, 'message' => 'Nivel de formación no encontrado'], 404);
            }

            $nivelFormacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'El nivel de formación con id: ' . $id . ' fue eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete nivel de formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
