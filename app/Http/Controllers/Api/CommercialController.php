<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Commercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CommercialController extends Controller
{
    public function index(Request $request)
    {
        $query = Commercial::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $commercials = $query->latest()->paginate($request->per_page ?? 10);

        // Add image URLs
        $commercials->getCollection()->transform(function ($commercial) {
            $commercial->commercial_image_url = $commercial->commercial_image_url;
            $commercial->area_image_url = $commercial->area_image_url;
            return $commercial;
        });

        return response()->json([
            'success' => true,
            'data' => $commercials
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:commercial,slug',
            'img_commercial' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_area' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'land_area' => 'required|integer|min:0',
            'floor_area' => 'required|integer|min:0',
            'hargamulai' => 'required|string|max:225',
            'width' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('img_commercial')) {
            $image = $request->file('img_commercial');
            $imageName = time() . '_commercial_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_commercial'] = $image->storeAs('commercial', $imageName, 'public');
        }

        if ($request->hasFile('img_area')) {
            $image = $request->file('img_area');
            $imageName = time() . '_area_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_area'] = $image->storeAs('commercial/area', $imageName, 'public');
        }

        $commercial = Commercial::create($data);
        $commercial->commercial_image_url = $commercial->commercial_image_url;
        $commercial->area_image_url = $commercial->area_image_url;

        return response()->json([
            'success' => true,
            'message' => 'Commercial created successfully',
            'data' => $commercial
        ], 201);
    }

    public function show($id)
    {
        $commercial = Commercial::find($id);

        if (!$commercial) {
            return response()->json([
                'success' => false,
                'message' => 'Commercial not found'
            ], 404);
        }

        $commercial->commercial_image_url = $commercial->commercial_image_url;
        $commercial->area_image_url = $commercial->area_image_url;

        return response()->json([
            'success' => true,
            'data' => $commercial
        ]);
    }

    public function showBySlug($slug)
    {
        $commercial = Commercial::where('slug', $slug)->first();

        if (!$commercial) {
            return response()->json([
                'success' => false,
                'message' => 'Commercial not found'
            ], 404);
        }

        $commercial->commercial_image_url = $commercial->commercial_image_url;
        $commercial->area_image_url = $commercial->area_image_url;

        return response()->json([
            'success' => true,
            'data' => $commercial
        ]);
    }

    public function update(Request $request, $id)
    {
        $commercial = Commercial::find($id);

        if (!$commercial) {
            return response()->json([
                'success' => false,
                'message' => 'Commercial not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'slug' => 'nullable|string|unique:commercial,slug,' . $id,
            'img_commercial' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'img_area' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'land_area' => 'required|integer|min:0',
            'floor_area' => 'required|integer|min:0',
            'hargamulai' => 'required|string|max:225',
            'width' => 'required|string|max:225',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('img_commercial')) {
            if ($commercial->img_commercial && Storage::disk('public')->exists($commercial->img_commercial)) {
                Storage::disk('public')->delete($commercial->img_commercial);
            }
            $image = $request->file('img_commercial');
            $imageName = time() . '_commercial_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_commercial'] = $image->storeAs('commercial', $imageName, 'public');
        }

        if ($request->hasFile('img_area')) {
            if ($commercial->img_area && Storage::disk('public')->exists($commercial->img_area)) {
                Storage::disk('public')->delete($commercial->img_area);
            }
            $image = $request->file('img_area');
            $imageName = time() . '_area_' . Str::slug($data['name']) . '.' . $image->getClientOriginalExtension();
            $data['img_area'] = $image->storeAs('commercial/area', $imageName, 'public');
        }

        $commercial->update($data);
        $commercial->commercial_image_url = $commercial->commercial_image_url;
        $commercial->area_image_url = $commercial->area_image_url;

        return response()->json([
            'success' => true,
            'message' => 'Commercial updated successfully',
            'data' => $commercial
        ]);
    }

    public function destroy($id)
    {
        $commercial = Commercial::find($id);

        if (!$commercial) {
            return response()->json([
                'success' => false,
                'message' => 'Commercial not found'
            ], 404);
        }

        if ($commercial->img_commercial && Storage::disk('public')->exists($commercial->img_commercial)) {
            Storage::disk('public')->delete($commercial->img_commercial);
        }
        if ($commercial->img_area && Storage::disk('public')->exists($commercial->img_area)) {
            Storage::disk('public')->delete($commercial->img_area);
        }

        $commercial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commercial deleted successfully'
        ]);
    }
}