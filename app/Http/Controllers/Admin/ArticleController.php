<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function create(): View
    {
        Gate::authorize('manage-content');

        $types = ArticleType::orderBy('type')->pluck('type', 'id');

        return view('admin.articles.form', [
            'article' => new Article(),
            'types' => $types,
            'pageTitle' => 'Tambah Artikel',
        ]);
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        
        // Handle checkbox active
        $data['active'] = $request->has('active') ? 1 : 0;
        
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title']);
        $data['gambar'] = $this->storeImage($request->file('gambar'));

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): View
    {
        Gate::authorize('manage-content');

        $types = ArticleType::orderBy('type')->pluck('type', 'id');

        return view('admin.articles.form', [
            'article' => $article,
            'types' => $types,
            'pageTitle' => 'Edit Artikel',
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        Gate::authorize('manage-content');

        $data = $request->validated();
        
        // Handle checkbox active
        $data['active'] = $request->has('active') ? 1 : 0;
        
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['title'], $article->id);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->storeImage($request->file('gambar'), $article->gambar);
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        Gate::authorize('manage-content');
        
        $this->deleteImage($article->gambar);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    private function resolveSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $title);

        if ($base === '') {
            $base = Str::random(8);
        }

        $candidate = $base;
        $suffix = 1;

        while (
            Article::where('slug', $candidate)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = $base.'-'.$suffix++;
        }

        return $candidate;
    }

    private function storeImage(?UploadedFile $file, ?string $currentPath = null): ?string
    {
        if (!$file) {
            return $currentPath;
        }

        $path = $file->store('articles', 'public');

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