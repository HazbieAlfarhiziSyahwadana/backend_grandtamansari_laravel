<?php

namespace App\Livewire\Admin\ArticleTypes;

use App\Livewire\Concerns\WithDataTable;
use App\Models\ArticleType;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ArticleTypeIndex extends Component
{
    use WithDataTable;

    protected array $searchable = ['type'];

    protected string $defaultSortField = 'type';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $typeId): void
    {
        Gate::authorize('manage-content');

        $type = ArticleType::withCount('articles')->findOrFail($typeId);

        if ($type->articles_count > 0) {
            $this->dispatch('notify', message: 'Tidak dapat menghapus tipe yang masih dipakai artikel.', type: 'error');

            return;
        }

        $type->delete();

        $this->dispatch('notify', message: 'Tipe artikel berhasil dihapus.');
    }

    public function render()
    {
        $types = $this->applySorting(
            $this->applySearch(
                ArticleType::query()->withCount('articles')
            )
        )->paginate($this->perPage);

        return view('livewire.admin.article-types.article-type-index', [
            'types' => $types,
        ])->layout('layouts.admin');
    }
}