<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoiceLine;
use App\Models\Accounting\Tax;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use App\Models\Warehouse\Material;
use App\Models\Approval\ApprovalTemplate;
use App\Services\DocumentCodeGenerator;
use App\Services\Notifications\NotificationDispatcher;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function __construct(private DocumentCodeGenerator $codeGenerator)
    {
    }

    public function index(): \Illuminate\View\View
    {
        // Get statistics for the royal theme header
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();

        // Get companies with their logo URLs
        $companies = Company::orderBy('name')->get()->map(function($company) {
            $company->logo_url = $company->logo ? 
                asset('storage/' . $company->logo) : 
                'https://ui-avatars.com/api/?name=' . urlencode($company->name) . '&background=1D4ED8&color=ffffff';
            return $company;
        });
        $customers = Customer::orderBy('name')->get();
        $taxes = Tax::where('is_active', true)->orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $invoices = Invoice::with(['customer', 'tax'])
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        // Define payment terms options
        $paymentTerms = [
            (object)['id' => 'immediate', 'name' => 'Immediate Payment'],
            (object)['id' => 'net_7', 'name' => 'Net 7 Days'],
            (object)['id' => 'net_15', 'name' => 'Net 15 Days'],
            (object)['id' => 'net_30', 'name' => 'Net 30 Days'],
            (object)['id' => 'net_45', 'name' => 'Net 45 Days'],
            (object)['id' => 'net_60', 'name' => 'Net 60 Days'],
            (object)['id' => 'due_on_receipt', 'name' => 'Due on Receipt'],
            (object)['id' => 'custom', 'name' => 'Custom Terms'],
        ];

        // Get active materials for items dropdown
        $materials = Material::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price']);

        // Get approval templates for invoice workflow
        $approvalTemplates = ApprovalTemplate::where('type', 'invoice')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Pre-generate next invoice number for the modal using prefix settings
        try {
            $nextInvoiceNumber = $this->codeGenerator->preview('invoices');
        } catch (Throwable $e) {
            $nextInvoiceNumber = $this->fallbackInvoiceNumber();
        }

        return view('accounting.invoices.index', compact(
            'companies', 
            'customers', 
            'taxes', 
            'accounts', 
            'invoices', 
            'totalInvoices', 
            'paidInvoices', 
            'pendingInvoices', 
            'overdueInvoices',
            'paymentTerms',
            'materials',
            'approvalTemplates',
            'nextInvoiceNumber'
        ));
    }

    protected function generateInvoiceNumber(): string
    {
        $attempts = 0;
        $maxAttempts = 100;

        do {
            if ($attempts >= $maxAttempts) {
                return 'INV-' . date('Ymd') . '-' . time();
            }

            $number = 'INV-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $attempts++;
        } while (Invoice::where('number', $number)->exists());

        return $number;
    }

    protected function fallbackInvoiceNumber(): string
    {
        return $this->generateInvoiceNumber();
    }

    public function previewCode(): JsonResponse
    {
        try {
            $code = $this->codeGenerator->preview('invoices');
            return response()->json([
                'success' => true,
                'code' => $code,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => true,
                'code' => $this->fallbackInvoiceNumber(),
            ]);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'type' => ['required', 'in:sales,purchase'],
            'tax_id' => ['nullable', 'exists:taxes,id'],
            'approval_template_id' => ['nullable', 'exists:approval_templates,id'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:invoice_date'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.account_id' => ['required', 'exists:accountings,id'],
            'lines.*.description' => ['nullable', 'string', 'max:255'],
            'lines.*.quantity' => ['required', 'numeric', 'min:0'],
            'lines.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $lines = $data['lines'];
        unset($data['lines']);

        $subtotal = 0;
        foreach ($lines as &$line) {
            $lineTotal = (float)$line['quantity'] * (float)$line['unit_price'];
            $line['line_total'] = $lineTotal;
            $subtotal += $lineTotal;
        }
        unset($line);

        $taxAmount = 0;
        if (!empty($data['tax_id'])) {
            $tax = Tax::find($data['tax_id']);
            if ($tax) {
                $taxAmount = round($subtotal * ((float)$tax->rate / 100), 2);
            }
        }

        $total = $subtotal + $taxAmount;

        $invoice = new Invoice();
        $invoice->fill($data);
        try {
            $invoice->number = $this->codeGenerator->generate('invoices');
        } catch (Throwable $e) {
            $invoice->number = $this->fallbackInvoiceNumber();
        }
        $invoice->subtotal = $subtotal;
        $invoice->tax_amount = $taxAmount;
        $invoice->total = $total;
        $invoice->status = 'draft';
        $invoice->save();

        foreach ($lines as $lineData) {
            $line = new InvoiceLine($lineData);
            $line->invoice_id = $invoice->id;
            $line->save();
        }

        // Post to customer account
        $this->postInvoiceToCustomerAccount($invoice);

        // Notify accounting team
        $accountingTeam = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'accountant']))->pluck('id')->toArray();
        if (!empty($accountingTeam)) {
            $formattedTotal = function_exists('format_currency')
                ? format_currency($invoice->total)
                : number_format($invoice->total, 2);

            NotificationDispatcher::toUsers(
                $accountingTeam,
                'invoice.created',
                'New Invoice Created',
                "Invoice {$invoice->number} for {$invoice->customer->name} - Total: {$formattedTotal}",
                route('accounting.invoices.index'),
                'file-text',
                ['type' => 'info', 'actor_id' => auth()->id()]
            );
        }

        return redirect()
            ->route('accounting.invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    protected function postInvoiceToCustomerAccount(Invoice $invoice): void
    {
        if (!$invoice->customer || !$invoice->customer->account) {
            return; // Skip if no customer account linked
        }

        $journalEntry = new \App\Models\Accounting\JournalEntry();
        $journalEntry->reference_number = $invoice->number;
        $journalEntry->entry_date = $invoice->invoice_date;
        $journalEntry->description = "Invoice: {$invoice->number} - {$invoice->customer->name}";
        $journalEntry->total_debit = $invoice->total;
        $journalEntry->total_credit = $invoice->total;
        $journalEntry->status = 'posted';
        $journalEntry->save();

        // Debit customer account (increase receivable)
        $debitLine = new \App\Models\Accounting\JournalEntryLine();
        $debitLine->journal_entry_id = $journalEntry->id;
        $debitLine->account_id = $invoice->customer->account->id;
        $debitLine->debit = $invoice->total;
        $debitLine->credit = 0;
        $debitLine->description = "Invoice receivable";
        $debitLine->save();

        // Credit sales revenue account (you may want to make this configurable)
        $salesAccount = Accounting::where('code', '4000')->first(); // Sales Revenue
        if (!$salesAccount) {
            $salesAccount = Accounting::first(); // Fallback to first account
        }

        $creditLine = new \App\Models\Accounting\JournalEntryLine();
        $creditLine->journal_entry_id = $journalEntry->id;
        $creditLine->account_id = $salesAccount->id;
        $creditLine->debit = 0;
        $creditLine->credit = $invoice->total;
        $creditLine->description = "Sales revenue";
        $creditLine->save();

        // Update invoice status to posted
        $invoice->status = 'posted';
        $invoice->save();
    }

    /**
     * Get invoices data for DataTables with high performance optimization
     */
    public function datatable(Request $request): JsonResponse
    {
        $query = Invoice::query()
            ->select([
                'invoices.id',
                'invoices.number',
                'invoices.customer_id',
                'invoices.type',
                'invoices.invoice_date',
                'invoices.total',
                'invoices.status',
                'customers.name as customer_name'
            ])
            ->leftJoin('customers', 'invoices.customer_id', '=', 'customers.id');

        // Apply filters with performance optimizations
        if ($request->filled('search_value') && !empty($request->search_value)) {
            $searchValue = $request->search_value;
            $query->where(function ($q) use ($searchValue) {
                $q->where('invoices.number', 'LIKE', "%{$searchValue}%")
                  ->orWhere('customers.name', 'LIKE', "%{$searchValue}%")
                  ->orWhere('invoices.reference', 'LIKE', "%{$searchValue}%");
            });
        }

        if ($request->filled('customer_id') && $request->customer_id !== '') {
            $query->where('invoices.customer_id', $request->customer_id);
        }

        if ($request->filled('type') && $request->type !== '') {
            $query->where('invoices.type', $request->type);
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('invoices.status', $request->status);
        }

        if ($request->filled('date_from') && $request->date_from !== '') {
            $query->where('invoices.invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && $request->date_to !== '') {
            $query->where('invoices.invoice_date', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($invoice) {
                return $invoice->customer_name ?: '-';
            })
            ->addColumn('type_label', function ($invoice) {
                return $invoice->type === 'sales' ? 'مبيعات' : 'مشتريات';
            })
            ->addColumn('invoice_date_formatted', function ($invoice) {
                return $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '';
            })
            ->addColumn('total_formatted', function ($invoice) {
                if (function_exists('format_currency')) {
                    return format_currency($invoice->total);
                }

                return number_format($invoice->total, 2);
            })
            ->addColumn('status_badge', function ($invoice) {
                $statusConfig = [
                    'paid' => ['color' => 'emerald', 'text' => 'مدفوعة', 'icon' => 'check-circle'],
                    'pending' => ['color' => 'amber', 'text' => 'معلقة', 'icon' => 'clock'],
                    'overdue' => ['color' => 'rose', 'text' => 'متأخرة', 'icon' => 'alert-triangle'],
                    'cancelled' => ['color' => 'slate', 'text' => 'ملغاة', 'icon' => 'x-circle']
                ];

                $config = $statusConfig[$invoice->status] ?? ['color' => 'slate', 'text' => $invoice->status, 'icon' => 'circle'];

                return "<span class=\"inline-flex items-center gap-1 px-2 py-1 bg-{$config['color']}-100 text-{$config['color']}-600 rounded text-xs font-semibold\"><i data-lucide=\"{$config['icon']}\" class=\"w-3 h-3\"></i> {$config['text']}</span>";
            })
            ->addColumn('actions', function ($invoice) {
                return "
                    <div class=\"flex justify-center gap-1\">
                        <button class=\"p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors\" title=\"عرض\" onclick=\"viewInvoice('{$invoice->id}')\">
                            <i data-lucide=\"eye\" class=\"w-4 h-4\"></i>
                        </button>
                        <button class=\"p-1.5 rounded hover:bg-amber-50 text-amber-600 hover:text-amber-800 transition-colors\" title=\"تعديل\" onclick=\"openEditModal('{$invoice->id}')\">
                            <i data-lucide=\"edit\" class=\"w-4 h-4\"></i>
                        </button>
                        <button class=\"p-1.5 rounded hover:bg-emerald-50 text-emerald-600 hover:text-emerald-800 transition-colors\" title=\"طباعة\" onclick=\"printInvoice('{$invoice->id}')\">
                            <i data-lucide=\"printer\" class=\"w-4 h-4\"></i>
                        </button>
                        <button class=\"p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors\" title=\"حذف\" onclick=\"deleteInvoice('{$invoice->id}', '{$invoice->number}')\">
                            <i data-lucide=\"trash-2\" class=\"w-4 h-4\"></i>
                        </button>
                    </div>
                ";
            })
            ->rawColumns(['status_badge', 'actions'])
            ->orderColumn('number', 'invoices.number $1')
            ->orderColumn('customer_name', 'customers.name $1')
            ->orderColumn('invoice_date', 'invoices.invoice_date $1')
            ->orderColumn('total', 'invoices.total $1')
            ->toJson();
    }

    /**
     * Get invoice statistics for real-time updates
     */
    public function stats(Request $request): JsonResponse
    {
        // Base query for consistent filtering
        $baseQuery = Invoice::query();

        // Apply the same filters as datatable
        if ($request->filled('search_value') && !empty($request->search_value)) {
            $searchValue = $request->search_value;
            $baseQuery->where(function ($q) use ($searchValue) {
                $q->where('number', 'LIKE', "%{$searchValue}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($searchValue) {
                      $customerQuery->where('name', 'LIKE', "%{$searchValue}%");
                  })
                  ->orWhere('reference', 'LIKE', "%{$searchValue}%");
            });
        }

        if ($request->filled('customer_id') && $request->customer_id !== '') {
            $baseQuery->where('customer_id', $request->customer_id);
        }

        if ($request->filled('type') && $request->type !== '') {
            $baseQuery->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== '') {
            $baseQuery->where('status', $request->status);
        }

        if ($request->filled('date_from') && $request->date_from !== '') {
            $baseQuery->where('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && $request->date_to !== '') {
            $baseQuery->where('invoice_date', '<=', $request->date_to);
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'paid' => (clone $baseQuery)->where('status', 'paid')->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'overdue' => (clone $baseQuery)->where('status', 'overdue')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Show a specific invoice
     */
    public function show(Invoice $invoice): JsonResponse
    {
        $invoice->load(['customer', 'tax', 'lines.account']);

        return response()->json([
            'id' => $invoice->id,
            'number' => $invoice->number,
            'customer_id' => $invoice->customer_id,
            'customer' => $invoice->customer,
            'type' => $invoice->type,
            'invoice_date' => $invoice->invoice_date?->format('Y-m-d'),
            'due_date' => $invoice->due_date?->format('Y-m-d'),
            'reference' => $invoice->reference,
            'status' => $invoice->status,
            'notes' => $invoice->notes,
            'subtotal' => $invoice->subtotal,
            'tax_amount' => $invoice->tax_amount,
            'total' => $invoice->total,
            'lines' => $invoice->lines->map(function ($line) {
                return [
                    'id' => $line->id,
                    'description' => $line->description,
                    'account_id' => $line->account_id,
                    'account' => $line->account,
                    'quantity' => $line->quantity,
                    'unit_price' => $line->unit_price,
                    'total' => $line->line_total,
                ];
            })
        ]);
    }

    /**
     * Update an invoice
     */
    public function update(Request $request, Invoice $invoice): JsonResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'type' => ['required', 'in:sales,purchase'],
            'invoice_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:invoice_date'],
            'reference' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,pending,paid,overdue,cancelled'],
            'notes' => ['nullable', 'string'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.id' => ['nullable', 'exists:invoice_lines,id'],
            'lines.*.account_id' => ['required', 'exists:accountings,id'],
            'lines.*.description' => ['nullable', 'string', 'max:255'],
            'lines.*.quantity' => ['required', 'numeric', 'min:0'],
            'lines.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $lines = $data['lines'];
        unset($data['lines']);

        $subtotal = 0;
        foreach ($lines as &$line) {
            $lineTotal = (float)$line['quantity'] * (float)$line['unit_price'];
            $line['line_total'] = $lineTotal;
            $subtotal += $lineTotal;
        }
        unset($line);

        $taxAmount = 0;
        $invoice->load('tax');
        if ($invoice->tax) {
            $taxAmount = round($subtotal * ((float)$invoice->tax->rate / 100), 2);
        }

        $total = $subtotal + $taxAmount;

        // Update invoice
        $invoice->update(array_merge($data, [
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ]));

        // Update lines
        $existingLineIds = [];
        foreach ($lines as $lineData) {
            if (isset($lineData['id']) && $lineData['id']) {
                // Update existing line
                $line = \App\Models\Accounting\InvoiceLine::find($lineData['id']);
                if ($line) {
                    $line->update($lineData);
                    $existingLineIds[] = $line->id;
                }
            } else {
                // Create new line
                $line = new \App\Models\Accounting\InvoiceLine($lineData);
                $line->invoice_id = $invoice->id;
                $line->save();
                $existingLineIds[] = $line->id;
            }
        }

        // Delete removed lines
        if (!empty($existingLineIds)) {
            \App\Models\Accounting\InvoiceLine::where('invoice_id', $invoice->id)
                ->whereNotIn('id', $existingLineIds)
                ->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully.',
            'invoice' => $invoice->load(['customer', 'lines.account'])
        ]);
    }

    /**
     * Delete an invoice
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        try {
            // Delete associated journal entries first
            $journalEntries = \App\Models\Accounting\JournalEntry::where('reference_number', $invoice->number)->get();
            foreach ($journalEntries as $journalEntry) {
                $journalEntry->lines()->delete();
                $journalEntry->delete();
            }

            // Delete invoice lines
            $invoice->lines()->delete();

            // Delete invoice
            $invoice->delete();

            return response()->json([
                'success' => true,
                'message' => 'Invoice deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export PDF
     */
    public function exportPdf(Request $request)
    {
        // TODO: Implement PDF export
        return response()->json(['message' => 'PDF export not implemented yet']);
    }

    /**
     * Export Excel
     */
    public function export(Request $request)
    {
        $query = Invoice::with(['customer', 'tax', 'lines.account']);

        // Apply same filters as datatable
        if ($request->filled('search_value') && !empty($request->search_value)) {
            $searchValue = $request->search_value;
            $query->where(function ($q) use ($searchValue) {
                $q->where('number', 'LIKE', "%{$searchValue}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($searchValue) {
                      $customerQuery->where('name', 'LIKE', "%{$searchValue}%");
                  })
                  ->orWhere('reference', 'LIKE', "%{$searchValue}%");
            });
        }

        if ($request->filled('customer_id') && $request->customer_id !== '') {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from') && $request->date_from !== '') {
            $query->where('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && $request->date_to !== '') {
            $query->where('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="invoices_' . date('Y-m-d_H-i-s') . '.csv"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        $callback = function () use ($invoices) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($file, [
                'رقم الفاتورة',
                'العميل',
                'النوع',
                'التاريخ',
                'تاريخ الاستحقاق',
                'المجموع الفرعي',
                'ضريبة القيمة المضافة',
                'الإجمالي',
                'الحالة',
                'المرجع',
                'ملاحظات'
            ]);

            // Data
            foreach ($invoices as $invoice) {
                $format = function ($value) {
                    if (function_exists('format_currency')) {
                        return format_currency($value);
                    }

                    return number_format((float) $value, 2);
                };

                fputcsv($file, [
                    $invoice->number,
                    $invoice->customer->name ?? '',
                    $invoice->type === 'sales' ? 'مبيعات' : 'مشتريات',
                    $invoice->invoice_date?->format('Y-m-d'),
                    $invoice->due_date?->format('Y-m-d'),
                    $format($invoice->subtotal),
                    $format($invoice->tax_amount),
                    $format($invoice->total),
                    $invoice->status,
                    $invoice->reference,
                    $invoice->notes
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
