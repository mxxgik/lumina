<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuarioController
{
    /**
     * Display a listing of the usuarios.
     */
    public function index()
    {
        $usuarios = User::with(['role', 'formacion'])->get();
        return response()->json(['success' => true, 'data' => $usuarios], 200);
    }

    /**
     * Store a newly created usuario in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'formacion_id' => 'nullable|exists:formacion,id',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:50',
            'documento' => 'required|string|max:50',
            'edad' => 'nullable|integer|min:1|max:120',
            'numero_telefono' => 'nullable|string|max:20',
            'path_foto' => 'nullable|string',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);
        
        $usuario = User::create($data);

        return response()->json([
            'success' => true, 
            'data' => $usuario->load(['role', 'formacion'])
        ], 201);
    }

    /**
     * Display the specified usuario.
     */
    public function show(string $id)
    {
        $usuario = User::with(['role', 'formacion', 'equipos', 'historiales'])->find($id);

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $usuario], 200);
    }

    /**
     * Update the specified usuario in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'role_id' => 'sometimes|exists:roles,id',
            'formacion_id' => 'nullable|exists:formacion,id',
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'tipo_documento' => 'sometimes|string|max:50',
            'documento' => 'sometimes|string|max:50',
            'edad' => 'nullable|integer|min:1|max:120',
            'numero_telefono' => 'nullable|string|max:20',
            'path_foto' => 'nullable|string',
            'email' => 'sometimes|email|unique:usuarios,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $data = $validator->validated();
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $usuario->update($data);

        return response()->json([
            'success' => true, 
            'data' => $usuario->fresh()->load(['role', 'formacion'])
        ], 200);
    }

    /**
     * Remove the specified usuario from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json([
            'success' => true, 
            'message' => 'El usuario con id: ' . $id . ' fue eliminado correctamente'
        ], 200);
    }

    /**
     * Get usuarios by role
     */
    public function getByRole(string $roleId)
    {
        $usuarios = User::with(['role', 'formacion'])
            ->where('role_id', $roleId)
            ->get();

        return response()->json(['success' => true, 'data' => $usuarios], 200);
    }

    /**
     * Get usuarios by formacion
     */
    public function getByFormacion(string $formacionId)
    {
        $usuarios = User::with(['role', 'formacion'])
            ->where('formacion_id', $formacionId)
            ->get();

        return response()->json(['success' => true, 'data' => $usuarios], 200);
    }
}
