<?php

namespace App\Http\Controllers;

use App\Models\TipoPrograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoProgramaController
{
    public function index()
    {
        $tiposPrograma = TipoPrograma::all();
        return response()->json(['success' => true, 'data' => $tiposPrograma], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nivel_formacion' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $tipoPrograma = TipoPrograma::create($validator->validated());

        return response()->json(['success' => true, 'data' => $tipoPrograma], 201);
    }

    public function show(string $id)
    {
        $tipoPrograma = TipoPrograma::find($id);

        if (!$tipoPrograma) {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $tipoPrograma], 200);
    }

    public function update(Request $request, string $id)
    {
        $tipoPrograma = TipoPrograma::find($id);

        if (!$tipoPrograma) {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nivel_formacion' => 'sometimes|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $tipoPrograma->update($validator->validated());

        return response()->json(['success' => true, 'data' => $tipoPrograma], 200);
    }

    public function destroy(string $id)
    {
        $tipoPrograma = TipoPrograma::find($id);

        if (!$tipoPrograma) {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 404);
        }

        $tipoPrograma->delete();

        return response()->json(['success' => true, 'message' => 'El tipo de programa correspondiente al id: ' . $id . ' fue eliminado correctamente'], 200);
    }
}
