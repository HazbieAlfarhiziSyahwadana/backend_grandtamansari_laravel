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
use Illuminate\Http\Request;

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

    // Menambahkan fungsi index untuk pencarian
    public function index(Request $request): View
    {
        Gate::authorize('manage-content');

        // Menyiapkan query untuk SEO dengan pencarian
        $query = Seo::query();

        // Pencarian berdasarkan halaman, judul, dan keyword
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('page', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('keyword', 'like', "%{$search}%");
            });
        }

        // Ambil data SEO yang sudah difilter dan diurutkan
        $seoRecords = $query->latest()->paginate($request->per_page ?? 10);

        // Mengirimkan data ke view
        return view('admin.seo.index', [
            'records' => $seoRecords,
            'search' => $request->search,  // Membawa query search ke view
        ]);
    }
}
