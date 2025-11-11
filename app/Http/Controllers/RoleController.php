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
        $roles = Role::all();
        return response()->json(['success' => true, 'data' => $roles], 200);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_rol' => 'required|in:usuario,admin,portero',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $role = Role::create($validator->validated());

        return response()->json(['success' => true, 'data' => $role], 201);
    }

    /**
     * Display the specified role.
     */
    public function show(string $id)
    {
        $role = Role::with(['usuarios'])->find($id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $role], 200);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre_rol' => 'sometimes|in:usuario,admin,portero',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $role->update($validator->validated());

        return response()->json(['success' => true, 'data' => $role], 200);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role no encontrado'], 404);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'El role con id: ' . $id . ' fue eliminado correctamente'
        ], 200);
    }
}
