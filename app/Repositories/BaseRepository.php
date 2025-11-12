<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find record by ID
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Find record by ID or fail
     */
    public function findOrFail($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create new record
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update record
     */
    public function update($id, array $attributes): bool
    {
        $record = $this->find($id);
        return $record ? $record->update($attributes) : false;
    }

    /**
     * Delete record
     */
    public function delete($id): bool
    {
        $record = $this->find($id);
        return $record ? $record->delete() : false;
    }

    /**
     * Paginate records
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * Get records with conditions
     */
    public function where(array $conditions): Collection
    {
        $query = $this->model->query();

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $value);
            }
        }

        return $query->get();
    }

    /**
     * Get first record with conditions
     */
    public function firstWhere(array $conditions): ?Model
    {
        $query = $this->model->query();

        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }

        return $query->first();
    }

    /**
     * Count records
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if record exists
     */
    public function exists($id): bool
    {
        return $this->model->where('id', $id)->exists();
    }
}
