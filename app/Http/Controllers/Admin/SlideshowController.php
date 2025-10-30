<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSlideshowRequest;
use App\Http\Requests\Admin\UpdateSlideshowRequest;
use App\Models\Slideshow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SlideshowController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.slideshows.form', [
            'slideshow' => new Slideshow(),
            'pageTitle' => 'Tambah Slideshow',
        ]);
    }

    public function store(StoreSlideshowRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        $data['sort'] = $data['sort'] ?? 0;
        $data['active'] = $request->has('active') ? 1 : 0; // Handle checkbox
        $data['gambar_desktop'] = $this->storeImage($request->file('gambar_desktop'));
        $data['gambar_mobile'] = $this->storeImage($request->file('gambar_mobile'));

        Slideshow::create($data);

        return redirect()->route('admin.slideshows.index')->with('status', 'Slideshow berhasil dibuat.');
    }

    public function edit(Slideshow $slideshow): View
    {
        Gate::authorize('manage-content');

        return view('admin.slideshows.form', [
            'slideshow' => $slideshow,
            'pageTitle' => 'Edit Slideshow',
        ]);
    }

    public function update(UpdateSlideshowRequest $request, Slideshow $slideshow): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        $data['sort'] = $data['sort'] ?? 0;
        $data['active'] = $request->has('active') ? 1 : 0; // Handle checkbox

        if ($request->hasFile('gambar_desktop')) {
            $data['gambar_desktop'] = $this->storeImage($request->file('gambar_desktop'), $slideshow->gambar_desktop);
        }

        if ($request->hasFile('gambar_mobile')) {
            $data['gambar_mobile'] = $this->storeImage($request->file('gambar_mobile'), $slideshow->gambar_mobile);
        }

        $slideshow->update($data);

        return redirect()->route('admin.slideshows.index')->with('status', 'Slideshow berhasil diperbarui.');
    }

    public function destroy(Slideshow $slideshow): RedirectResponse
    {
        Gate::authorize('manage-content');

        $this->deleteImage($slideshow->gambar_desktop);
        $this->deleteImage($slideshow->gambar_mobile);
        $slideshow->delete();

        return redirect()->route('admin.slideshows.index')->with('status', 'Slideshow berhasil dihapus.');
    }

    private function storeImage(?UploadedFile $file, ?string $currentPath = null): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $path = $file->store('slideshows', 'public');

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