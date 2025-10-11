<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HistorialController extends Controller
{
    public function index()
    {
        $history = Historial::all();
        return response()->json(['success' => true, 'data' => $history]);
    }

    public function store(Request $request)
    {
        // TODO: make sure datatypes are correct in accordance to the database table

        $validator = Validator::make($request->all(), [
            'aprendiz_id' => 'required|integer',
            'equipos_o_elementos_id' => 'required|integer',
            'elementos_adicionales_aprendiz_id' => 'required|integer',
            'fecha' => 'required|date',
            'hora_ingreso' => 'required',
            'hora_salida' => 'time'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        $entrance = Historial::create($validator->validated());
        return response()->json(['success' => true, 'data' => $entrance], 200);
    }
}
