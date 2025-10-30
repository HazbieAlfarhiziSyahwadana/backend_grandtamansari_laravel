<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UnitTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = UnitType::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('keyword', 'like', "%{$search}%");
            });
        }

        // Filter by bedroom
        if ($request->has('bedroom')) {
            $query->where('bedroom', $request->bedroom);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [$request->min_price]);
        }
        if ($request->has('max_price')) {
            $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [$request->max_price]);
        }

        // Filter by active status
        if ($request->has('active')) {
            $query->where('active', $request->active);
        }

        // Filter by gallery active status
        if ($request->has('gallery_active')) {
            $query->where('gallery_active', $request->gallery_active);
        }

        // Order by sort then latest
        $query->orderBy('sort', 'asc')->latest();

        $units = $query->paginate($request->per_page ?? 10);

        // Add image URLs to each unit
        $units->getCollection()->transform(function ($unit) {
            $unit->facade_image_url = $unit->facade_image_url;
            $unit->facade_mobile_image_url = $unit->facade_mobile_image_url; // BARU
            $unit->layout_image_url = $unit->layout_image_url;
            $unit->gallery_image_url = $unit->gallery_image_url;
            $unit->gallery_mobile_image_url = $unit->gallery_mobile_image_url; // BARU
            return $unit;
        });

        return response()->json([
            'success' => true,
            'data' => $units
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:unit_type,slug',
            'img_facade' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_facade_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // BARU
            'img_layout' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_gallery' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_gallery_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // BARU
            'land_area' => 'required|integer|min:0',
            'floor_area' => 'required|integer|min:0',
            'bedroom' => 'required|integer|min:0|max:255',
            'bathroom' => 'required|integer|min:0|max:255',
            'floor' => 'required|integer|min:0|max:255',
            'electricity' => 'required|integer|min:0',
            'carport' => 'required|integer|min:0|max:255',
            'width' => 'required|string|max:225',
            'price' => 'nullable|string|max:150',
            'promo_price' => 'nullable|string|max:150',
            'sisa_unit' => 'nullable|integer|min:0',
            'specification' => 'nullable|string',
            'keyword' => 'nullable|string',
            'caption' => 'nullable|string|max:225',
            'alt_text' => 'nullable|string|max:225',
            'sort' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'gallery_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Handle facade desktop image upload
        if ($request->hasFile('img_facade')) {
            $image = $request->file('img_facade');
            $imageName = time() . '_facade_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_facade'] = $image->storeAs('unit-types/facade', $imageName, 'public');
        }

        // BARU: Handle facade mobile image upload
        if ($request->hasFile('img_facade_mobile')) {
            $image = $request->file('img_facade_mobile');
            $imageName = time() . '_facade_mobile_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_facade_mobile'] = $image->storeAs('unit-types/facade', $imageName, 'public');
        }

        // Handle layout image upload
        if ($request->hasFile('img_layout')) {
            $image = $request->file('img_layout');
            $imageName = time() . '_layout_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_layout'] = $image->storeAs('unit-types/layout', $imageName, 'public');
        }

        // Handle gallery desktop image upload
        if ($request->hasFile('img_gallery')) {
            $image = $request->file('img_gallery');
            $imageName = time() . '_gallery_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_gallery'] = $image->storeAs('unit-types/gallery', $imageName, 'public');
        }

        // BARU: Handle gallery mobile image upload
        if ($request->hasFile('img_gallery_mobile')) {
            $image = $request->file('img_gallery_mobile');
            $imageName = time() . '_gallery_mobile_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_gallery_mobile'] = $image->storeAs('unit-types/gallery', $imageName, 'public');
        }

        // Set default values
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['gallery_active'] = $request->has('gallery_active') ? 1 : 0;
        $data['sort'] = $data['sort'] ?? 0;

        $unit = UnitType::create($data);
        $unit->facade_image_url = $unit->facade_image_url;
        $unit->facade_mobile_image_url = $unit->facade_mobile_image_url; // BARU
        $unit->layout_image_url = $unit->layout_image_url;
        $unit->gallery_image_url = $unit->gallery_image_url;
        $unit->gallery_mobile_image_url = $unit->gallery_mobile_image_url; // BARU

        return response()->json([
            'success' => true,
            'message' => 'Unit type created successfully',
            'data' => $unit
        ], 201);
    }

    public function show($id)
    {
        $unit = UnitType::find($id);

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit type not found'
            ], 404);
        }

        $unit->facade_image_url = $unit->facade_image_url;
        $unit->facade_mobile_image_url = $unit->facade_mobile_image_url; // BARU
        $unit->layout_image_url = $unit->layout_image_url;
        $unit->gallery_image_url = $unit->gallery_image_url;
        $unit->gallery_mobile_image_url = $unit->gallery_mobile_image_url; // BARU

        return response()->json([
            'success' => true,
            'data' => $unit
        ]);
    }

    public function showBySlug($slug)
    {
        $unit = UnitType::where('slug', $slug)->first();

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit type not found'
            ], 404);
        }

        $unit->facade_image_url = $unit->facade_image_url;
        $unit->facade_mobile_image_url = $unit->facade_mobile_image_url; // BARU
        $unit->layout_image_url = $unit->layout_image_url;
        $unit->gallery_image_url = $unit->gallery_image_url;
        $unit->gallery_mobile_image_url = $unit->gallery_mobile_image_url; // BARU

        return response()->json([
            'success' => true,
            'data' => $unit
        ]);
    }

    public function update(Request $request, $id)
    {
        $unit = UnitType::find($id);

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit type not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:unit_type,slug,' . $id,
            'img_facade' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_facade_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // BARU
            'img_layout' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_gallery' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_gallery_mobile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // BARU
            'land_area' => 'required|integer|min:0',
            'floor_area' => 'required|integer|min:0',
            'bedroom' => 'required|integer|min:0|max:255',
            'bathroom' => 'required|integer|min:0|max:255',
            'floor' => 'required|integer|min:0|max:255',
            'electricity' => 'required|integer|min:0',
            'carport' => 'required|integer|min:0|max:255',
            'width' => 'required|string|max:225',
            'price' => 'nullable|string|max:150',
            'promo_price' => 'nullable|string|max:150',
            'sisa_unit' => 'nullable|integer|min:0',
            'specification' => 'nullable|string',
            'keyword' => 'nullable|string',
            'caption' => 'nullable|string|max:225',
            'alt_text' => 'nullable|string|max:225',
            'sort' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'gallery_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Handle facade desktop image upload
        if ($request->hasFile('img_facade')) {
            if ($unit->img_facade && Storage::disk('public')->exists($unit->img_facade)) {
                Storage::disk('public')->delete($unit->img_facade);
            }
            $image = $request->file('img_facade');
            $imageName = time() . '_facade_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_facade'] = $image->storeAs('unit-types/facade', $imageName, 'public');
        }

        // BARU: Handle facade mobile image upload
        if ($request->hasFile('img_facade_mobile')) {
            if ($unit->img_facade_mobile && Storage::disk('public')->exists($unit->img_facade_mobile)) {
                Storage::disk('public')->delete($unit->img_facade_mobile);
            }
            $image = $request->file('img_facade_mobile');
            $imageName = time() . '_facade_mobile_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_facade_mobile'] = $image->storeAs('unit-types/facade', $imageName, 'public');
        }

        // Handle layout image upload
        if ($request->hasFile('img_layout')) {
            if ($unit->img_layout && Storage::disk('public')->exists($unit->img_layout)) {
                Storage::disk('public')->delete($unit->img_layout);
            }
            $image = $request->file('img_layout');
            $imageName = time() . '_layout_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_layout'] = $image->storeAs('unit-types/layout', $imageName, 'public');
        }

        // Handle gallery desktop image upload
        if ($request->hasFile('img_gallery')) {
            if ($unit->img_gallery && Storage::disk('public')->exists($unit->img_gallery)) {
                Storage::disk('public')->delete($unit->img_gallery);
            }
            $image = $request->file('img_gallery');
            $imageName = time() . '_gallery_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_gallery'] = $image->storeAs('unit-types/gallery', $imageName, 'public');
        }

        // BARU: Handle gallery mobile image upload
        if ($request->hasFile('img_gallery_mobile')) {
            if ($unit->img_gallery_mobile && Storage::disk('public')->exists($unit->img_gallery_mobile)) {
                Storage::disk('public')->delete($unit->img_gallery_mobile);
            }
            $image = $request->file('img_gallery_mobile');
            $imageName = time() . '_gallery_mobile_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_gallery_mobile'] = $image->storeAs('unit-types/gallery', $imageName, 'public');
        }

        // Set default values
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['gallery_active'] = $request->has('gallery_active') ? 1 : 0;

        $unit->update($data);
        $unit->facade_image_url = $unit->facade_image_url;
        $unit->facade_mobile_image_url = $unit->facade_mobile_image_url; // BARU
        $unit->layout_image_url = $unit->layout_image_url;
        $unit->gallery_image_url = $unit->gallery_image_url;
        $unit->gallery_mobile_image_url = $unit->gallery_mobile_image_url; // BARU

        return response()->json([
            'success' => true,
            'message' => 'Unit type updated successfully',
            'data' => $unit
        ]);
    }

    public function destroy($id)
    {
        $unit = UnitType::find($id);

        if (!$unit) {
            return response()->json([
                'success' => false,
                'message' => 'Unit type not found'
            ], 404);
        }

        // Delete images
        if ($unit->img_facade && Storage::disk('public')->exists($unit->img_facade)) {
            Storage::disk('public')->delete($unit->img_facade);
        }
        if ($unit->img_facade_mobile && Storage::disk('public')->exists($unit->img_facade_mobile)) {
            Storage::disk('public')->delete($unit->img_facade_mobile); // BARU
        }
        if ($unit->img_layout && Storage::disk('public')->exists($unit->img_layout)) {
            Storage::disk('public')->delete($unit->img_layout);
        }
        if ($unit->img_gallery && Storage::disk('public')->exists($unit->img_gallery)) {
            Storage::disk('public')->delete($unit->img_gallery);
        }
        if ($unit->img_gallery_mobile && Storage::disk('public')->exists($unit->img_gallery_mobile)) {
            Storage::disk('public')->delete($unit->img_gallery_mobile); // BARU
        }

        $unit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unit type deleted successfully'
        ]);
    }
}