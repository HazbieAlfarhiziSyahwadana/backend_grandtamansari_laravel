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
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name']);
        $data['img_facade'] = $this->storeImage($request->file('img_facade'));
        $data['img_layout'] = $this->storeImage($request->file('img_layout'));

        UnitType::create($data);

        return redirect()->route('admin.unit-types.index')->with('status', 'Unit type berhasil dibuat.');
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
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name'], $unitType->id);

        if ($request->hasFile('img_facade')) {
            $data['img_facade'] = $this->storeImage($request->file('img_facade'), $unitType->img_facade);
        }

        if ($request->hasFile('img_layout')) {
            $data['img_layout'] = $this->storeImage($request->file('img_layout'), $unitType->img_layout);
        }

        $unitType->update($data);

        return redirect()->route('admin.unit-types.index')->with('status', 'Unit type berhasil diperbarui.');
    }

    public function destroy(UnitType $unitType): RedirectResponse
    {
        Gate::authorize('manage-content');

        $this->deleteImage($unitType->img_facade);
        $this->deleteImage($unitType->img_layout);

        $unitType->delete();

        return redirect()->route('admin.unit-types.index')->with('status', 'Unit type berhasil dihapus.');
    }

    private function resolveSlug(?string $slug, string $fallback, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $fallback);

        if ($base === '') {
            $base = Str::random(8);
        }

        $candidate = $base;
        $suffix = 1;

        while (
            UnitType::where('slug', $candidate)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = $base.'-'.$suffix++;
        }

        return $candidate;
    }

    private function storeImage(?UploadedFile $file, ?string $currentPath = null): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $path = $file->store('unit-types', 'public');

        $this->deleteImage($currentPath);

        return $path;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}