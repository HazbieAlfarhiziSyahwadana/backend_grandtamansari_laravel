<?php

namespace App\Livewire\Admin\Slideshows;

use App\Livewire\Concerns\WithDataTable;
use App\Models\Slideshow;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SlideshowIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'title',
        'link',
    ];

    protected string $defaultSortField = 'sort';

    protected string $defaultSortDirection = 'asc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $slideshowId): void
    {
        Gate::authorize('manage-content');

        $slideshow = Slideshow::findOrFail($slideshowId);

        $this->deleteImage($slideshow->gambar_desktop);
        $this->deleteImage($slideshow->gambar_mobile);

        $slideshow->delete();

        $this->dispatch('notify', message: 'Slideshow berhasil dihapus.');
    }

    public function render()
    {
        $slideshows = $this->applySorting(
            $this->applySearch(Slideshow::query())
        )->paginate($this->perPage);

        return view('livewire.admin.slideshows.slideshow-index', [
            'slideshows' => $slideshows,
        ])->layout('layouts.admin');
    }

    private function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
