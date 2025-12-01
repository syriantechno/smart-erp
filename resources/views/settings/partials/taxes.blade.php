@php 
    $taxCollection = $taxes ?? collect(); 
@endphp

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Title --}}
                <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-700 mb-5">
                    <x-base.lucide icon="percent" class="w-6 h-6 text-amber-600" />
                    <span>Tax Management</span>
                </h2>

                {{-- Filters & Actions Toolbar --}}
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                    <form id="taxes-filter-form" class="w-full sm:mr-auto xl:flex">
                        <div class="items-center sm:mr-4 sm:flex">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">Field</label>
                            <x-base.form-select id="tax-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                <option value="all">All</option>
                                <option value="name">Name</option>
                                <option value="code">Code</option>
                                <option value="type">Type</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">Value</label>
                            <x-base.form-input id="tax-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                        </div>
                        <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                            <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial text-slate-500">Status</label>
                            <x-base.form-select id="tax-filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                            <x-base.tippy content="Apply filter" placement="top">
                                <button id="tax-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Search
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Reset" placement="top">
                                <button id="tax-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </x-base.tippy>
                        </div>
                    </form>

                    <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                        <x-base.tippy content="Print" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="Export Excel" placement="bottom">
                            <button id="tax-export-excel" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="Refresh" placement="bottom">
                            <button id="tax-refresh-table" type="button" class="btn-royal btn-royal--outline btn-royal--sm group text-royalDark" onclick="location.reload()">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </x-base.tippy>
                        {{-- Add Button --}}
                        <x-base.tippy content="Add new tax" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group" data-tw-toggle="modal" data-tw-target="#create-tax-modal">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                <span class="hidden sm:inline">Add</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                <div class="overflow-x-auto sm:overflow-visible mt-5" data-erp-table-wrapper>
                    <table id="taxes-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center w-12">#</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Tax</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Rate</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Accounts</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($taxCollection as $tax)
                            @php
                                $taxData = json_encode([
                                    'id' => $tax->id,
                                    'name' => $tax->name,
                                    'code' => $tax->code,
                                    'rate' => $tax->rate,
                                    'type' => $tax->type,
                                    'company_id' => $tax->company_id,
                                    'sales_account_id' => $tax->sales_account_id,
                                    'purchase_account_id' => $tax->purchase_account_id,
                                    'description' => $tax->description,
                                    'is_default' => $tax->is_default,
                                    'is_active' => $tax->is_active,
                                ]);
                            @endphp
                            <tr class="intro-x" data-id="{{ $tax->id }}">
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center text-slate-500">
                                    {{ $loop->iteration }}
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-100 to-amber-50 flex items-center justify-center">
                                            <x-base.lucide icon="percent" class="w-5 h-5 text-amber-600" />
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $tax->name }}</div>
                                            @if($tax->code)
                                                <div class="text-xs text-slate-400">{{ $tax->code }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm font-bold">
                                        {{ number_format($tax->rate, 2) }}%
                                    </span>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    @php
                                        $typeLabels = [
                                            'value_added' => ['label' => 'Value Added', 'color' => 'blue'],
                                            'withholding' => ['label' => 'Withholding', 'color' => 'purple'],
                                            'other' => ['label' => 'Other', 'color' => 'slate'],
                                        ];
                                        $typeInfo = $typeLabels[$tax->type] ?? ['label' => $tax->type, 'color' => 'slate'];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 bg-{{ $typeInfo['color'] }}-100 text-{{ $typeInfo['color'] }}-600 rounded text-xs font-medium">
                                        {{ $typeInfo['label'] }}
                                    </span>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <span class="text-sm">{{ $tax->company->name ?? 'All companies' }}</span>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300">
                                    <div class="text-xs space-y-1">
                                        @if($tax->salesAccount)
                                            <div class="flex items-center gap-1">
                                                <span class="text-slate-400">Sales:</span>
                                                <span class="font-medium">{{ $tax->salesAccount->code }}</span>
                                            </div>
                                        @endif
                                        @if($tax->purchaseAccount)
                                            <div class="flex items-center gap-1">
                                                <span class="text-slate-400">Purchases:</span>
                                                <span class="font-medium">{{ $tax->purchaseAccount->code }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        @if($tax->is_active)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-xs font-semibold">
                                                <x-base.lucide icon="check-circle" class="w-3 h-3" /> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-500 rounded text-xs font-semibold">
                                                <x-base.lucide icon="pause-circle" class="w-3 h-3" /> Inactive
                                            </span>
                                        @endif
                                        @if($tax->is_default)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-xs font-semibold">
                                                <x-base.lucide icon="star" class="w-3 h-3" /> Default
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td data-tw-merge class="px-5 py-3 border-b dark:border-darkmode-300 text-center">
                                    <div class="flex justify-center gap-1">
                                        <button class="btn-tax-edit p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" 
                                                data-id="{{ $tax->id }}"
                                                data-tax="{{ $taxData }}"
                                                title="Edit">
                                            <x-base.lucide icon="edit" class="w-4 h-4" />
                                        </button>
                                        <button class="btn-tax-delete p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" 
                                                data-id="{{ $tax->id }}" 
                                                data-name="{{ $tax->name }}" 
                                                title="Delete">
                                            <x-base.lucide icon="trash-2" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-8 text-center text-slate-400">
                                    <x-base.lucide icon="percent" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                                    No taxes found
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

{{-- Create Tax Modal (Unified Theme) --}}
<x-modal.form id="create-tax-modal" title="Add New Tax">
    <form id="create-tax-form" action="{{ route('settings.taxes.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax-name">Tax Name <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="create-tax-name" name="name" type="text" placeholder="e.g. Value Added Tax" class="w-full" required />
            </div>
            <div class="col-span-12 md:col-span-3">
                <x-base.form-label for="create-tax-code">Code</x-base.form-label>
                <x-base.form-input id="create-tax-code" name="code" type="text" placeholder="VAT" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-3">
                <x-base.form-label for="create-tax-rate">Rate (%) <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="create-tax-rate" name="rate" type="number" min="0" max="100" step="0.01" value="5" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax-type">Type</x-base.form-label>
                <x-base.form-select id="create-tax-type" name="type" class="w-full">
                    <option value="value_added">Value Added</option>
                    <option value="withholding">Withholding</option>
                    <option value="other">Other</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax-company">Company</x-base.form-label>
                <x-base.form-select id="create-tax-company" name="company_id" class="w-full">
                    <option value="">All companies</option>
                    @foreach($companies ?? [] as $companyItem)
                        <option value="{{ $companyItem->id }}">{{ $companyItem->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax-sales-account">Sales Tax Account</x-base.form-label>
                <x-base.form-select id="create-tax-sales-account" name="sales_account_id" class="w-full">
                    <option value="">Select account</option>
                    @foreach($accounts ?? [] as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="create-tax-purchase-account">Purchase Tax Account</x-base.form-label>
                <x-base.form-select id="create-tax-purchase-account" name="purchase_account_id" class="w-full">
                    <option value="">Select account</option>
                    @foreach($accounts ?? [] as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="create-tax-description">Description</x-base.form-label>
                <x-base.form-textarea id="create-tax-description" name="description" rows="2" placeholder="Tax description" class="w-full"></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_default" value="1" class="form-checkbox rounded text-primary">
                        <span>Default tax</span>
                    </label>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="form-checkbox rounded text-primary">
                        <span>Active</span>
                    </label>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button type="button" id="save-tax-btn" class="btn-royal btn-royal--gold group">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save
            </button>
        </div>
    @endslot
</x-modal.form>

{{-- Edit Tax Modal (Unified Theme) --}}
<x-modal.form id="edit-tax-modal" title="Edit Tax">
    <form id="edit-tax-form" method="POST">
        @csrf
        <input type="hidden" id="edit-tax-id" name="id">
        <div class="grid grid-cols-12 gap-4 gap-y-4">
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax-name">Tax Name <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-tax-name" name="name" type="text" placeholder="e.g. Value Added Tax" class="w-full" required />
            </div>
            <div class="col-span-12 md:col-span-3">
                <x-base.form-label for="edit-tax-code">Code</x-base.form-label>
                <x-base.form-input id="edit-tax-code" name="code" type="text" placeholder="VAT" class="w-full" />
            </div>
            <div class="col-span-12 md:col-span-3">
                <x-base.form-label for="edit-tax-rate">Rate (%) <span class="text-danger">*</span></x-base.form-label>
                <x-base.form-input id="edit-tax-rate" name="rate" type="number" min="0" max="100" step="0.01" class="w-full" required />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax-type">Type</x-base.form-label>
                <x-base.form-select id="edit-tax-type" name="type" class="w-full">
                    <option value="value_added">Value Added</option>
                    <option value="withholding">Withholding</option>
                    <option value="other">Other</option>
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax-company">Company</x-base.form-label>
                <x-base.form-select id="edit-tax-company" name="company_id" class="w-full">
                    <option value="">All companies</option>
                    @foreach($companies ?? [] as $companyItem)
                        <option value="{{ $companyItem->id }}">{{ $companyItem->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax-sales-account">Sales Tax Account</x-base.form-label>
                <x-base.form-select id="edit-tax-sales-account" name="sales_account_id" class="w-full">
                    <option value="">Select account</option>
                    @foreach($accounts ?? [] as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="edit-tax-purchase-account">Purchase Tax Account</x-base.form-label>
                <x-base.form-select id="edit-tax-purchase-account" name="purchase_account_id" class="w-full">
                    <option value="">Select account</option>
                    @foreach($accounts ?? [] as $account)
                        <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                    @endforeach
                </x-base.form-select>
            </div>

            <div class="col-span-12">
                <x-base.form-label for="edit-tax-description">Description</x-base.form-label>
                <x-base.form-textarea id="edit-tax-description" name="description" rows="2" placeholder="Tax description" class="w-full"></x-base.form-textarea>
            </div>

            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit-tax-is-default" name="is_default" value="1" class="form-checkbox rounded text-primary">
                        <span>Default tax</span>
                    </label>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6">
                <div class="flex items-center gap-4 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit-tax-is-active" name="is_active" value="1" class="form-checkbox rounded text-primary">
                        <span>Active</span>
                    </label>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button type="button" id="update-tax-btn" class="btn-royal btn-royal--gold group">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Update
            </button>
        </div>
    @endslot
</x-modal.form>

@push('styles')
<style>
    #taxes-table { font-size: 0.95rem; line-height: 1.4; }
    #taxes-table tbody tr { height: 2.25rem; }
    #taxes-table th { font-size: 0.8rem; font-weight: 700; padding: 0.5rem 1.25rem; }
    #taxes-table td { padding: 0.375rem 1.25rem; }
    .icon-hover-rise { transition: transform 200ms ease; }
    .group:hover .icon-hover-rise { transform: translateY(-2px); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Create Tax
    const saveTaxBtn = document.getElementById('save-tax-btn');
    if (saveTaxBtn) {
        saveTaxBtn.addEventListener('click', function() {
            const form = document.getElementById('create-tax-form');
            const formData = new FormData(form);
            
            saveTaxBtn.disabled = true;
            saveTaxBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Saving...';
            
            fetch('{{ route("settings.taxes.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || '{{ __('settings.tax_created_success') }}');
                    }
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('create-tax-modal'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || '{{ __('settings.tax_create_failed') }}');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('{{ __('settings.tax_save_error') }}');
                }
            })
            .finally(() => {
                saveTaxBtn.disabled = false;
                saveTaxBtn.innerHTML = '<i data-lucide="save" class="w-5 h-5 icon-hover-rise"></i> Save';
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    // Edit Tax - Open Modal
    document.querySelectorAll('.btn-tax-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const tax = JSON.parse(this.dataset.tax);
            
            document.getElementById('edit-tax-id').value = tax.id;
            document.getElementById('edit-tax-name').value = tax.name || '';
            document.getElementById('edit-tax-code').value = tax.code || '';
            document.getElementById('edit-tax-rate').value = tax.rate || '';
            document.getElementById('edit-tax-type').value = tax.type || 'value_added';
            document.getElementById('edit-tax-company').value = tax.company_id || '';
            document.getElementById('edit-tax-sales-account').value = tax.sales_account_id || '';
            document.getElementById('edit-tax-purchase-account').value = tax.purchase_account_id || '';
            document.getElementById('edit-tax-description').value = tax.description || '';
            document.getElementById('edit-tax-is-default').checked = tax.is_default;
            document.getElementById('edit-tax-is-active').checked = tax.is_active;
            
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-tax-modal'));
            modal.show();
        });
    });

    // Update Tax
    const updateTaxBtn = document.getElementById('update-tax-btn');
    if (updateTaxBtn) {
        updateTaxBtn.addEventListener('click', function() {
            const form = document.getElementById('edit-tax-form');
            const formData = new FormData(form);
            const taxId = document.getElementById('edit-tax-id').value;
            
            updateTaxBtn.disabled = true;
            updateTaxBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Updating...';
            
            fetch(`/settings/taxes/${taxId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(data.message || '{{ __('settings.tax_updated_success') }}');
                    }
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-tax-modal'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data.message || '{{ __('settings.tax_update_failed') }}');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showError === 'function') {
                    window.showError('{{ __('settings.tax_update_error') }}');
                }
            })
            .finally(() => {
                updateTaxBtn.disabled = false;
                updateTaxBtn.innerHTML = '<i data-lucide="save" class="w-5 h-5 icon-hover-rise"></i> Update';
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }

    // Delete Tax
    document.querySelectorAll('.btn-tax-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const row = this.closest('tr');

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(name, () => {
                    fetch(`/settings/taxes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof window.showSuccess === 'function') {
                                window.showSuccess(data.message || '{{ __('settings.tax_deleted_success') }}');
                            }
                            row.remove();
                        } else {
                            if (typeof window.showError === 'function') {
                                window.showError(data.message || '{{ __('settings.tax_delete_failed') }}');
                            }
                        }
                    })
                    .catch(() => {
                        if (typeof window.showError === 'function') {
                            window.showError('{{ __('settings.tax_delete_error') }}');
                        }
                    });
                });
            }
        });
    });

    // Filter functionality
    const taxFilterGo = document.getElementById('tax-filter-go');
    const taxFilterReset = document.getElementById('tax-filter-reset');
    
    if (taxFilterGo) {
        taxFilterGo.addEventListener('click', function() {
            const field = document.getElementById('tax-filter-field').value;
            const value = document.getElementById('tax-filter-value').value.toLowerCase();
            const status = document.getElementById('tax-filter-status').value;
            
            document.querySelectorAll('#taxes-table tbody tr').forEach(row => {
                if (row.querySelector('td[colspan]')) return;
                
                let show = true;
                const text = row.textContent.toLowerCase();
                
                if (value && !text.includes(value)) {
                    show = false;
                }
                
                if (status) {
                    const isActive = row.querySelector('.bg-emerald-100') !== null;
                    if (status === 'active' && !isActive) show = false;
                    if (status === 'inactive' && isActive) show = false;
                }
                
                row.style.display = show ? '' : 'none';
            });
        });
    }
    
    if (taxFilterReset) {
        taxFilterReset.addEventListener('click', function() {
            document.getElementById('tax-filter-field').value = 'all';
            document.getElementById('tax-filter-value').value = '';
            document.getElementById('tax-filter-status').value = '';
            document.querySelectorAll('#taxes-table tbody tr').forEach(row => {
                row.style.display = '';
            });
        });
    }
});
</script>
@endpush
