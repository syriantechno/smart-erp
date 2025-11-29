<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PositionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Collection $positions)
    {
    }

    public function collection(): Collection
    {
        return $this->positions;
    }

    public function map($position): array
    {
        $salaryRange = '-';

        if (!is_null($position->salary_range_min) && !is_null($position->salary_range_max)) {
            $salaryRange = number_format($position->salary_range_min, 2) . ' - ' . number_format($position->salary_range_max, 2);
        }

        return [
            $position->code,
            $position->title,
            optional($position->department)->name ?: '-',
            $salaryRange,
            $position->is_active ? 'Active' : 'Inactive',
        ];
    }

    public function headings(): array
    {
        return ['Code', 'Title', 'Department', 'Salary Range', 'Status'];
    }
}
