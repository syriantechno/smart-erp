<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Employee::with(['department', 'company'])->get();
    }

    /**
     * Map the data that should be added as rows
     *
     * @param mixed $employee
     * @return array
     */
    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->employee_id,
            $employee->full_name,
            $employee->email,
            $employee->phone,
            $employee->position,
            $employee->department ? $employee->department->name : '-',
            $employee->company ? $employee->company->name : '-',
            $employee->hire_date->format('Y-m-d'),
            $employee->is_active ? 'Active' : 'Inactive',
            $employee->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Add headers to the Excel file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Employee ID',
            'Full Name',
            'Email',
            'Phone',
            'Position',
            'Department',
            'Company',
            'Hire Date',
            'Status',
            'Created At'
        ];
    }

    /**
     * Style the Excel sheet
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Styling a specific cell by coordinate
            'A1:K1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F5F5F5']]],
            
            // Styling an entire column
            'A'  => ['alignment' => ['horizontal' => 'center']],
            'J'  => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}
