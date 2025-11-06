<?php

namespace App\Http\Controllers;

use App\Models\ElementoAdicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElementoAdicionalController
{
    public function index()
    {
        $elementos = ElementoAdicional::all();
        return response()->json(['success' => true, 'data' => $elementos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $elemento = ElementoAdicional::create($validator->validated());

        return response()->json(['success' => true, 'data' => $elemento], 201);
    }

    public function show(string $id)
    {
        $elemento = ElementoAdicional::find($id);

        if (!$elemento) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $elemento], 200);
    }

    public function update(Request $request, string $id)
    {
        $elemento = ElementoAdicional::find($id);

        if (!$elemento) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $elemento->update($validator->validated());

        return response()->json(['success' => true, 'data' => $elemento], 200);
    }

    public function destroy(string $id)
    {
        $elemento = ElementoAdicional::find($id);

        if (!$elemento) {
            return response()->json(['success' => false, 'message' => 'Elemento no encontrado'], 404);
        }

        $elemento->delete();

        return response()->json(['success' => true, 'message' => 'El elemento con id: ' . $id . ' fue eliminado correctamente'], 200);
    }
}
