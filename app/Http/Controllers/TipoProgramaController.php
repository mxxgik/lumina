<?php

namespace App\Http\Controllers;

use App\Models\TipoPrograma;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TipoProgramaController
{
    public function index()
    {
        $ProgramTypes = TipoPrograma::all();
        return response()-> json(['success' => true, 'data' => $ProgramTypes ], 200);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nivel_formacion' => 'required|string'
        ]);

        if ($validator -> fails())
        {
            return response()->json(['success' => false, 'error' => $validator -> errors()]);
        }

        $ProgramType = TipoPrograma::create($validator -> validated());
        
        return response() ->json(['success' => true, 'data' => $ProgramType], 200);
    }
    
    public function show(string $id)  
    {
        $ProgramType = TipoPrograma::where('id', $id);
        
        if (!$ProgramType) 
        {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 400);
        }

        return response()->json(['success' => true, 'data' => $ProgramType], 200);
    }
    
    public function update(Request $request, string $id)  
    {
        $ProgramType = TipoPrograma::where('id', $id);
        
        if(!$ProgramType)
        {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 400);
        }
        
        $validator = Validator::make($request -> all(), [
            'nivel_formacion' => 'required|string'
        ]);
        
        if ($validator -> fails()) 
        {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        
        $ProgramType->update($validator -> validated());
    
        return response()->json(['success' => true, 'data' => $ProgramType], 200);
    }
    
    public function destroy(string $id)
    {
        $ProgramType = TipoPrograma::where('id', $id);
        
        if(!$ProgramType)
        {
            return response()->json(['success' => false, 'message' => 'Tipo de Programa no Encontrado'], 400);
        }
        
        $ProgramType->delete();

        return response()->json(['success' => true, 'message' => 'El tipo de programa correspondiente a el id: ' .$id. ' fue eliminado correctamente'], 200);
    }
}