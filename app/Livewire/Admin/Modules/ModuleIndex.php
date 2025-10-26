<?php

namespace App\Livewire\Admin\Modules;

use App\Livewire\Concerns\WithDataTable;
use App\Models\Modul;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ModuleIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'modul_link',
    ];

    protected string $defaultSortField = 'priority';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $moduleId): void
    {
        Gate::authorize('manage-content');

        $module = Modul::findOrFail($moduleId);
        $module->delete();

        $this->dispatch('notify', message: 'Module link berhasil dihapus.');
    }

    public function render()
    {
        $modules = $this->applySorting(
            $this->applySearch(Modul::query())
        )->paginate($this->perPage);

        return view('livewire.admin.modules.module-index', [
            'modules' => $modules,
        ])->layout('layouts.admin');
    }
}
