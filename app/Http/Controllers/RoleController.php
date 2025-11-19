<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json(['success' => true, 'data' => $roles], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve roles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_rol' => 'required|in:usuario,admin,portero',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $role = Role::create($validator->validated());

            return response()->json(['success' => true, 'data' => $role], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified role.
     */
    public function show(string $id)
    {
        try {
            $role = Role::with(['usuarios'])->find($id);

            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
            }

            return response()->json(['success' => true, 'data' => $role], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre_rol' => 'sometimes|in:usuario,admin,portero',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $role->update($validator->validated());

            return response()->json(['success' => true, 'data' => $role], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'El role con id: ' . $id . ' fue eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
