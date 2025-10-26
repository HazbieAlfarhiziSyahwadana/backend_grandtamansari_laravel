<?php

namespace App\Livewire\Admin\Commercials;

use App\Livewire\Concerns\WithDataTable;
use App\Models\Commercial;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CommercialIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'name',
        'slug',
        'hargamulai',
        'width',
    ];

    protected string $defaultSortField = 'name';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $commercialId): void
    {
        Gate::authorize('manage-content');

        $commercial = Commercial::findOrFail($commercialId);
        $commercial->delete();

        $this->dispatch('notify', message: 'Data komersial berhasil dihapus.');
    }

    public function render()
    {
        $commercials = $this->applySorting(
            $this->applySearch(Commercial::query())
        )->paginate($this->perPage);

        return view('livewire.admin.commercials.commercial-index', [
            'commercials' => $commercials,
        ])->layout('layouts.admin');
    }
}