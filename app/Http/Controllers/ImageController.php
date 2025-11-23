<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function show($filename)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $path = null;
        $authorized = false;

        // Check if it's an equipment photo
        $equipo = EquipoOElemento::where('path_foto_equipo_implemento', $filename)->first();
        if ($equipo) {
            $path = 'fotos_equipos/' . $filename;
            // Check if user owns this equipo
            $authorized = $user->equipos()->where('equipos_o_elementos_id', $equipo->id)->exists();
        } else {
            // Check if it's a user photo
            $usuario = User::where('path_foto', $filename)->first();
            if ($usuario) {
                $path = 'fotos/' . $filename;
                // User can access their own photo, or admin can access any
                $authorized = ($user->id == $usuario->id) || $user->role->slug === 'admin';
            }
        }

        if (!$path || !$authorized) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        if (!Storage::disk('local')->exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return Storage::disk('local')->response($path);
    }
}