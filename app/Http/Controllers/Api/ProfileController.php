<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        
        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function update(Request $request, $id = null)
    {
        $profile = $id ? Profile::find($id) : Profile::first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'company' => 'required|string|max:225',
            'description' => 'required|string',
            'address' => 'required|string|max:225',
            'telp' => 'required|string|max:225',
            'whatsapp' => 'required|string|max:225',
            'email' => 'nullable|email|max:225',
            'instagram' => 'required|string|max:255',
            'facebook' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $data['logo'] = $request->file('logo')->store('profile', 'public');
        }

        $profile->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $profile
        ]);
    }
}