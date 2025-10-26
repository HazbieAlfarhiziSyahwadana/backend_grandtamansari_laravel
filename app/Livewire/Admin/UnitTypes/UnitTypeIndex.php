<?php

namespace App\Livewire\Admin\UnitTypes;

use App\Livewire\Concerns\WithDataTable;
use App\Models\UnitType;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UnitTypeIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'name',
        'slug',
        'width',
        'price',
        'promo_price',
    ];

    protected string $defaultSortField = 'name';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $unitTypeId): void
    {
        Gate::authorize('manage-content');

        $unitType = UnitType::findOrFail($unitTypeId);
        $unitType->delete();

        $this->dispatch('notify', message: 'Unit type berhasil dihapus.');
    }

    public function render()
    {
        $unitTypes = $this->applySorting(
            $this->applySearch(UnitType::query())
        )->paginate($this->perPage);

        return view('livewire.admin.unit-types.unit-type-index', [
            'unitTypes' => $unitTypes,
        ])->layout('layouts.admin');
    }
}