<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCommercialRequest;
use App\Http\Requests\Admin\UpdateCommercialRequest;
use App\Models\Commercial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommercialController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.commercials.form', [
            'commercial' => new Commercial(),
            'pageTitle' => 'Tambah Commercial',
        ]);
    }

    public function store(StoreCommercialRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name']);
        $data['img_commercial'] = $this->storeImage($request->file('img_commercial'));
        $data['img_area'] = $this->storeImage($request->file('img_area'));

        Commercial::create($data);

        return redirect()->route('admin.commercials.index')->with('status', 'Data commercial berhasil dibuat.');
    }

    public function edit(Commercial $commercial): View
    {
        Gate::authorize('manage-content');

        return view('admin.commercials.form', [
            'commercial' => $commercial,
            'pageTitle' => 'Edit Commercial',
        ]);
    }

    public function update(UpdateCommercialRequest $request, Commercial $commercial): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name'], $commercial->id);

        if ($request->hasFile('img_commercial')) {
            $data['img_commercial'] = $this->storeImage($request->file('img_commercial'), $commercial->img_commercial);
        }

        if ($request->hasFile('img_area')) {
            $data['img_area'] = $this->storeImage($request->file('img_area'), $commercial->img_area);
        }

        $commercial->update($data);

        return redirect()->route('admin.commercials.index')->with('status', 'Data commercial berhasil diperbarui.');
    }

    public function destroy(Commercial $commercial): RedirectResponse
    {
        Gate::authorize('manage-content');

        $this->deleteImage($commercial->img_commercial);
        $this->deleteImage($commercial->img_area);

        $commercial->delete();

        return redirect()->route('admin.commercials.index')->with('status', 'Data commercial berhasil dihapus.');
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
            Commercial::where('slug', $candidate)
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

        $path = $file->store('commercials', 'public');

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