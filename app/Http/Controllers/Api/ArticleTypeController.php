<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleTypeController extends Controller
{
    public function index()
    {
        $articleTypes = ArticleType::withCount('articles')->get();

        return response()->json([
            'success' => true,
            'data' => $articleTypes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:225|unique:articletype,type',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $articleType = ArticleType::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Article type created successfully',
            'data' => $articleType
        ], 201);
    }

    public function show($id)
    {
        $articleType = ArticleType::withCount('articles')->find($id);

        if (!$articleType) {
            return response()->json([
                'success' => false,
                'message' => 'Article type not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $articleType
        ]);
    }

    public function update(Request $request, $id)
    {
        $articleType = ArticleType::find($id);

        if (!$articleType) {
            return response()->json([
                'success' => false,
                'message' => 'Article type not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:225|unique:articletype,type,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $articleType->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Article type updated successfully',
            'data' => $articleType
        ]);
    }

    public function destroy($id)
    {
        $articleType = ArticleType::find($id);

        if (!$articleType) {
            return response()->json([
                'success' => false,
                'message' => 'Article type not found'
            ], 404);
        }

        $articleType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article type deleted successfully'
        ]);
    }
}