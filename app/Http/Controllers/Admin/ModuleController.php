<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreModuleRequest;
use App\Http\Requests\Admin\UpdateModuleRequest;
use App\Models\Modul;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.modules.form', [
            'module' => new Modul(),
            'pageTitle' => 'Tambah Module Link',
        ]);
    }

    public function store(StoreModuleRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        Modul::create($request->validated());

        return redirect()->route('admin.modules.index')->with('status', 'Module link berhasil dibuat.');
    }

    public function edit(Modul $module): View
    {
        Gate::authorize('manage-content');

        return view('admin.modules.form', [
            'module' => $module,
            'pageTitle' => 'Edit Module Link',
        ]);
    }

    public function update(UpdateModuleRequest $request, Modul $module): RedirectResponse
    {
        Gate::authorize('manage-content');

        $module->update($request->validated());

        return redirect()->route('admin.modules.index')->with('status', 'Module link berhasil diperbarui.');
    }

    public function destroy(Modul $module): RedirectResponse
    {
        Gate::authorize('manage-content');

        $module->delete();

        return redirect()->route('admin.modules.index')->with('status', 'Module link berhasil dihapus.');
    }
}
