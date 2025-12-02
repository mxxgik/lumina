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
                'nombre_elemento' => 'required|string|max:255',
                'equipos_o_elementos_id' => 'required|integer|exists:equipos_o_elementos,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Fix PostgreSQL sequence if needed
            \DB::statement("SELECT setval('elementos_adicionales_id_seq', (SELECT MAX(id) FROM elementos_adicionales))");

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
                'nombre_elemento' => 'sometimes|string|max:255',
                'equipos_o_elementos_id' => 'sometimes|integer|exists:equipos_o_elementos,id',
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
