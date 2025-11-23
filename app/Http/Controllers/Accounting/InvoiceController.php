<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoiceLine;
use App\Models\Accounting\Tax;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        // Get statistics for the royal theme header
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'pending')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();

        $companies = Company::orderBy('name')->get();
        $taxes = Tax::where('is_active', true)->orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $invoices = Invoice::with(['company', 'tax'])
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        return view('accounting.invoices.index', compact('companies', 'taxes', 'accounts', 'invoices', 'totalInvoices', 'paidInvoices', 'pendingInvoices', 'overdueInvoices'));
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'type' => ['required', 'in:sales,purchase'],
            'tax_id' => ['nullable', 'exists:taxes,id'],
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
        $invoice->number = $this->generateInvoiceNumber();
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

        return redirect()
            ->route('accounting.invoices.index')
            ->with('success', 'Invoice created successfully.');
    }
}
