<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UsuarioController
{
    /**
     * Display a listing of the usuarios.
     */
    public function index()
    {
        try {
            $usuarios = User::with(['role', 'formacion'])->get();
            return response()->json(['success' => true, 'data' => $usuarios], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created usuario in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['formacion_id']) && $data['formacion_id'] === "null") {
                $data['formacion_id'] = null;
            }
            $request->merge($data);

            $validator = Validator::make($request->all(), [
                'role_id' => 'required|exists:roles,id',
                'formacion_id' => 'nullable|exists:formacion,id',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipo_documento' => 'required|string|max:50',
                'documento' => 'required|string|max:50',
                'edad' => 'nullable|integer|min:1|max:120',
                'numero_telefono' => 'nullable|string|max:20',
                'path_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('path_foto')) {
                $path = $request->file('path_foto')->store('fotos', 'local');
                $data['path_foto'] = basename($path);
            }

            $data['password'] = Hash::make($data['password']);

            $usuario = User::create($data);

            return response()->json([
                'success' => true,
                'data' => $usuario->load(['role', 'formacion'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified usuario.
     */
    public function show(string $id)
    {
        try {
            $usuario = User::with(['role', 'formacion', 'equipos', 'historiales'])->find($id);

            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $usuario], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified usuario in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $usuario = User::find($id);

            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            $data = $request->all();
            if (isset($data['formacion_id']) && $data['formacion_id'] === "null") {
                $data['formacion_id'] = null;
            }
            $request->merge($data);

            $validator = Validator::make($request->all(), [
                'role_id' => 'sometimes|exists:roles,id',
                'formacion_id' => 'nullable|exists:formacion,id',
                'nombre' => 'sometimes|string|max:255',
                'apellido' => 'sometimes|string|max:255',
                'tipo_documento' => 'sometimes|string|max:50',
                'documento' => 'sometimes|string|max:50',
                'edad' => 'nullable|integer|min:1|max:120',
                'numero_telefono' => 'nullable|string|max:20',
                'path_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'sometimes|email|unique:usuarios,email,' . $id,
                'password' => 'sometimes|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('path_foto')) {
                $path = $request->file('path_foto')->store('fotos', 'local');
                $data['path_foto'] = basename($path);
            }

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $usuario->update($data);

            return response()->json([
                'success' => true,
                'data' => $usuario->fresh()->load(['role', 'formacion'])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified usuario from storage.
     */
    public function destroy(string $id)
    {
        try {
            $usuario = User::find($id);

            if (!$usuario) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            $usuario->delete();

            return response()->json([
                'success' => true,
                'message' => 'El usuario con id: ' . $id . ' fue eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get usuarios by role
     */
    public function getByRole(string $roleId)
    {
        try {
            // Check if role exists
            $role = \App\Models\Role::find($roleId);
            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
            }

            $usuarios = User::with(['role', 'formacion'])
                ->where('role_id', $roleId)
                ->get();

            return response()->json(['success' => true, 'data' => $usuarios], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuarios by role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get usuarios by formacion
     */
    public function getByFormacion(string $formacionId)
    {
        try {
            // Check if formacion exists
            $formacion = \App\Models\Formacion::find($formacionId);
            if (!$formacion) {
                return response()->json(['success' => false, 'message' => 'Formación no encontrada'], 404);
            }

            $usuarios = User::with(['role', 'formacion'])
                ->where('formacion_id', $formacionId)
                ->get();

            return response()->json(['success' => true, 'data' => $usuarios], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve usuarios by formacion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user's profile
     */
    public function profile()
    {
        try {
            $usuario = auth()->user();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ], 401);
            }

            $usuario->load(['role', 'formacion', 'equipos', 'historiales']);

            return response()->json(['success' => true, 'data' => $usuario], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getByIdentification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::find($request->id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            // Cargar equipos con sus elementos adicionales
            $user->load('equipos.elementosAdicionales');

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user by identification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
