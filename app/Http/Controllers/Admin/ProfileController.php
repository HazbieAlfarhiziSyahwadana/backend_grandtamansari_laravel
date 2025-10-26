<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        Gate::authorize('manage-content');

        $profile = Profile::first() ?? new Profile();

        return view('admin.profile.form', [
            'profile' => $profile,
            'pageTitle' => 'Profil Perusahaan',
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        $profile = Profile::first() ?? new Profile();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLogo($request->file('logo'), $profile->logo);
        } else {
            unset($data['logo']);
        }

        $profile->fill($data);
        $profile->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profil berhasil diperbarui.');
    }

    private function storeLogo(?UploadedFile $file, ?string $currentPath = null): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $path = $file->store('profile', 'public');

        $this->deleteAsset($currentPath);

        return $path;
    }

    private function deleteAsset(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
