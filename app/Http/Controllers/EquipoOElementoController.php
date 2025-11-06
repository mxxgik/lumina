<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoOElementoController
{
    public function index()
    {
        $equipos = EquipoOElemento::all();
        return response()->json(['success' => true, 'data' => $equipos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'placa' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'estado' => 'required|string|in:disponible,en_prestamo,de_baja,en_reparacion',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 400);
        }

        $equipo = EquipoOElemento::create($validator->validated());

        return response()->json(['success' => true, 'data' => $equipo], 201);
    }

    public function show(string $id)
    {
        $equipo = EquipoOElemento::find($id);

        if (!$equipo) {
            return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $equipo], 200);
    }

    public function update(Request $request, string $id)
    {
        $equipo = EquipoOElemento::find($id);

        if (!$equipo) {
            return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'placa' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'estado' => 'sometimes|string|in:disponible,en_prestamo,de_baja,en_reparacion',
            'path_foto' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $equipo->update($validator->validated());

        return response()->json(['success' => true, 'data' => $equipo], 200);
    }

    public function destroy(string $id)
    {
        $equipo = EquipoOElemento::find($id);

        if (!$equipo) {
            return response()->json(['success' => false, 'message' => 'Equipo o elemento no encontrado'], 404);
        }

        $equipo->delete();

        return response()->json(['success' => true, 'message' => 'El equipo o elemento con id: ' . $id . ' fue eliminado correctamente'], 200);
    }
}
