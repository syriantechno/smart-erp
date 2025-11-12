<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounting;

class AccountingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main Account Categories
        $accounts = [
            // Assets
            ['code' => '1000', 'name' => 'Assets', 'type' => 'asset', 'category' => 'current_asset', 'level' => 1],
            ['code' => '1100', 'name' => 'Current Assets', 'type' => 'asset', 'category' => 'current_asset', 'level' => 2, 'parent_id' => 1],
            ['code' => '1110', 'name' => 'Cash and Cash Equivalents', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_id' => 2],
            ['code' => '1111', 'name' => 'Cash on Hand', 'type' => 'asset', 'category' => 'current_asset', 'level' => 4, 'parent_id' => 3],
            ['code' => '1112', 'name' => 'Bank Accounts', 'type' => 'asset', 'category' => 'current_asset', 'level' => 4, 'parent_id' => 3],
            ['code' => '1120', 'name' => 'Accounts Receivable', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_id' => 2],
            ['code' => '1130', 'name' => 'Inventory', 'type' => 'asset', 'category' => 'current_asset', 'level' => 3, 'parent_id' => 2],

            ['code' => '1200', 'name' => 'Fixed Assets', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 2, 'parent_id' => 1],
            ['code' => '1210', 'name' => 'Property, Plant and Equipment', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 3, 'parent_id' => 8],
            ['code' => '1211', 'name' => 'Buildings', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_id' => 9],
            ['code' => '1212', 'name' => 'Equipment', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_id' => 9],
            ['code' => '1213', 'name' => 'Vehicles', 'type' => 'asset', 'category' => 'fixed_asset', 'level' => 4, 'parent_id' => 9],

            // Liabilities
            ['code' => '2000', 'name' => 'Liabilities', 'type' => 'liability', 'category' => 'current_liability', 'level' => 1],
            ['code' => '2100', 'name' => 'Current Liabilities', 'type' => 'liability', 'category' => 'current_liability', 'level' => 2, 'parent_id' => 13],
            ['code' => '2110', 'name' => 'Accounts Payable', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_id' => 14],
            ['code' => '2120', 'name' => 'Accrued Expenses', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_id' => 14],
            ['code' => '2130', 'name' => 'Short-term Loans', 'type' => 'liability', 'category' => 'current_liability', 'level' => 3, 'parent_id' => 14],

            ['code' => '2200', 'name' => 'Long-term Liabilities', 'type' => 'liability', 'category' => 'long_term_liability', 'level' => 2, 'parent_id' => 13],
            ['code' => '2210', 'name' => 'Long-term Loans', 'type' => 'liability', 'category' => 'long_term_liability', 'level' => 3, 'parent_id' => 18],

            // Equity
            ['code' => '3000', 'name' => 'Equity', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 1],
            ['code' => '3100', 'name' => 'Owner\'s Equity', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 2, 'parent_id' => 20],
            ['code' => '3110', 'name' => 'Capital', 'type' => 'equity', 'category' => 'owner_equity', 'level' => 3, 'parent_id' => 21],
            ['code' => '3200', 'name' => 'Retained Earnings', 'type' => 'equity', 'category' => 'retained_earnings', 'level' => 2, 'parent_id' => 20],

            // Income
            ['code' => '4000', 'name' => 'Income', 'type' => 'income', 'category' => 'operating_income', 'level' => 1],
            ['code' => '4100', 'name' => 'Operating Income', 'type' => 'income', 'category' => 'operating_income', 'level' => 2, 'parent_id' => 24],
            ['code' => '4110', 'name' => 'Sales Revenue', 'type' => 'income', 'category' => 'operating_income', 'level' => 3, 'parent_id' => 25],
            ['code' => '4120', 'name' => 'Service Revenue', 'type' => 'income', 'category' => 'operating_income', 'level' => 3, 'parent_id' => 25],
            ['code' => '4200', 'name' => 'Other Income', 'type' => 'income', 'category' => 'other_income', 'level' => 2, 'parent_id' => 24],

            // Expenses
            ['code' => '5000', 'name' => 'Expenses', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 1],
            ['code' => '5100', 'name' => 'Cost of Goods Sold', 'type' => 'expense', 'category' => 'cost_of_goods_sold', 'level' => 2, 'parent_id' => 29],
            ['code' => '5200', 'name' => 'Operating Expenses', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 2, 'parent_id' => 29],
            ['code' => '5210', 'name' => 'Salaries and Wages', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_id' => 31],
            ['code' => '5220', 'name' => 'Rent Expense', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_id' => 31],
            ['code' => '5230', 'name' => 'Utilities', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_id' => 31],
            ['code' => '5240', 'name' => 'Office Supplies', 'type' => 'expense', 'category' => 'operating_expense', 'level' => 3, 'parent_id' => 31],
            ['code' => '5300', 'name' => 'Other Expenses', 'type' => 'expense', 'category' => 'other_expense', 'level' => 2, 'parent_id' => 29],
        ];

        // First, create parent accounts with IDs 1-13
        $parentAccounts = array_slice($accounts, 0, 13);
        foreach ($parentAccounts as $account) {
            Accounting::create($account);
        }

        // Then create child accounts with correct parent_id references
        $childAccounts = array_slice($accounts, 13);
        foreach ($childAccounts as $account) {
            Accounting::create($account);
        }
    }
}
