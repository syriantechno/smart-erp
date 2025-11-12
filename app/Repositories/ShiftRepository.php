<?php

namespace App\Repositories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ShiftRepository extends BaseRepository
{
    public function __construct(Shift $shift)
    {
        parent::__construct($shift);
    }

    /**
     * Get active shifts
     */
    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    /**
     * Get shifts for DataTables with relationships
     */
    public function getForDataTable(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->with(['company', 'department', 'employee'])
            ->select(['id', 'code', 'name', 'start_time', 'end_time', 'working_hours', 'color', 'is_active', 'applicable_to', 'company_id', 'department_id', 'employee_id', 'created_at']);
    }

    /**
     * Get shifts by company
     */
    public function getByCompany($companyId): Collection
    {
        return $this->model->forCompany($companyId)->get();
    }

    /**
     * Get shifts by department
     */
    public function getByDepartment($departmentId): Collection
    {
        return $this->model->forDepartment($departmentId)->get();
    }

    /**
     * Get shifts by employee
     */
    public function getByEmployee($employeeId): Collection
    {
        return $this->model->forEmployee($employeeId)->get();
    }

    /**
     * Create shift with code generation
     */
    public function createWithCode(array $attributes): Shift
    {
        return $this->model->create($attributes);
    }

    /**
     * Update shift status
     */
    public function toggleStatus($id): bool
    {
        $shift = $this->find($id);
        if (!$shift) {
            return false;
        }

        return $shift->update(['is_active' => !$shift->is_active]);
    }

    /**
     * Get departments for company (used in forms)
     */
    public function getDepartmentsForCompany($companyId): Collection
    {
        return \App\Models\Department::where('company_id', $companyId)
            ->active()
            ->select('id', 'name')
            ->get();
    }

    /**
     * Get employees for department (used in forms)
     */
    public function getEmployeesForDepartment($departmentId): Collection
    {
        return \App\Models\Employee::where('department_id', $departmentId)
            ->active()
            ->select('id', 'first_name', 'last_name', 'full_name')
            ->get();
    }

    /**
     * Search shifts with filters
     */
    public function search(array $filters = [], $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        // Apply filters
        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['code']) && !empty($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['applicable_to']) && !empty($filters['applicable_to'])) {
            $query->where('applicable_to', $filters['applicable_to']);
        }

        return $query->paginate($perPage);
    }
}
