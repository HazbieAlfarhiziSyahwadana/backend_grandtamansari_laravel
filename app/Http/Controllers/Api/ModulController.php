<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModulController extends Controller
{
    public function index()
    {
        $moduls = Modul::orderBy('priority', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $moduls
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'modul_link' => 'required|string',
            'priority' => 'nullable|numeric|between:0,9.99',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $modul = Modul::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Modul created successfully',
            'data' => $modul
        ], 201);
    }

    public function show($id)
    {
        $modul = Modul::find($id);
        
        if (!$modul) {
            return response()->json([
                'success' => false,
                'message' => 'Modul not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $modul
        ]);
    }

    public function update(Request $request, $id)
    {
        $modul = Modul::find($id);
        
        if (!$modul) {
            return response()->json([
                'success' => false,
                'message' => 'Modul not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'modul_link' => 'required|string',
            'priority' => 'nullable|numeric|between:0,9.99',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $modul->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Modul updated successfully',
            'data' => $modul
        ]);
    }

    public function destroy($id)
    {
        $modul = Modul::find($id);
        
        if (!$modul) {
            return response()->json([
                'success' => false,
                'message' => 'Modul not found'
            ], 404);
        }
        
        $modul->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Modul deleted successfully'
        ]);
    }
}