<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('type')->active(); // Only active articles

        // Filter by article type
        if ($request->has('articletype_id')) {
            $query->where('articletype_id', $request->articletype_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('keyword', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->paginate($request->per_page ?? 10);

        // image_url sudah otomatis ada dari $appends di model

        return response()->json([
            'success' => true,
            'data' => $articles
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'articletype_id' => 'required|exists:articletype,id',
            'title' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:article,slug',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:225',
            'content' => 'required|string',
            'keyword' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['active'] = $request->input('active', 0);

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('articles', 'public');
        }

        $article = Article::create($data);
        $article->load('type');

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully',
            'data' => $article
        ], 201);
    }

    public function show($id)
    {
        $article = Article::with('type')->find($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $article
        ]);
    }

    public function showBySlug($slug)
    {
        $article = Article::with('type')->where('slug', $slug)->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $article
        ]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'articletype_id' => 'required|exists:articletype,id',
            'title' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:article,slug,' . $id,
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'caption' => 'nullable|string|max:225',
            'content' => 'required|string',
            'keyword' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        
        if ($request->has('active')) {
            $data['active'] = $request->input('active');
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($article->gambar && Storage::disk('public')->exists($article->gambar)) {
                Storage::disk('public')->delete($article->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('articles', 'public');
        }

        $article->update($data);
        $article->load('type');

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully',
            'data' => $article
        ]);
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        }

        // Delete image
        if ($article->gambar && Storage::disk('public')->exists($article->gambar)) {
            Storage::disk('public')->delete($article->gambar);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully'
        ]);
    }
}