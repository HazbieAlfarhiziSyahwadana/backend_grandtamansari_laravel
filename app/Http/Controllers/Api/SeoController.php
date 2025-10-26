<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeoController extends Controller
{
    public function index()
    {
        $seos = Seo::all();
        
        return response()->json([
            'success' => true,
            'data' => $seos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|unique:seo,page',
            'title' => 'required|string',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $seo = Seo::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'SEO created successfully',
            'data' => $seo
        ], 201);
    }

    public function show($id)
    {
        $seo = Seo::find($id);
        
        if (!$seo) {
            return response()->json([
                'success' => false,
                'message' => 'SEO not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $seo->id,
                'page' => $seo->page->value,
                'title' => $seo->title,
                'keyword' => $seo->keyword,
                'description' => $seo->description,
                'created_at' => $seo->created_at,
                'updated_at' => $seo->updated_at,
            ]
        ]);
    }

    public function getByPage($page)
    {
        $seo = Seo::where('page', $page)->first();
        
        if (!$seo) {
            return response()->json([
                'success' => false,
                'message' => 'SEO not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $seo->id,
                'page' => $seo->page->value,
                'title' => $seo->title,
                'keyword' => $seo->keyword,
                'description' => $seo->description,
                'created_at' => $seo->created_at,
                'updated_at' => $seo->updated_at,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $seo = Seo::find($id);
        
        if (!$seo) {
            return response()->json([
                'success' => false,
                'message' => 'SEO not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'page' => 'required|string|unique:seo,page,' . $id,
            'title' => 'required|string',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $seo->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'SEO updated successfully',
            'data' => $seo
        ]);
    }

    public function destroy($id)
    {
        $seo = Seo::find($id);
        
        if (!$seo) {
            return response()->json([
                'success' => false,
                'message' => 'SEO not found'
            ], 404);
        }
        
        $seo->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'SEO deleted successfully'
        ]);
    }
}