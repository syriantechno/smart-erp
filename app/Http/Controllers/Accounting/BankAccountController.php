<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\BankAccount;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BankAccountController extends Controller
{
    public function index(): View
    {
        $companies = Company::orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $bankAccounts = BankAccount::with(['company', 'account'])->orderBy('name')->get();

        return view('accounting.bank-accounts.index', compact('companies', 'accounts', 'bankAccounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'account_id' => ['required', 'exists:accountings,id'],
            'name' => ['required', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'iban' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'max:3'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        BankAccount::create($validated);

        return redirect()
            ->route('accounting.bank-accounts.index')
            ->with('success', 'Bank account created successfully.');
    }
}
