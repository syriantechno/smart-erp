<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\CashBox;
use App\Models\Accounting\BankAccount;
use App\Models\Accounting\PaymentVoucher;
use App\Models\Accounting\Tax;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentVoucherController extends Controller
{
    public function index(): View
    {
        $companies = Company::orderBy('name')->get();
        $cashBoxes = CashBox::with('company')->orderBy('name')->get();
        $bankAccounts = BankAccount::with('company')->orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $taxes = Tax::where('is_active', true)->orderBy('name')->get();
        $vouchers = PaymentVoucher::with(['company', 'cashBox', 'bankAccount', 'account', 'tax'])
            ->orderByDesc('voucher_date')
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        return view('accounting.payment-vouchers.index', compact(
            'companies',
            'cashBoxes',
            'bankAccounts',
            'accounts',
            'taxes',
            'vouchers'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'method' => ['required', 'in:cash,bank'],
            'cash_box_id' => ['nullable', 'exists:cash_boxes,id'],
            'bank_account_id' => ['nullable', 'exists:bank_accounts,id'],
            'account_id' => ['required', 'exists:accountings,id'],
            'tax_id' => ['nullable', 'exists:taxes,id'],
            'voucher_date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        if ($data['method'] === 'cash') {
            $data['bank_account_id'] = null;
            if (empty($data['cash_box_id'])) {
                return back()->withErrors(['cash_box_id' => 'Cash box is required for cash payments.'])->withInput();
            }
        } else {
            $data['cash_box_id'] = null;
            if (empty($data['bank_account_id'])) {
                return back()->withErrors(['bank_account_id' => 'Bank account is required for bank payments.'])->withInput();
            }
        }

        $amount = (float)$data['amount'];
        $taxAmount = 0;

        if (!empty($data['tax_id'])) {
            $tax = Tax::find($data['tax_id']);
            if ($tax) {
                $taxAmount = round($amount * ((float)$tax->rate / 100), 2);
            }
        }

        $data['tax_amount'] = $taxAmount;
        $data['total_amount'] = $amount + $taxAmount;
        $data['status'] = 'draft';

        PaymentVoucher::create($data);

        return redirect()
            ->route('accounting.payment-vouchers.index')
            ->with('success', 'Payment voucher created successfully.');
    }
}
