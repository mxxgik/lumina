<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController 
{
    /**
     * Register a new user
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            if (isset($data['formacion_id']) && $data['formacion_id'] === "null") {
                $data['formacion_id'] = null;
            }
            $request->merge($data);

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:usuarios,email',
                'password' => 'required|min:8',
                'role_id' => 'required|exists:roles,id',
                'formacion_id' => 'nullable|exists:formacion,id',
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipo_documento' => 'required|string|max:50',
                'documento' => 'required|string|max:50',
                'edad' => 'nullable|integer|min:1|max:120',
                'numero_telefono' => 'nullable|string|max:20',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Crear el usuario con todos los datos
            $user = User::create([
                'role_id' => $request->role_id,
                'formacion_id' => $request->formacion_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'tipo_documento' => $request->tipo_documento,
                'documento' => $request->documento,
                'edad' => $request->edad,
                'numero_telefono' => $request->numero_telefono,
                'path_foto' => $request->path_foto,
            ]);

            // Crear token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user->load(['role', 'formacion']),
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Login user and create token
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Intentar autenticar
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;


            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user->load(['role', 'formacion']),
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user info
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user()->load(['role', 'formacion']);
            
            return response()->json([
                'success' => true,
                'message' => 'User info retrieved successfully',
                'data' => [
                    'user' => $user
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user info',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $data = $request->all();
            if (isset($data['formacion_id']) && $data['formacion_id'] === "null") {
                $data['formacion_id'] = null;
            }
            $request->merge($data);

            $validator = Validator::make($request->all(), [
                'email' => 'sometimes|email|unique:usuarios,email,' . $user->id,
                'password' => 'sometimes|min:8|confirmed',
                'role_id' => 'sometimes|exists:roles,id',
                'formacion_id' => 'nullable|exists:formacion,id',
                'nombre' => 'sometimes|string|max:255',
                'apellido' => 'sometimes|string|max:255',
                'tipo_documento' => 'sometimes|string|max:50',
                'documento' => 'sometimes|string|max:50',
                'edad' => 'nullable|integer|min:1|max:120',
                'numero_telefono' => 'nullable|string|max:20',
                'path_foto' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Actualizar usuario con todos los campos
            $userData = $request->only([
                'email', 'role_id', 'formacion_id', 'nombre', 'apellido',
                'tipo_documento', 'documento', 'edad', 'numero_telefono', 'path_foto'
            ]);
            
            if ($request->has('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user->fresh()->load(['role', 'formacion'])
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Profile update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user (revoke current token)
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out from all devices successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout from all devices failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user tokens info
     */
    public function tokens(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $tokens = $user->tokens()->select(['id', 'name', 'last_used_at', 'created_at'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Tokens retrieved successfully',
                'data' => [
                    'tokens' => $tokens,
                    'total' => $tokens->count()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tokens',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Revoke specific token
     */
    public function revokeToken(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'token_id' => 'required|integer|exists:personal_access_tokens,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = $request->user();
            $token = $user->tokens()->where('id', $request->token_id)->first();

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not found or does not belong to user'
                ], 404);
            }

            $token->delete();

            return response()->json([
                'success' => true,
                'message' => 'Token revoked successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke token',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
