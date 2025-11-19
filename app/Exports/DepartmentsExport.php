<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Collection $departments)
    {
    }

    public function collection(): Collection
    {
        return $this->departments;
    }

    public function map($department): array
    {
        return [
            $department->code,
            $department->name,
            optional($department->company)->name ?: '-',
            optional($department->manager)->full_name ?: '-',
            $department->employees_count ?? 0,
            $department->is_active ? 'Active' : 'Inactive',
        ];
    }

    public function headings(): array
    {
        return ['Code', 'Name', 'Company', 'Manager', 'Employees', 'Status'];
    }
}
