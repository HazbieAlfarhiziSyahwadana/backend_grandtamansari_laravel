<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleTypeRequest;
use App\Models\ArticleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ArticleTypeController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        return view('admin.article-types.form', [
            'articleType' => new ArticleType(),
            'pageTitle' => 'Tambah Tipe Artikel',
        ]);
    }

    public function store(ArticleTypeRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        ArticleType::create($request->validated());

        return redirect()->route('admin.article-types.index')->with('status', 'Tipe artikel berhasil dibuat.');
    }

    public function edit(ArticleType $articleType): View
    {
        Gate::authorize('manage-content');

        return view('admin.article-types.form', [
            'articleType' => $articleType,
            'pageTitle' => 'Edit Tipe Artikel',
        ]);
    }

    public function update(ArticleTypeRequest $request, ArticleType $articleType): RedirectResponse
    {
        Gate::authorize('manage-content');

        $articleType->update($request->validated());

        return redirect()->route('admin.article-types.index')->with('status', 'Tipe artikel berhasil diperbarui.');
    }

    public function destroy(ArticleType $articleType): RedirectResponse
    {
        Gate::authorize('manage-content');

        if ($articleType->articles()->exists()) {
            return redirect()
                ->route('admin.article-types.index')
                ->with('status', 'Tidak dapat menghapus tipe yang masih dipakai artikel.');
        }

        $articleType->delete();

        return redirect()->route('admin.article-types.index')->with('status', 'Tipe artikel berhasil dihapus.');
    }
}