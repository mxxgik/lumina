<?php

namespace App\Http\Controllers;

use App\Models\ElementoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElementoAdicionalController
{
    public function index()
    {
        try {
            $elementos = ElementoAdicional::all();
            return response()->json(['success' => true, 'data' => $elementos], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve elementos adicionales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $elemento = ElementoAdicional::create($validator->validated());

            return response()->json(['success' => true, 'data' => $elemento], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create elemento adicional',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $elemento = ElementoAdicional::find($id);

            if (!$elemento) {
                return response()->json(['success' => false, 'message' => 'Elemento adicional no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $elemento], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve elemento adicional',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $elemento = ElementoAdicional::find($id);

            if (!$elemento) {
                return response()->json(['success' => false, 'message' => 'Elemento adicional no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'nullable|string',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $elemento->update($validator->validated());

            return response()->json(['success' => true, 'data' => $elemento], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update elemento adicional',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $elemento = ElementoAdicional::find($id);

            if (!$elemento) {
                return response()->json(['success' => false, 'message' => 'Elemento adicional no encontrado'], 404);
            }

            $elemento->delete();

            return response()->json(['success' => true, 'message' => 'El elemento adicional con id: ' . $id . ' fue eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete elemento adicional',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
