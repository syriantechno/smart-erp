<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\Accounting;
use App\Models\Accounting\Invoice;
use App\Models\Accounting\InvoiceLine;
use App\Models\Accounting\Tax;
use App\Models\Company;
use App\Models\Customer;
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
        $customers = Customer::orderBy('name')->get();
        $taxes = Tax::where('is_active', true)->orderBy('name')->get();
        $accounts = Accounting::orderBy('code')->get();
        $invoices = Invoice::with(['customer', 'tax'])
            ->orderByDesc('invoice_date')
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        return view('accounting.invoices.index', compact('companies', 'customers', 'taxes', 'accounts', 'invoices', 'totalInvoices', 'paidInvoices', 'pendingInvoices', 'overdueInvoices'));
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
            'customer_id' => ['required', 'exists:customers,id'],
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

        // Post to customer account
        $this->postInvoiceToCustomerAccount($invoice);

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
}
