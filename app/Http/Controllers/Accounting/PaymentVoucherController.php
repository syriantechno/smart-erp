<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\CashBox;
use App\Models\Accounting\BankAccount;
use App\Models\Accounting\PaymentVoucher;
use App\Models\Accounting\Tax;
use App\Models\Company;
use App\Models\User;
use App\Services\Notifications\NotificationDispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

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

    public function store(Request $request)
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
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'الصندوق النقدي مطلوب للدفع النقدي'], 422);
                }
                return back()->withErrors(['cash_box_id' => 'Cash box is required for cash payments.'])->withInput();
            }
        } else {
            $data['cash_box_id'] = null;
            if (empty($data['bank_account_id'])) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'الحساب البنكي مطلوب للدفع البنكي'], 422);
                }
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

        $voucher = PaymentVoucher::create($data);

        // Notify accounting team
        $accountingTeam = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'accountant']))->pluck('id')->toArray();
        if (!empty($accountingTeam)) {
            $formattedTotal = function_exists('format_currency')
                ? format_currency($voucher->total_amount)
                : number_format($voucher->total_amount, 2);

            NotificationDispatcher::toUsers(
                $accountingTeam,
                'payment.created',
                'سند صرف جديد',
                "تم إنشاء سند صرف بمبلغ {$formattedTotal}",
                route('accounting.payment-vouchers.index'),
                'credit-card',
                ['type' => 'info', 'actor_id' => auth()->id()]
            );
        }

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء سند الصرف بنجاح',
                'voucher' => [
                    'id' => $voucher->id,
                    'number' => 'PV-' . str_pad($voucher->id, 5, '0', STR_PAD_LEFT),
                    'voucher_date' => $voucher->voucher_date->format('Y-m-d'),
                    'company_name' => $voucher->company->name ?? '-',
                    'method' => $voucher->method,
                    'account_name' => $voucher->account->name ?? '-',
                    'total_amount' => function_exists('format_currency')
                        ? format_currency($voucher->total_amount)
                        : number_format($voucher->total_amount, 2),
                    'status' => $voucher->status,
                ]
            ]);
        }

        return redirect()
            ->route('accounting.payment-vouchers.index')
            ->with('success', 'تم إنشاء سند الصرف بنجاح');
    }

    public function datatable(Request $request): JsonResponse
    {
        $query = PaymentVoucher::query()
            ->select([
                'payment_vouchers.id',
                'payment_vouchers.company_id',
                'payment_vouchers.account_id',
                'payment_vouchers.tax_id',
                'payment_vouchers.voucher_date',
                'payment_vouchers.method',
                'payment_vouchers.total_amount',
                'payment_vouchers.status',
            ])
            ->with([
                'company:id,name',
                'account:id,name',
            ]);

        // Simple search across number, company and account
        if ($request->filled('filter_value') && $request->filter_value !== '') {
            $value = $request->filter_value;
            $field = $request->input('filter_field', 'all');

            $query->where(function ($q) use ($value, $field) {
                if ($field === 'number') {
                    $q->where('payment_vouchers.id', 'LIKE', "%{$value}%");
                } elseif ($field === 'company') {
                    $q->whereHas('company', function ($sub) use ($value) {
                        $sub->where('name', 'LIKE', "%{$value}%");
                    });
                } elseif ($field === 'account') {
                    $q->whereHas('account', function ($sub) use ($value) {
                        $sub->where('name', 'LIKE', "%{$value}%");
                    });
                } else {
                    $q->where('payment_vouchers.id', 'LIKE', "%{$value}%")
                        ->orWhereHas('company', function ($sub) use ($value) {
                            $sub->where('name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('account', function ($sub) use ($value) {
                            $sub->where('name', 'LIKE', "%{$value}%");
                        });
                }
            });
        }

        if ($request->filled('filter_status') && $request->filter_status !== '') {
            $query->where('status', $request->filter_status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('number', function ($voucher) {
                return 'PV-' . str_pad($voucher->id, 5, '0', STR_PAD_LEFT);
            })
            ->addColumn('company_name', function ($voucher) {
                return $voucher->company->name ?? '-';
            })
            ->addColumn('method_label', function ($voucher) {
                if ($voucher->method === 'cash') {
                    return '<span class="inline-flex items-center gap-1 text-sm"><i data-lucide="wallet" class="w-4 h-4 text-emerald-600"></i><span>نقدي</span></span>';
                }

                return '<span class="inline-flex items-center gap-1 text-sm"><i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i><span>بنكي</span></span>';
            })
            ->addColumn('account_name', function ($voucher) {
                return $voucher->account->name ?? '-';
            })
            ->addColumn('amount_formatted', function ($voucher) {
                return number_format($voucher->total_amount, 2);
            })
            ->addColumn('status_badge', function ($voucher) {
                if ($voucher->status === 'posted') {
                    return '<span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold"><i data-lucide="check-circle" class="w-3 h-3"></i> مرحّل</span>';
                }

                if ($voucher->status === 'draft') {
                    return '<span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-600 rounded text-xs font-semibold"><i data-lucide="clock" class="w-3 h-3"></i> مسودة</span>';
                }

                return '<span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-semibold">' . e($voucher->status) . '</span>';
            })
            ->addColumn('actions', function ($voucher) {
                return view('accounting.payment-vouchers.partials.actions', [
                    'voucher' => $voucher,
                ])->render();
            })
            ->rawColumns(['method_label', 'status_badge', 'actions'])
            ->toJson();
    }

    public function destroy(Request $request, PaymentVoucher $paymentVoucher)
    {
        try {
            $paymentVoucher->delete();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'تم حذف السند بنجاح']);
            }
            
            return redirect()->route('accounting.payment-vouchers.index')->with('success', 'تم حذف السند بنجاح');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'فشل في حذف السند'], 500);
            }
            
            return back()->with('error', 'فشل في حذف السند');
        }
    }
}
