<div class="intro-y box p-5">
    <h2 class="mb-4 text-lg font-medium">Tax Settings</h2>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-4">
            <h3 class="mb-3 text-base font-semibold">Add New Tax</h3>

            <form method="POST" action="{{ route('settings.taxes.store') }}" class="space-y-4">
                @csrf

                <div>
                    <x-base.form-label for="tax_company_id">Company</x-base.form-label>
                    <x-base.form-select id="tax_company_id" name="company_id">
                        <option value="">All Companies</option>
                        @foreach($companies as $companyItem)
                            <option value="{{ $companyItem->id }}" @selected(old('company_id') == $companyItem->id)>
                                {{ $companyItem->name }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div>
                    <x-base.form-label for="tax_name">Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="tax_name" name="name" type="text" value="{{ old('name') }}" required />
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <x-base.form-label for="tax_code">Code</x-base.form-label>
                        <x-base.form-input id="tax_code" name="code" type="text" value="{{ old('code') }}" />
                    </div>
                    <div class="col-span-6">
                        <x-base.form-label for="tax_rate">Rate (%) <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-input id="tax_rate" name="rate" type="number" min="0" max="100" step="0.001" value="{{ old('rate', 15) }}" required />
                    </div>
                </div>

                <div>
                    <x-base.form-label for="tax_type">Type</x-base.form-label>
                    <x-base.form-select id="tax_type" name="type">
                        <option value="value_added" @selected(old('type') == 'value_added')>Value Added</option>
                        <option value="withholding" @selected(old('type') == 'withholding')>Withholding</option>
                        <option value="other" @selected(old('type') == 'other')>Other</option>
                    </x-base.form-select>
                </div>

                <div>
                    <x-base.form-label for="sales_account_id">Sales Tax Account</x-base.form-label>
                    <x-base.form-select id="sales_account_id" name="sales_account_id">
                        <option value="">Select account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('sales_account_id') == $account->id)>
                                {{ $account->code }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div>
                    <x-base.form-label for="purchase_account_id">Purchase Tax Account</x-base.form-label>
                    <x-base.form-select id="purchase_account_id" name="purchase_account_id">
                        <option value="">Select account</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @selected(old('purchase_account_id') == $account->id)>
                                {{ $account->code }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div>
                    <x-base.form-label for="tax_description">Description</x-base.form-label>
                    <x-base.form-textarea id="tax_description" name="description" rows="2">{{ old('description') }}</x-base.form-textarea>
                </div>

                <div class="flex flex-col gap-2">
                    <x-base.form-switch>
                        <x-base.form-switch.input id="tax_is_default" name="is_default" type="checkbox" value="1" @checked(old('is_default')) />
                        <x-base.form-switch.label for="tax_is_default">Set as default tax</x-base.form-switch.label>
                    </x-base.form-switch>

                    <x-base.form-switch>
                        <x-base.form-switch.input id="tax_is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true)) />
                        <x-base.form-switch.label for="tax_is_active">Active</x-base.form-switch.label>
                    </x-base.form-switch>
                </div>

                <div class="pt-2 text-right">
                    <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">
                        Save Tax
                    </button>
                </div>
            </form>
        </div>

        <div class="col-span-12 lg:col-span-8">
            <h3 class="mb-3 text-base font-semibold">Existing Taxes</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                            <th class="py-2 pr-4">Name</th>
                            <th class="py-2 pr-4">Rate</th>
                            <th class="py-2 pr-4">Type</th>
                            <th class="py-2 pr-4">Company</th>
                            <th class="py-2 pr-4">Default</th>
                            <th class="py-2 pr-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($taxes as $tax)
                            <tr class="border-b border-slate-100 text-xs text-slate-700 dark:text-slate-300">
                                <td class="py-2 pr-4">
                                    <div class="font-semibold">{{ $tax->name }}</div>
                                    @if($tax->code)
                                        <div class="text-[11px] text-slate-500">Code: {{ $tax->code }}</div>
                                    @endif
                                </td>
                                <td class="py-2 pr-4">{{ number_format($tax->rate, 3) }}%</td>
                                <td class="py-2 pr-4">{{ ucfirst(str_replace('_', ' ', $tax->type)) }}</td>
                                <td class="py-2 pr-4">{{ $tax->company->name ?? 'All Companies' }}</td>
                                <td class="py-2 pr-4">
                                    @if($tax->is_default)
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700">Default</span>
                                    @else
                                        <span class="text-[11px] text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4">
                                    @if($tax->is_active)
                                        <span class="rounded-full bg-green-100 px-2 py-0.5 text-[11px] font-semibold text-green-700">Active</span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-semibold text-red-700">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-xs text-slate-500">
                                    No taxes defined yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
