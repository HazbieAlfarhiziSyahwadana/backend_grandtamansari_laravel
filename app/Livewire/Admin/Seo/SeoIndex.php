<?php

namespace App\Livewire\Admin\Seo;

use App\Livewire\Concerns\WithDataTable;
use App\Models\Seo;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SeoIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'page',
        'title',
        'keyword',
    ];

    protected string $defaultSortField = 'page';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $seoId): void
    {
        Gate::authorize('manage-content');

        $seo = Seo::findOrFail($seoId);
        $seo->delete();

        $this->dispatch('notify', message: 'Data SEO berhasil dihapus.');
    }

    public function render()
    {
        $records = $this->applySorting(
            $this->applySearch(Seo::query())
        )->paginate($this->perPage);

        return view('livewire.admin.seo.seo-index', [
            'records' => $records,
        ])->layout('layouts.admin');
    }
}
