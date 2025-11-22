@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Receipt Vouchers - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Receipt Vouchers</h2>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-5">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Create New Receipt Voucher</h3>

                    <form method="POST" action="{{ route('accounting.receipt-vouchers.store') }}" class="space-y-4">
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
                                <x-base.form-label for="method">Method <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-select id="method" name="method" required>
                                    <option value="cash" @selected(old('method') == 'cash')>Cash</option>
                                    <option value="bank" @selected(old('method') == 'bank')>Bank</option>
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

                        <div id="cash-box-wrapper">
                            <x-base.form-label for="cash_box_id">Cash Box</x-base.form-label>
                            <x-base.form-select id="cash_box_id" name="cash_box_id">
                                <option value="">Select cash box</option>
                                @foreach($cashBoxes as $box)
                                    <option value="{{ $box->id }}" @selected(old('cash_box_id') == $box->id)>
                                        {{ $box->name }} ({{ $box->company->name ?? '-' }})
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div id="bank-account-wrapper" class="hidden">
                            <x-base.form-label for="bank_account_id">Bank Account</x-base.form-label>
                            <x-base.form-select id="bank_account_id" name="bank_account_id">
                                <option value="">Select bank account</option>
                                @foreach($bankAccounts as $acc)
                                    <option value="{{ $acc->id }}" @selected(old('bank_account_id') == $acc->id)>
                                        {{ $acc->name }} ({{ $acc->company->name ?? '-' }})
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div>
                            <x-base.form-label for="account_id">Counterparty Account <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-select id="account_id" name="account_id" required>
                                <option value="">Select account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('account_id') == $account->id)>
                                        {{ $account->code }} - {{ $account->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-6">
                                <x-base.form-label for="voucher_date">Date <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="voucher_date" name="voucher_date" type="date" value="{{ old('voucher_date', now()->toDateString()) }}" required />
                            </div>
                            <div class="col-span-6">
                                <x-base.form-label for="amount">Amount <span class="text-danger">*</span></x-base.form-label>
                                <x-base.form-input id="amount" name="amount" type="number" min="0" step="0.01" value="{{ old('amount', 0) }}" required />
                            </div>
                        </div>

                        <div>
                            <x-base.form-label for="reference">Reference</x-base.form-label>
                            <x-base.form-input id="reference" name="reference" type="text" value="{{ old('reference') }}" />
                        </div>

                        <div>
                            <x-base.form-label for="description">Description</x-base.form-label>
                            <x-base.form-textarea id="description" name="description" rows="2">{{ old('description') }}</x-base.form-textarea>
                        </div>

                        <div class="pt-2 text-right">
                            <x-base.button type="submit" variant="primary">
                                Save Receipt Voucher
                            </x-base.button>
                        </div>
                    </form>
                </div>
            </x-base.preview-component>
        </div>

        <div class="intro-y col-span-12 lg:col-span-7">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <h3 class="mb-4 text-base font-semibold">Recent Receipt Vouchers</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                                    <th class="py-2 pr-4">Date</th>
                                    <th class="py-2 pr-4">Company</th>
                                    <th class="py-2 pr-4">Method</th>
                                    <th class="py-2 pr-4">Account</th>
                                    <th class="py-2 pr-4">Total</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vouchers as $v)
                                    <tr class="border-b border-slate-100 text-xs text-slate-700 dark:text-slate-300">
                                        <td class="py-2 pr-4">{{ $v->voucher_date?->format('Y-m-d') }}</td>
                                        <td class="py-2 pr-4">{{ $v->company->name ?? '-' }}</td>
                                        <td class="py-2 pr-4">{{ ucfirst($v->method) }}</td>
                                        <td class="py-2 pr-4">{{ $v->account?->code }} - {{ $v->account?->name }}</td>
                                        <td class="py-2 pr-4">{{ number_format($v->total_amount, 2) }}</td>
                                        <td class="py-2 pr-4">
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-700 capitalize">
                                                {{ $v->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-xs text-slate-500">
                                            No receipt vouchers found.
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const methodSelect = document.getElementById('method');
                const cashWrapper = document.getElementById('cash-box-wrapper');
                const bankWrapper = document.getElementById('bank-account-wrapper');

                function updateMethodVisibility() {
                    const method = methodSelect.value;
                    if (method === 'cash') {
                        cashWrapper.classList.remove('hidden');
                        bankWrapper.classList.add('hidden');
                    } else {
                        cashWrapper.classList.add('hidden');
                        bankWrapper.classList.remove('hidden');
                    }
                }

                if (methodSelect) {
                    methodSelect.addEventListener('change', updateMethodVisibility);
                    updateMethodVisibility();
                }
            });
        </script>
    @endpush
@endsection
