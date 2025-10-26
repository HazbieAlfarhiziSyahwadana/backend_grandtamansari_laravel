<?php

namespace App\Livewire\Admin\Articles;

use App\Livewire\Concerns\WithDataTable;
use App\Models\Article;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ArticleIndex extends Component
{
    use AuthorizesRequests;
    use WithDataTable;

    protected array $searchable = [
        'title',
        'slug',
        'caption',
        'keyword',
        'type.type',
    ];

    protected string $defaultSortField = 'created_at';

    protected string $defaultSortDirection = 'desc';

    public function mount(): void
    {
        Gate::authorize('manage-content');
    }

    public function delete(int $articleId): void
    {
        Gate::authorize('manage-content');

        $article = Article::findOrFail($articleId);
        $article->delete();

        $this->dispatch('notify', message: 'Artikel berhasil dihapus.');
    }

    public function render()
    {
        $query = Article::query()
            ->with('type');

        $articles = $this->applySorting(
            $this->applySearch($query)
        )->paginate($this->perPage);

        return view('livewire.admin.articles.article-index', [
            'articles' => $articles,
        ])->layout('layouts.admin');
    }
}