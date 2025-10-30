<?php

// SlideshowController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SlideshowController extends Controller
{
    public function index()
    {
        // Hanya tampilkan slideshow yang aktif untuk API public
        $slideshows = Slideshow::where('active', 1)
            ->orderBy('sort', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $slideshows
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:225',
            'gambar_desktop' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gambar_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'link' => 'nullable|string|max:225',
            'sort' => 'nullable|integer|min:0',
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
        $data['active'] = $request->input('active', 0); // Default 0 jika tidak ada

        if ($request->hasFile('gambar_desktop')) {
            $data['gambar_desktop'] = $request->file('gambar_desktop')->store('slideshow/desktop', 'public');
        }
        if ($request->hasFile('gambar_mobile')) {
            $data['gambar_mobile'] = $request->file('gambar_mobile')->store('slideshow/mobile', 'public');
        }

        $slideshow = Slideshow::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Slideshow created successfully',
            'data' => $slideshow
        ], 201);
    }

    public function show($id)
    {
        $slideshow = Slideshow::find($id);
        
        if (!$slideshow) {
            return response()->json([
                'success' => false,
                'message' => 'Slideshow not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $slideshow
        ]);
    }

    public function update(Request $request, $id)
    {
        $slideshow = Slideshow::find($id);
        
        if (!$slideshow) {
            return response()->json([
                'success' => false,
                'message' => 'Slideshow not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:225',
            'gambar_desktop' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gambar_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'link' => 'nullable|string|max:225',
            'sort' => 'nullable|integer|min:0',
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
        
        // Handle active field
        if ($request->has('active')) {
            $data['active'] = $request->input('active');
        }

        if ($request->hasFile('gambar_desktop')) {
            if ($slideshow->gambar_desktop) Storage::disk('public')->delete($slideshow->gambar_desktop);
            $data['gambar_desktop'] = $request->file('gambar_desktop')->store('slideshow/desktop', 'public');
        }
        if ($request->hasFile('gambar_mobile')) {
            if ($slideshow->gambar_mobile) Storage::disk('public')->delete($slideshow->gambar_mobile);
            $data['gambar_mobile'] = $request->file('gambar_mobile')->store('slideshow/mobile', 'public');
        }

        $slideshow->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Slideshow updated successfully',
            'data' => $slideshow
        ]);
    }

    public function destroy($id)
    {
        $slideshow = Slideshow::find($id);
        
        if (!$slideshow) {
            return response()->json([
                'success' => false,
                'message' => 'Slideshow not found'
            ], 404);
        }

        if ($slideshow->gambar_desktop) Storage::disk('public')->delete($slideshow->gambar_desktop);
        if ($slideshow->gambar_mobile) Storage::disk('public')->delete($slideshow->gambar_mobile);
        
        $slideshow->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slideshow deleted successfully'
        ]);
    }
}