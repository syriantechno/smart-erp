<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounting\Accounting;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Account Categories with parent_code to build proper hierarchy
        $accounts = [
            // Assets
            ['code' => '1000', 'name' => 'Assets', 'type' => 'asset', 'category' => 'current_asset', 'level' => 1, 'parent_code' => null],
            ['code' => '1100', 'name' => 'Current Assets', 'type' => 'asset', 'category' => 'current_asset', 'level' => 2, 'parent_code' => '1000'],
            ['code' => '1110', 'name' => 'Cash and Cash Equivalents', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_code' => '1100'],
            ['code' => '1111', 'name' => 'Cash on Hand', 'type' => 'asset', 'category' => 'current_asset', 'level' => 4, 'parent_code' => '1110'],
            ['code' => '1112', 'name' => 'Bank Accounts', 'type' => 'asset', 'category' => 'current_asset', 'level' => 4, 'parent_code' => '1110'],
            ['code' => '1120', 'name' => 'Accounts Receivable', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_code' => '1100'],
            ['code' => '1130', 'name' => 'Inventory', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_code' => '1100'],

            ['code' => '1200', 'name' => 'Fixed Assets', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 2, 'parent_code' => '1000'],
            ['code' => '1210', 'name' => 'Property, Plant and Equipment', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 3, 'parent_code' => '1200'],
            ['code' => '1211', 'name' => 'Buildings', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_code' => '1210'],
            ['code' => '1212', 'name' => 'Equipment', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_code' => '1210'],
            ['code' => '1213', 'name' => 'Vehicles', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_code' => '1210'],

            // Liabilities
            ['code' => '2000', 'name' => 'Liabilities', 'type' => 'liability', 'category' => 'current_liability', 'level' => 1, 'parent_code' => null],
            ['code' => '2100', 'name' => 'Current Liabilities', 'type' => 'liability', 'category' => 'current_liability', 'level' => 2, 'parent_code' => '2000'],
            ['code' => '2110', 'name' => 'Accounts Payable', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_code' => '2100'],
            ['code' => '2120', 'name' => 'Accrued Expenses', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_code' => '2100'],
            ['code' => '2130', 'name' => 'Short-term Loans', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_code' => '2100'],

            ['code' => '2200', 'name' => 'Long-term Liabilities', 'type' => 'liability', 'category' => 'long_term_liability', 'level' => 2, 'parent_code' => '2000'],
            ['code' => '2210', 'name' => 'Long-term Loans', 'type' => 'liability', 'category' => 'long_term_liability', 'level' => 3, 'parent_code' => '2200'],

            // Equity
            ['code' => '3000', 'name' => 'Equity', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 1, 'parent_code' => null],
            ['code' => '3100', 'name' => 'Owner\'s Equity', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 2, 'parent_code' => '3000'],
            ['code' => '3110', 'name' => 'Capital', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 3, 'parent_code' => '3100'],
            ['code' => '3200', 'name' => 'Retained Earnings', 'type' => 'equity', 'category' => 'retained_earnings', 'level' => 2, 'parent_code' => '3000'],

            // Income
            ['code' => '4000', 'name' => 'Income', 'type' => 'income', 'category' => 'operating_income', 'level' => 1, 'parent_code' => null],
            ['code' => '4100', 'name' => 'Operating Income', 'type' => 'income', 'category' => 'operating_income', 'level' => 2, 'parent_code' => '4000'],
            ['code' => '4110', 'name' => 'Sales Revenue', 'type' => 'income', 'category' => 'operating_income', 'level' => 3, 'parent_code' => '4100'],
            ['code' => '4120', 'name' => 'Service Revenue', 'type' => 'income', 'category' => 'operating_income', 'level' => 3, 'parent_code' => '4100'],
            ['code' => '4200', 'name' => 'Other Income', 'type' => 'income', 'category' => 'other_income', 'level' => 2, 'parent_code' => '4000'],

            // Expenses
            ['code' => '5000', 'name' => 'Expenses', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 1, 'parent_code' => null],
            ['code' => '5100', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'category' => 'cost_of_goods_sold', 'level' => 2, 'parent_code' => '5000'],
            ['code' => '5200', 'name' => 'Operating Expenses', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 2, 'parent_code' => '5000'],
            ['code' => '5210', 'name' => 'Salaries and Wages', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_code' => '5200'],
            ['code' => '5220', 'name' => 'Rent Expense', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_code' => '5200'],
            ['code' => '5230', 'name' => 'Utilities', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_code' => '5200'],
            ['code' => '5240', 'name' => 'Office Supplies', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_code' => '5200'],
            ['code' => '5300', 'name' => 'Other Expenses', 'type' => 'expense', 'category' => 'other_expense', 'level' => 2, 'parent_code' => '5000'],
        ];

        // Optional: clear existing accounts if you want a clean base
        // Accounting::truncate();

        $created = [];

        foreach ($accounts as $data) {
            $parentCode = $data['parent_code'];
            unset($data['parent_code']);

            if ($parentCode && isset($created[$parentCode])) {
                $data['parent_id'] = $created[$parentCode]->id;
            }

            $account = Accounting::create($data);
            $created[$data['code']] = $account;
        }
    }
}
