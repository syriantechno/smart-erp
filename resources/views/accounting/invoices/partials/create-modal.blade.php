@php
    $invoiceHeroName = $defaultCompanyName ?? config('app.name', 'Smart ERP');
    $invoiceHeroSubtitle = $defaultCompanyAddress ?? __('invoices.modal.hero_subtitle');
    $invoiceHeroLogo = $defaultCompanyLogo
        ?? 'https://ui-avatars.com/api/?name=' . urlencode($invoiceHeroName) . '&background=1D4ED8&color=fff';
    $currencySymbol = setting('currency.symbol', config('app.currency_symbol', '$'));
    
    $companiesPayload = ($companies ?? collect())->map(fn ($company) => [
        'id' => $company->id,
        'name' => $company->name,
        'address' => $company->address ?? '',
        'logo_url' => $company->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : null,
    ])->values();
    
    $defaultCompany = $companies->first() ?? null;
    $defaultCompanyMeta = $defaultCompany ? [
        'id' => $defaultCompany->id,
        'name' => $defaultCompany->name,
        'address' => $defaultCompany->address ?? '',
        'logo_url' => $defaultCompany->logo ? \Illuminate\Support\Facades\Storage::url($defaultCompany->logo) : null
            ?? 'https://ui-avatars.com/api/?name=' . urlencode($defaultCompany->name) . '&background=1D4ED8&color=fff',
    ] : [
        'id' => null,
        'name' => $invoiceHeroName,
        'address' => $invoiceHeroSubtitle,
        'logo_url' => $invoiceHeroLogo,
    ];
    
    $accountsPayload = ($accounts ?? collect())->map(fn ($account) => [
        'id' => $account->id,
        'code' => $account->code ?? '',
        'name' => $account->name,
    ])->values();
@endphp

<x-modal.form id="create-invoice-modal" size="xxl" title="{{ __('invoices.buttons.create') }}">
    <form id="create-invoice-form" action="{{ route('accounting.invoices.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="total" id="invoice-total" value="0">
        <input type="hidden" name="subtotal" id="invoice-subtotal" value="0">
        <input type="hidden" name="tax_amount" id="invoice-tax-amount" value="0">
        <input type="hidden" name="lines" id="invoice-lines" value="[]">
        <input type="hidden" name="status" value="pending">

        <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
            <div class="flex flex-wrap items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                    <img
                        id="invoice-company-logo"
                        src="{{ $invoiceHeroLogo }}"
                        alt="{{ $invoiceHeroName }} Logo"
                        class="h-full w-full object-cover"
                    >
                </div>
                <div class="flex-1 min-w-[200px]">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">{{ __('invoices.invoice') }}</p>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100" id="invoice-company-name">
                        {{ $invoiceHeroName }}
                    </h3>
                    <p class="text-sm text-slate-500" id="invoice-company-address">
                        {{ $invoiceHeroSubtitle }}
                    </p>
                </div>
                <div class="text-right text-sm text-slate-500">
                    <p>{{ __('invoices.modal.currency') }}</p>
                    <p class="text-base font-semibold text-slate-700">{{ $currencySymbol }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                <div class="border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h4 class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-100">
                        <x-base.lucide icon="Info" class="h-4 w-4" />
                        {{ __('invoices.modal.sections.details') }}
                    </h4>
                </div>
                <div class="grid grid-cols-12 gap-2 px-5 py-4 text-sm">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-code">{{ __('invoices.fields.number') }}</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="invoice-code"
                                name="number"
                                type="text"
                                class="w-full text-sm"
                                readonly
                                placeholder="AUTO"
                            />
                            <x-base.button type="button" variant="outline-secondary" class="shrink-0" id="invoice-regenerate">
                                <x-base.lucide icon="RefreshCcw" class="h-4 w-4" />
                            </x-base.button>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-company">{{ __('invoices.fields.company') }} <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select
                            id="invoice-company"
                            name="company_id"
                            required
                            class="text-sm"
                        >
                            <option value="">{{ __('invoices.fields.select_company') }}</option>
                            @foreach ($companies as $companyOption)
                                <option value="{{ $companyOption->id }}" @selected(($defaultCompany?->id ?? null) === $companyOption->id)>
                                    {{ $companyOption->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-customer">{{ __('invoices.fields.customer') }} <span class="text-danger">*</span></x-base.form-label>
                        <x-base.tom-select id="invoice-customer" name="customer_id" required class="text-sm" data-placeholder="{{ __('invoices.filters.customer_all') }}">
                            <option value="">{{ __('invoices.filters.customer_all') }}</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->code }} — {{ $customer->name }}</option>
                            @endforeach
                        </x-base.tom-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-type">{{ __('invoices.fields.type') }} <span class="text-danger">*</span></x-base.form-label>
                        <x-base.form-select id="invoice-type" name="type" required class="text-sm">
                            <option value="sales">{{ __('invoices.types.sales') }}</option>
                            <option value="purchase">{{ __('invoices.types.purchase') }}</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-date">{{ __('invoices.fields.invoice_date') }} <span class="text-danger">*</span></x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="invoice-date"
                                name="invoice_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-due-date">{{ __('invoices.fields.due_date') }}</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="invoice-due-date"
                                name="due_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                value="{{ now()->format('Y-m-d') }}"
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-status">{{ __('invoices.fields.status') }}</x-base.form-label>
                        <x-base.form-select id="invoice-status" name="status" class="text-sm">
                            <option value="pending">{{ __('invoices.statuses.pending') }}</option>
                            <option value="paid">{{ __('invoices.statuses.paid') }}</option>
                            <option value="overdue">{{ __('invoices.statuses.overdue') }}</option>
                            <option value="cancelled">{{ __('invoices.statuses.cancelled') }}</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-reference">{{ __('invoices.fields.reference') }}</x-base.form-label>
                        <x-base.form-input
                            id="invoice-reference"
                            name="reference"
                            type="text"
                            class="text-sm"
                            placeholder="PO / Project"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="invoice-tax-rate">{{ __('invoices.fields.tax') }} (%)</x-base.form-label>
                        <x-base.form-input
                            id="invoice-tax-rate"
                            name="tax_rate"
                            type="number"
                            min="0"
                            max="100"
                            step="0.5"
                            value="0"
                            class="text-sm"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-12">
                        <x-base.form-label for="invoice-notes">{{ __('invoices.fields.notes') }}</x-base.form-label>
                        <x-base.form-textarea
                            id="invoice-notes"
                            name="notes"
                            rows="3"
                            class="text-sm"
                            placeholder="{{ __('invoices.modal.notes_placeholder') }}"
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                <div class="border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-start justify-between gap-2 text-sm">
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">{{ __('invoices.modal.sections.items') }}</h4>
                            <p class="text-xs text-slate-500">{{ __('invoices.modal.items_hint') }}</p>
                        </div>
                        <div class="grid grid-cols-12 gap-2 text-sm">
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="invoice-account-select">{{ __('invoices.fields.account') }} <span class="text-danger">*</span></x-base.form-label>
                                <x-base.tom-select id="invoice-account-select" data-placeholder="{{ __('invoices.fields.select_account') }}" class="text-sm">
                                    <option value="">{{ __('invoices.fields.select_account') }}</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" data-code="{{ $account->code ?? '' }}">
                                            {{ ($account->code ?? '') ? $account->code . ' — ' : '' }}{{ $account->name }}
                                        </option>
                                    @endforeach
                                </x-base.tom-select>
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-base.form-label for="invoice-item-description">{{ __('invoices.fields.description') }}</x-base.form-label>
                                <x-base.form-input
                                    id="invoice-item-description"
                                    type="text"
                                    placeholder="{{ __('invoices.fields.item_description_placeholder') }}"
                                    class="w-full text-sm"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-5 pb-4 text-sm">
                    <div class="text-xs text-slate-500">
                        {{ __('invoices.modal.items_hint') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
            <div class="flex items-center justify-between border-b border-slate-200/60 pb-4 dark:border-darkmode-400">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">{{ __('invoices.modal.sections.selected_items') }}</h4>
                <span class="text-xs text-slate-500" id="invoice-item-count">0 items</span>
            </div>
            <div class="overflow-x-auto">
                <table class="mt-4 w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-2">{{ __('invoices.fields.account') }}</th>
                            <th class="px-4 py-2">{{ __('invoices.fields.description') }}</th>
                            <th class="px-4 py-2">{{ __('invoices.fields.quantity') }}</th>
                            <th class="px-4 py-2">{{ __('invoices.fields.unit_price') }}</th>
                            <th class="px-4 py-2 text-right">{{ __('invoices.fields.total') }}</th>
                            <th class="px-4 py-2 text-center">{{ __('invoices.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-selected" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <div class="text-xs text-slate-500">{{ __('invoices.modal.update_quantities_hint') }}</div>
                <div class="text-right">
                    <p class="text-xs uppercase text-slate-500">{{ __('invoices.fields.subtotal') }}</p>
                    <p class="text-lg font-semibold text-slate-800" id="invoice-subtotal-display">{{ $currencySymbol }}0.00</p>
                    <p class="text-xs uppercase text-slate-500 mt-2">{{ __('invoices.fields.tax') }}</p>
                    <p class="text-lg font-semibold text-slate-800" id="invoice-tax-display">{{ $currencySymbol }}0.00</p>
                    <p class="text-xs uppercase text-slate-500 mt-2">{{ __('invoices.fields.grand_total') }}</p>
                    <p class="text-2xl font-semibold text-slate-800">
                        <span id="invoice-grand-total">{{ $currencySymbol }}0.00</span>
                    </p>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-royal btn-royal--outline group"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                {{ __('invoices.buttons.cancel') }}
            </button>
            <button
                type="submit"
                form="create-invoice-form"
                id="invoice-submit"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                {{ __('invoices.buttons.create') }}
            </button>
        </div>
    </x-slot>

    <script>
        (() => {
            const init = () => {
                if (window.__invoiceModalInitialized) {
                    return;
                }

                const payload = {
                    routes: {
                        store: '{{ route("accounting.invoices.store") }}',
                        previewCode: '{{ route("accounting.invoices.preview-code") ?? "" }}',
                    },
                    meta: {
                        csrf: '{{ csrf_token() }}'
                    },
                    data: {
                        companies: @json($companiesPayload),
                        defaultCompany: @json($defaultCompanyMeta),
                        accounts: @json($accountsPayload),
                        currencySymbol: @json($currencySymbol)
                    }
                };

                window.__invoiceModalInitialized = true;

                const companies = payload.data.companies || [];
                const defaultCompany = payload.data.defaultCompany || {};
                const companyMap = new Map(companies.map((company) => [String(company.id), company]));

                const state = {
                    accounts: payload.data.accounts || [],
                    accountLookup: new Map(),
                    selected: new Map(),
                    currency: payload.data.currencySymbol || '{{ $currencySymbol }}',
                    companyMap,
                    defaultCompany,
                    selectedCompanyId: defaultCompany.id ?? null,
                };

                const codeInput = document.getElementById('invoice-code');
                const regenerateBtn = document.getElementById('invoice-regenerate');
                const accountSelect = document.getElementById('invoice-account-select');
                const descriptionInput = document.getElementById('invoice-item-description');
                const selectedTable = document.getElementById('invoice-selected');
                const totalField = document.getElementById('invoice-total');
                const subtotalField = document.getElementById('invoice-subtotal');
                const taxAmountField = document.getElementById('invoice-tax-amount');
                const linesField = document.getElementById('invoice-lines');
                const grandTotalLabel = document.getElementById('invoice-grand-total');
                const subtotalLabel = document.getElementById('invoice-subtotal-display');
                const taxLabel = document.getElementById('invoice-tax-display');
                const itemCountLabel = document.getElementById('invoice-item-count');
                const openButton = document.querySelector('[data-tw-target="#create-invoice-modal"]');
                const form = document.getElementById('create-invoice-form');
                const submitBtn = document.getElementById('invoice-submit');
                const modalEl = document.getElementById('create-invoice-modal');
                const companySelect = document.getElementById('invoice-company');
                const taxRateInput = document.getElementById('invoice-tax-rate');
                const companyLogoEl = document.getElementById('invoice-company-logo');
                const companyNameEl = document.getElementById('invoice-company-name');
                const companyAddressEl = document.getElementById('invoice-company-address');

                const showError = (message) => {
                    if (typeof window.showError === 'function') {
                        window.showError(message);
                    } else {
                        alert(message);
                    }
                };

                const showSuccess = (message) => {
                    if (typeof window.showSuccess === 'function') {
                        window.showSuccess(message);
                    }
                };

                const fallbackLogo = (name) => `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'Smart ERP')}&background=1D4ED8&color=fff`;

                const getCompanyData = (id) => {
                    if (!id) {
                        return null;
                    }
                    return state.companyMap.get(String(id)) || null;
                };

                const updateCompanyHero = (companyData) => {
                    const target = companyData || state.defaultCompany || {};
                    const companyName = target.name || state.defaultCompany?.name || 'Smart ERP';
                    if (companyNameEl) {
                        companyNameEl.textContent = companyName;
                    }
                    if (companyAddressEl) {
                        companyAddressEl.textContent = target.address || state.defaultCompany?.address || '';
                    }
                    if (companyLogoEl) {
                        companyLogoEl.src = target.logo_url || fallbackLogo(companyName);
                    }
                };

                const syncCompanySelection = () => {
                    if (!companySelect) {
                        updateCompanyHero();
                        return;
                    }

                    const selectedId = companySelect.value || state.defaultCompany?.id || null;
                    state.selectedCompanyId = selectedId ? String(selectedId) : null;
                    updateCompanyHero(getCompanyData(state.selectedCompanyId));
                };

                const fetchCode = () => {
                    if (!payload.routes.previewCode) return;
                    fetch(payload.routes.previewCode)
                        .then((res) => res.json())
                        .then((data) => {
                            if (codeInput) {
                                codeInput.value = data.code || codeInput.value;
                            }
                        })
                        .catch(() => {});
                };

                // Initialize account lookup
                state.accounts.forEach((account) => {
                    state.accountLookup.set(String(account.id), account);
                });

                let accountSelectInstance = null;

                const renderAccountOptions = () => {
                    if (!accountSelect) return;

                    if (!accountSelectInstance) {
                        if (accountSelect.tomselect) {
                            accountSelect.tomselect.destroy();
                        }

                        accountSelectInstance = new TomSelect(accountSelect, {
                            valueField: 'id',
                            labelField: 'name',
                            searchField: ['name', 'code'],
                            maxOptions: 1000,
                            plugins: {
                                clear_button: { title: 'Clear selection' },
                            },
                            render: {
                                option: (data) => {
                                    return `<div class="flex flex-col">
                                        <span class="font-semibold">${data.name}</span>
                                        ${data.code ? `<span class="text-xs text-slate-500">${data.code}</span>` : ''}
                                    </div>`;
                                },
                                item: (data) => {
                                    return `<div class="flex flex-col">
                                        <span class="font-semibold text-sm">${data.name}</span>
                                        ${data.code ? `<span class="text-xs text-slate-500">${data.code}</span>` : ''}
                                    </div>`;
                                },
                            },
                        });

                        accountSelectInstance.addOptions(state.accounts.map(acc => ({
                            id: String(acc.id),
                            name: acc.name,
                            code: acc.code || '',
                        })));

                        accountSelectInstance.on('change', () => {
                            const selectedId = accountSelect.value;
                            if (!selectedId) return;
                            addItem(selectedId);
                            accountSelectInstance?.clear?.();
                            if (descriptionInput) {
                                descriptionInput.value = '';
                            }
                        });
                    }
                };

                const renderSelected = () => {
                    if (!selectedTable) return;
                    selectedTable.innerHTML = '';
                    state.selected.forEach((item) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-3">
                                <p class="font-semibold">${item.account_name}</p>
                                ${item.account_code ? `<p class="text-xs text-slate-500">${item.account_code}</p>` : ''}
                            </td>
                            <td class="px-4 py-3">${item.description || '-'}</td>
                            <td class="px-4 py-3">
                                <input type="tel" inputmode="numeric" pattern="[0-9]*" min="0.001" step="0.001" value="${item.quantity}" data-qty="${item.account_id}" class="w-20 rounded-lg border border-slate-200 px-2 py-1 text-sm" />
                            </td>
                            <td class="px-4 py-3">
                                <input type="tel" inputmode="decimal" min="0" step="0.01" value="${item.unit_price}" data-price="${item.account_id}" class="w-24 rounded-lg border border-slate-200 px-2 py-1 text-sm" />
                            </td>
                            <td class="px-4 py-3 text-right" data-row-total="${item.account_id}">${state.currency}${Number(item.unit_price * item.quantity).toFixed(2)}</td>
                            <td class="px-4 py-3 text-center">
                                <button
                                    type="button"
                                    data-remove="${item.account_id}"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:text-red-600 focus:outline-none focus:ring-1 focus:ring-red-500/40"
                                >
                                    <i data-lucide="Trash2" class="h-4 w-4"></i>
                                </button>
                            </td>`;
                        selectedTable.appendChild(row);
                    });
                    updateSelectedSummary();
                    window.lucide?.createIcons?.();
                };

                const updateSelectedSummary = () => {
                    let subtotal = 0;
                    state.selected.forEach((item) => {
                        subtotal += item.unit_price * item.quantity;
                    });

                    const taxRate = parseFloat(taxRateInput?.value || 0);
                    const taxAmount = subtotal * (taxRate / 100);
                    const total = subtotal + taxAmount;

                    if (subtotalField) subtotalField.value = subtotal.toFixed(2);
                    if (taxAmountField) taxAmountField.value = taxAmount.toFixed(2);
                    if (totalField) totalField.value = total.toFixed(2);
                    
                    if (subtotalLabel) subtotalLabel.textContent = `${state.currency}${Number(subtotal).toFixed(2)}`;
                    if (taxLabel) taxLabel.textContent = `${state.currency}${Number(taxAmount).toFixed(2)}`;
                    if (grandTotalLabel) grandTotalLabel.textContent = `${state.currency}${Number(total).toFixed(2)}`;
                    
                    if (linesField) {
                        linesField.value = JSON.stringify(Array.from(state.selected.values()).map(item => ({
                            account_id: item.account_id,
                            description: item.description || '',
                            quantity: item.quantity,
                            unit_price: item.unit_price,
                        })));
                    }
                    
                    if (itemCountLabel) {
                        itemCountLabel.textContent = `${state.selected.size} item${state.selected.size === 1 ? '' : 's'}`;
                    }
                };

                const addItem = (accountId) => {
                    const account = state.accountLookup.get(String(accountId));
                    if (!account) return;
                    
                    const description = descriptionInput?.value?.trim() || '';
                    
                    if (state.selected.has(accountId)) {
                        const existing = state.selected.get(accountId);
                        existing.quantity += 1;
                        state.selected.set(accountId, existing);
                    } else {
                        state.selected.set(accountId, {
                            account_id: account.id,
                            account_code: account.code || '',
                            account_name: account.name,
                            description: description,
                            unit_price: 0,
                            quantity: 1,
                        });
                    }
                    renderSelected();
                };

                const removeItem = (accountId) => {
                    state.selected.delete(accountId);
                    renderSelected();
                };

                document.addEventListener('click', (event) => {
                    const removeBtn = event.target.closest('[data-remove]');
                    if (removeBtn) {
                        removeItem(removeBtn.getAttribute('data-remove'));
                    }
                });

                document.addEventListener('input', (event) => {
                    const qtyInput = event.target.closest('[data-qty]');
                    const priceInput = event.target.closest('[data-price]');
                    
                    if (qtyInput) {
                        const id = qtyInput.getAttribute('data-qty');
                        let numericValue = parseFloat(qtyInput.value) || 0;
                        if (numericValue < 0.001) {
                            numericValue = 0.001;
                        }
                        qtyInput.value = numericValue;
                        const value = numericValue;
                        if (state.selected.has(id)) {
                            const item = state.selected.get(id);
                            item.quantity = value;
                            state.selected.set(id, item);
                            const rowTotalCell = qtyInput.closest('tr')?.querySelector(`[data-row-total="${id}"]`);
                            if (rowTotalCell) {
                                rowTotalCell.textContent = `${state.currency}${Number(item.unit_price * item.quantity).toFixed(2)}`;
                            }
                            updateSelectedSummary();
                        }
                    }
                    
                    if (priceInput) {
                        const id = priceInput.getAttribute('data-price');
                        let numericValue = parseFloat(priceInput.value) || 0;
                        if (numericValue < 0) {
                            numericValue = 0;
                        }
                        priceInput.value = numericValue;
                        const value = numericValue;
                        if (state.selected.has(id)) {
                            const item = state.selected.get(id);
                            item.unit_price = value;
                            state.selected.set(id, item);
                            const rowTotalCell = priceInput.closest('tr')?.querySelector(`[data-row-total="${id}"]`);
                            if (rowTotalCell) {
                                rowTotalCell.textContent = `${state.currency}${Number(item.unit_price * item.quantity).toFixed(2)}`;
                            }
                            updateSelectedSummary();
                        }
                    }
                });

                if (taxRateInput) {
                    taxRateInput.addEventListener('input', () => {
                        updateSelectedSummary();
                    });
                }

                regenerateBtn?.addEventListener('click', fetchCode);

                if (companySelect) {
                    if (state.defaultCompany?.id && !companySelect.value) {
                        companySelect.value = state.defaultCompany.id;
                    }
                    companySelect.addEventListener('change', () => {
                        syncCompanySelection();
                    });
                }

                syncCompanySelection();
                fetchCode();
                renderAccountOptions();

                openButton?.addEventListener('click', () => {
                    fetchCode();
                    syncCompanySelection();
                });

                modalEl?.addEventListener('shown.tw.modal', () => {
                    fetchCode();
                });

                const submitInvoice = (event) => {
                    event.preventDefault();

                    if (!state.selected.size) {
                        showError('{{ __("invoices.errors.no_items") ?? "Please add at least one item to the invoice." }}');
                        return;
                    }

                    renderSelected();

                    const formData = new FormData(form);
                    const csrf = payload.meta?.csrf || document.querySelector("meta[name='csrf-token']")?.getAttribute('content');

                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-70');

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((response) => {
                            if (response.success) {
                                showSuccess(response.message || '{{ __("invoices.messages.created") ?? "Invoice created successfully" }}');
                                if (typeof tailwind !== 'undefined' && tailwind.Modal) {
                                    tailwind.Modal.getOrCreateInstance(modalEl)?.hide();
                                }
                                form.reset();
                                state.selected.clear();
                                renderSelected();
                                if (window.table) {
                                    window.table.ajax.reload();
                                }
                                if (companySelect) {
                                    if (state.defaultCompany?.id) {
                                        companySelect.value = state.defaultCompany.id;
                                    }
                                    syncCompanySelection();
                                }
                            } else {
                                const errors = response.errors ? Object.values(response.errors).flat().join('\n') : null;
                                showError(errors || response.message || '{{ __("invoices.errors.create_failed") ?? "Failed to create invoice." }}');
                            }
                        })
                        .catch(() => showError('{{ __("invoices.errors.unexpected") ?? "Unexpected error while creating the invoice." }}'))
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-70');
                        });
                };

                form?.addEventListener('submit', submitInvoice);

                renderSelected();
                setTimeout(() => {
                    window.dispatchEvent(new Event('invoice:modal-ready'));
                }, 0);
            };

            // Wait for modal to be in DOM before initializing
            const checkModal = () => {
                if (document.getElementById('create-invoice-modal')) {
                    init();
                } else {
                    setTimeout(checkModal, 100);
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', checkModal);
            } else {
                checkModal();
            }
        })();
    </script>

</x-modal.form>
