<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSeoRequest;
use App\Http\Requests\Admin\UpdateSeoRequest;
use App\Models\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.seo.form', [
            'seo' => new Seo(),
            'pageTitle' => 'Tambah SEO',
            'pages' => SeoPage::cases(),
        ]);
    }

    public function store(StoreSeoRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        Seo::create($request->validated());

        return redirect()->route('admin.seo.index')->with('status', 'Data SEO berhasil dibuat.');
    }

    public function edit(Seo $seo): View
    {
        Gate::authorize('manage-content');

        return view('admin.seo.form', [
            'seo' => $seo,
            'pageTitle' => 'Edit SEO',
            'pages' => SeoPage::cases(),
        ]);
    }

    public function update(UpdateSeoRequest $request, Seo $seo): RedirectResponse
    {
        Gate::authorize('manage-content');

        $seo->update($request->validated());

        return redirect()->route('admin.seo.index')->with('status', 'Data SEO berhasil diperbarui.');
    }

    public function destroy(Seo $seo): RedirectResponse
    {
        Gate::authorize('manage-content');

        $seo->delete();

        return redirect()->route('admin.seo.index')->with('status', 'Data SEO berhasil dihapus.');
    }
}
