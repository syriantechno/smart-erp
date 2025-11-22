@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Invoices - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Invoices</h2>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Create Invoice -->
        <div class="intro-y col-span-12 lg:col-span-5">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Create New Invoice</h3>

                    <form method="POST" action="{{ route('accounting.invoices.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-base.form-label for="company_id">Company <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="company_id" name="company_id" required>
                                <option value="">Select company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="type">Type <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select id="type" name="type" required>
                                    <option value="sales" @selected(old('type') == 'sales')>Sales Invoice</option>
                                    <option value="purchase" @selected(old('type') == 'purchase')>Purchase Invoice</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="tax_id">Tax</x-base.form-label>
                                <x-base.form-select id="tax_id" name="tax_id">
                                    <option value="">No tax</option>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}" @selected(old('tax_id') == $tax->id)>
                                            {{ $tax->name }} ({{ number_format($tax->rate, 3) }}%)
                                        </option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="invoice_date">Invoice Date <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="invoice_date" name="invoice_date" type="date" value="{{ old('invoice_date', now()->toDateString()) }}" required />
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="due_date">Due Date</x-base.form-label>
                                <x-base.form-input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" />
                            </div>
                        </div>

                        <div>
                            <x-base.form-label for="reference">Reference</x-base.form-label>
                            <x-base.form-input id="reference" name="reference" type="text" value="{{ old('reference') }}" />
                        </div>

                        <div>
                            <x-base.form-label for="notes">Notes</x-base.form-label>
                            <x-base.form-textarea id="notes" name="notes" rows="2">{{ old('notes') }}</x-base.form-textarea>
                        </div>

                        <div>
                            <x-base.form-label>Lines <span class="text-danger">*</span></x-base.form-label>

                            <div class="space-y-3" id="invoice-lines">
                                <div class="grid grid-cols-12 gap-2 invoice-line-row">
                                    <div class="col-span-12">
                                        <x-base.form-label>Account</x-base.form-label>
                                        <x-base.form-select name="lines[0][account_id]" required>
                                            <option value="">Select account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}">
                                                    {{ $account->code }} - {{ $account->name }}
                                                </option>
                                            @endforeach
                                        </x-base.form-select>
                                    </div>
                                    <div class="col-span-12">
                                        <x-base.form-label>Description</x-base.form-label>
                                        <x-base.form-input name="lines[0][description]" type="text" />
                                    </div>
                                    <div class="col-span-6">
                                        <x-base.form-label>Quantity</x-base.form-label>
                                        <x-base.form-input name="lines[0][quantity]" type="number" min="0" step="0.001" value="1" />
                                    </div>
                                    <div class="col-span-6">
                                        <x-base.form-label>Unit Price</x-base.form-label>
                                        <x-base.form-input name="lines[0][unit_price]" type="number" min="0" step="0.01" value="0" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                For now, one line is enough for testing. Later we can enhance with dynamic rows.
                            </div>
                        </div>

                        <div class="pt-2 text-right">
                            <x-base.button type="submit" variant="primary">
                                Save Invoice
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Invoices List -->
        <div class="intro-y col-span-12 lg:col-span-7">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Recent Invoices</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                                    <th class="py-2 pr-4">Number</th>
                                    <th class="py-2 pr-4">Company</th>
                                    <th class="py-2 pr-4">Type</th>
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Total</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr class="border-b border-slate-100 text-xs text-slate-700 dark:text-slate-300">
                                        <td class="py-2 pr-4">
                                            <div class="font-semibold">{{ $invoice->number }}</div>
                                            @if($invoice->reference)
                                                <div class="text-[11px] text-slate-500">Ref: {{ $invoice->reference }}</div>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-4">{{ $invoice->company->name ?? '-' }}</td>
                                        <td class="py-2 pr-4">{{ $invoice->type_label }}</td>
                                        <td class="py-2 pr-4">{{ $invoice->invoice_date?->format('Y-m-d') }}</td>
                                        <td class="py-2 pr-4">{{ number_format($invoice->total, 2) }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700 capitalize">
                                                {{ $invoice->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-xs text-slate-500">
                                            No invoices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection
