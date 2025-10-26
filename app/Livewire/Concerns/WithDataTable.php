<?php

namespace App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

trait WithDataTable
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    protected array $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public string $paginationTheme = 'tailwind';

    public function initializeWithDataTable(): void
    {
        if (property_exists($this, 'defaultSortField')) {
            $this->sortField = $this->defaultSortField;
        }

        if (property_exists($this, 'defaultSortDirection')) {
            $this->sortDirection = $this->defaultSortDirection;
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * @return array<int, string>
     */
    protected function searchColumns(): array
    {
        return property_exists($this, 'searchable') ? (array) $this->searchable : [];
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    protected function applySearch(Builder $query): Builder
    {
        $columns = $this->searchColumns();

        if ($this->search === '' || $columns === []) {
            return $query;
        }

        $term = '%'.$this->search.'%';

        $query->where(function (Builder $builder) use ($columns, $term): void {
            foreach ($columns as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $field] = explode('.', $column, 2);

                    $builder->orWhereHas($relation, function (Builder $relationQuery) use ($field, $term): void {
                        $relationQuery->where($field, 'like', $term);
                    });
                } else {
                    $builder->orWhere($column, 'like', $term);
                }
            }
        });

        return $query;
    }

    protected function applySorting(Builder $query): Builder
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}