<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUnitTypeRequest;
use App\Http\Requests\Admin\UpdateUnitTypeRequest;
use App\Models\UnitType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UnitTypeController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.unit-types.form', [
            'unitType' => new UnitType(),
            'pageTitle' => 'Tambah Unit Type',
        ]);
    }

    public function store(StoreUnitTypeRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        
        // Handle checkbox active
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['gallery_active'] = $request->has('gallery_active') ? 1 : 0;
        
        // Set default sort jika tidak ada
        $data['sort'] = $data['sort'] ?? 0;
        
        // Generate slug jika kosong
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Handle image uploads
        if ($request->hasFile('img_facade')) {
            $data['img_facade'] = $this->storeImage($request->file('img_facade'), 'unit-types/facade');
        }
        
        // BARU: Handle facade mobile image
        if ($request->hasFile('img_facade_mobile')) {
            $data['img_facade_mobile'] = $this->storeImage($request->file('img_facade_mobile'), 'unit-types/facade');
        }
        
        if ($request->hasFile('img_layout')) {
            $data['img_layout'] = $this->storeImage($request->file('img_layout'), 'unit-types/layout');
        }

        // Handle gallery desktop image upload
        if ($request->hasFile('img_gallery')) {
            $data['img_gallery'] = $this->storeImage($request->file('img_gallery'), 'unit-types/gallery');
        }

        // BARU: Handle gallery mobile image upload
        if ($request->hasFile('img_gallery_mobile')) {
            $data['img_gallery_mobile'] = $this->storeImage($request->file('img_gallery_mobile'), 'unit-types/gallery');
        }

        UnitType::create($data);

        return redirect()->route('admin.unit-types.index')
            ->with('status', 'Unit type berhasil dibuat.');
    }

    public function edit(UnitType $unitType): View
    {
        Gate::authorize('manage-content');

        return view('admin.unit-types.form', [
            'unitType' => $unitType,
            'pageTitle' => 'Edit Unit Type',
        ]);
    }

    public function update(UpdateUnitTypeRequest $request, UnitType $unitType): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        
        // Handle checkbox active
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['gallery_active'] = $request->has('gallery_active') ? 1 : 0;
        
        // Generate slug jika kosong
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        // Handle facade desktop image upload
        if ($request->hasFile('img_facade')) {
            $data['img_facade'] = $this->storeImage(
                $request->file('img_facade'), 
                'unit-types/facade',
                $unitType->img_facade
            );
        }
        
        // BARU: Handle facade mobile image upload
        if ($request->hasFile('img_facade_mobile')) {
            $data['img_facade_mobile'] = $this->storeImage(
                $request->file('img_facade_mobile'), 
                'unit-types/facade',
                $unitType->img_facade_mobile
            );
        }
        
        if ($request->hasFile('img_layout')) {
            $data['img_layout'] = $this->storeImage(
                $request->file('img_layout'), 
                'unit-types/layout',
                $unitType->img_layout
            );
        }

        // Handle gallery desktop image upload
        if ($request->hasFile('img_gallery')) {
            $data['img_gallery'] = $this->storeImage(
                $request->file('img_gallery'), 
                'unit-types/gallery',
                $unitType->img_gallery
            );
        }

        // BARU: Handle gallery mobile image upload
        if ($request->hasFile('img_gallery_mobile')) {
            $data['img_gallery_mobile'] = $this->storeImage(
                $request->file('img_gallery_mobile'), 
                'unit-types/gallery',
                $unitType->img_gallery_mobile
            );
        }

        $unitType->update($data);

        return redirect()->route('admin.unit-types.index')
            ->with('status', 'Unit type berhasil diperbarui.');
    }

    public function destroy(UnitType $unitType): RedirectResponse
    {
        Gate::authorize('manage-content');

        // Delete images
        $this->deleteImage($unitType->img_facade);
        $this->deleteImage($unitType->img_facade_mobile); // BARU
        $this->deleteImage($unitType->img_layout);
        $this->deleteImage($unitType->img_gallery);
        $this->deleteImage($unitType->img_gallery_mobile); // BARU
        
        $unitType->delete();

        return redirect()->route('admin.unit-types.index')
            ->with('status', 'Unit type berhasil dihapus.');
    }

    /**
     * Store uploaded image
     */
    private function storeImage(?UploadedFile $file, string $folder, ?string $currentPath = null): ?string
    {
        if (!$file) {
            return $currentPath;
        }

        $path = $file->store($folder, 'public');

        // Delete old image if exists
        $this->deleteImage($currentPath);

        return $path;
    }

    /**
     * Delete image from storage
     */
    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}