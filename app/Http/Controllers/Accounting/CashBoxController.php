<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\CashBox;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashBoxController extends Controller
{
    public function index(): View
    {
        $companies = Company::orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $cashBoxes = CashBox::with(['company', 'account'])->orderBy('name')->get();

        return view('accounting.cash-boxes.index', compact('companies', 'accounts', 'cashBoxes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'account_id' => ['required', 'exists:accountings,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'currency' => ['nullable', 'string', 'max:3'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        CashBox::create($validated);

        return redirect()
            ->route('accounting.cash-boxes.index')
            ->with('success', 'Cash box created successfully.');
    }
}
