<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AprendizController
{
    public function index()
    {
        $aprendices = Aprendiz::all();
        return response()->json(['success' => true, 'data' => $aprendices], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'tipo_documento' => 'required|string',
            'documento' => 'required|string',
            'edad' => 'required|integer',
            'numero_telefono' => 'required|string',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $aprendiz = Aprendiz::create($validator->validated());

        return response()->json(['success' => true, 'data' => $aprendiz], 201);
    }

    public function show(string $id)
    {
        $aprendiz = Aprendiz::find($id);

        if (!$aprendiz) {
            return response()->json(['success' => false, 'message' => 'Aprendiz no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $aprendiz], 200);
    }

    public function update(Request $request, string $id)
    {
        $aprendiz = Aprendiz::find($id);

        if (!$aprendiz) {
            return response()->json(['success' => false, 'message' => 'Aprendiz no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|integer',
            'nombre' => 'sometimes|string',
            'apellido' => 'sometimes|string',
            'tipo_documento' => 'sometimes|string',
            'documento' => 'sometimes|string',
            'edad' => 'sometimes|integer',
            'numero_telefono' => 'sometimes|string',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $aprendiz->update($validator->validated());

        return response()->json(['success' => true, 'data' => $aprendiz], 200);
    }

    public function destroy(string $id)
    {
        $aprendiz = Aprendiz::find($id);

        if (!$aprendiz) {
            return response()->json(['success' => false, 'message' => 'Aprendiz no encontrado'], 404);
        }

        $aprendiz->delete();

        return response()->json(['success' => true, 'message' => 'El aprendiz correspondiente al id: ' . $id . ' fue eliminado correctamente'], 200);
    }
}
