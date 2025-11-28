<?php

namespace App\Http\Controllers;

use App\Models\EquipoOElemento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show($filename)
    {
        $path = null;

        // Check if it's an equipment photo
        $equipo = EquipoOElemento::where('path_foto_equipo_implemento', $filename)->first();
        if ($equipo) {
            $path = 'fotos_equipos/' . $filename;
        } else {
            // Check if it's a user photo
            $usuario = User::where('path_foto', $filename)->first();
            if ($usuario) {
                $path = 'fotos/' . $filename;
            }
        }

        if (!$path) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        return Storage::disk('public')->response($path);
    }
}