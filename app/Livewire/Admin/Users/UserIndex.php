<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Concerns\WithDataTable;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UserIndex extends Component
{
    use WithDataTable;

    protected array $searchable = [
        'name',
        'username',
        'email',
    ];

    protected string $defaultSortField = 'created_at';

    protected string $defaultSortDirection = 'desc';

    public function mount(): void
    {
        Gate::authorize('manage-users');
    }

    public function delete(int $userId): void
    {
        Gate::authorize('manage-users');

        $user = User::findOrFail($userId);

        if (auth()->id() === $user->id) {
            $this->dispatch('notify', message: 'Tidak dapat menghapus akun yang sedang digunakan.', type: 'error');

            return;
        }

        $user->delete();

        $this->dispatch('notify', message: 'Pengguna berhasil dihapus.');
    }

    public function render()
    {
        $users = $this->applySorting(
            $this->applySearch(User::query())
        )->paginate($this->perPage);

        return view('livewire.admin.users.user-index', [
            'users' => $users,
        ])->layout('layouts.admin');
    }
}
