<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Collection $customers)
    {
    }

    public function collection(): Collection
    {
        return $this->customers;
    }

    public function map($customer): array
    {
        return [
            $customer->code,
            $customer->name,
            $customer->customer_type,
            $customer->email,
            $customer->phone,
            $customer->credit_limit ?? 0,
            $customer->status,
        ];
    }

    public function headings(): array
    {
        return ['Code', 'Name', 'Type', 'Email', 'Phone', 'Credit Limit', 'Status'];
    }
}
