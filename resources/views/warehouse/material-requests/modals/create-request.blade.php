@php
    $heroCompanyName = $defaultCompanyName ?? 'Smart ERP';
    $heroCompanyAddress = $defaultCompanyAddress ?? 'Select the warehouse items needed for fulfillment.';
    $heroCompanyLogo = $defaultCompanyLogo
        ?? 'https://ui-avatars.com/api/?name=' . urlencode($heroCompanyName)
        . '&background=1D4ED8&color=fff';
@endphp

<x-modal.form id="material-request-modal" size="xxl" title="New Material Request">
    <form id="material-request-form" action="{{ route('warehouse.material-requests.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="total_amount" id="material-request-total" value="0">
        <input type="hidden" name="items" id="material-request-items" value="[]">
        <input type="hidden" name="status" value="pending">

        <div class="flex flex-col gap-4 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-5 dark:border-darkmode-400 dark:bg-darkmode-600/30">
            <div class="flex flex-wrap items-center gap-4">
                <div class="h-16 w-16 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                    <img
                        id="material-request-company-logo"
                        src="{{ $heroCompanyLogo }}"
                        alt="{{ $heroCompanyName }} Logo"
                        class="h-full w-full object-cover"
                    >
                </div>
                <div class="flex-1 min-w-[200px]">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Material Request</p>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100" id="material-request-company-name">
                        {{ $heroCompanyName }}
                    </h3>
                    <p class="text-sm text-slate-500" id="material-request-company-address">
                        {{ $heroCompanyAddress }}
                    </p>
                </div>
                <div class="text-right text-sm text-slate-500">
                    <p>Currency</p>
                    <p class="text-base font-semibold text-slate-700">{{ $currencySymbol ?? config('app.currency_symbol', '$') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-5 space-y-5">
                <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                    <div class="border-b border-slate-200/60 px-6 py-4 dark:border-darkmode-400">
                        <h4 class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-100">
                            <x-base.lucide icon="Info" class="h-4 w-4" />
                            Request Details
                        </h4>
                    </div>
                    <div class="grid grid-cols-12 gap-4 px-6 py-5">
                        <div class="col-span-12">
                            <x-base.form-label for="material-request-company">Company</x-base.form-label>
                            <x-base.form-select
                                id="material-request-company"
                                name="company_id"
                                required
                            >
                                <option value="">Select company</option>
                                @foreach ($companies as $companyOption)
                                    <option value="{{ $companyOption->id }}" @selected(($defaultCompanyId ?? null) === $companyOption->id)>
                                        {{ $companyOption->name }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="material-request-code">Request Code</x-base.form-label>
                            <div class="flex gap-2">
                                <x-base.form-input
                                    id="material-request-code"
                                    name="code"
                                    type="text"
                                    class="w-full"
                                    readonly
                                    placeholder="AUTO"
                                />
                                <x-base.button type="button" variant="outline-secondary" class="shrink-0" id="material-request-regenerate">
                                    <x-base.lucide icon="RefreshCcw" class="h-4 w-4" />
                                </x-base.button>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="material-request-title">Title</x-base.form-label>
                            <x-base.form-input
                                id="material-request-title"
                                name="title"
                                type="text"
                                required
                                placeholder="Ex: Monthly Clinic Supplies"
                            />
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="material-request-date">Request Date</x-base.form-label>
                            <x-base.form-input
                                id="material-request-date"
                                name="request_date"
                                type="date"
                                required
                                value="{{ now()->format('Y-m-d') }}"
                            />
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <x-base.form-label for="material-request-priority">Priority</x-base.form-label>
                            <x-base.form-select id="material-request-priority" name="priority">
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="material-request-warehouse">Warehouse</x-base.form-label>
                            <x-base.form-select id="material-request-warehouse" name="warehouse_id" required>
                                <option value="">Select warehouse</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }} — {{ $warehouse->location }}</option>
                                @endforeach
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="material-request-description">Notes</x-base.form-label>
                            <x-base.form-textarea
                                id="material-request-description"
                                name="description"
                                rows="3"
                                placeholder="Context, instructions, or receiving details..."
                            ></x-base.form-textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 xl:col-span-7 space-y-5">
                <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                    <div class="border-b border-slate-200/60 px-6 py-4 dark:border-darkmode-400">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">Select Materials</h4>
                            <div class="flex gap-2">
                                <x-base.form-select id="material-category-filter" class="min-w-[160px]">
                                    <option value="all">All Categories</option>
                                    @foreach ($materialCategories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </x-base.form-select>
                                <div class="relative">
                                    <x-base.lucide icon="Search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                                    <x-base.form-input id="material-search" type="text" placeholder="Search materials" class="pl-9" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex rounded-full border border-slate-200 dark:border-darkmode-400 overflow-hidden">
                            <button type="button" class="flex-1 px-4 py-2.5 text-sm font-semibold transition data-[active=true]:bg-primary/10 data-[active=true]:text-primary" data-tab="warehouse" data-active="true">
                                Warehouse Inventory
                            </button>
                            <button type="button" class="flex-1 px-4 py-2.5 text-sm font-semibold transition data-[active=true]:bg-primary/10 data-[active=true]:text-primary" data-tab="catalog">
                                Catalog
                            </button>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <div id="material-tab-warehouse" class="space-y-3" data-tab-panel="warehouse">
                            <div id="warehouse-material-list" class="grid grid-cols-12 gap-3"></div>
                            <p class="text-xs text-slate-500" id="warehouse-material-empty" hidden>No materials match your search.</p>
                        </div>
                        <div id="material-tab-catalog" class="hidden space-y-3" data-tab-panel="catalog">
                            <div id="catalog-material-list" class="grid grid-cols-12 gap-3"></div>
                            <p class="text-xs text-slate-500" id="catalog-material-empty" hidden>No catalog items available.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
            <div class="flex items-center justify-between border-b border-slate-200/60 pb-4 dark:border-darkmode-400">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">Selected Items</h4>
                <span class="text-xs text-slate-500" id="material-request-item-count">0 items</span>
            </div>
            <div class="overflow-x-auto">
                <table class="mt-4 w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-2">Material</th>
                            <th class="px-4 py-2">Unit</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Unit Price</th>
                            <th class="px-4 py-2 text-right">Total</th>
                            <th class="px-4 py-2 text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody id="material-request-selected" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <div class="text-xs text-slate-500">Update quantities directly in the table. Totals update automatically.</div>
                <div class="text-right">
                    <p class="text-xs uppercase text-slate-500">Grand Total</p>
                    <p class="text-2xl font-semibold text-slate-800">
                        <span id="material-request-grand-total">{{ $currencySymbol ?? '$' }}0.00</span>
                    </p>
                </div>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex flex-wrap justify-end gap-2 w-full">
            <x-base.button type="button" variant="outline-secondary" class="btn-tonal btn-tonal--warning" data-tw-dismiss="modal">
                Cancel
            </x-base.button>
            <x-base.button type="submit" id="material-request-submit" class="btn-tonal btn-tonal--success" form="material-request-form">
                Submit Request
            </x-base.button>
        </div>
    </x-slot>

    <script>
        (() => {
            const init = () => {
                if (window.__materialRequestModalInitialized) {
                    return;
                }

                const payload = window.materialRequestPayload;
                if (!payload) {
                    console.warn('materialRequestPayload missing');
                    return;
                }

                window.__materialRequestModalInitialized = true;

                const companies = payload.data.companies || [];
                const defaultCompany = payload.data.defaultCompany || {};
                const companyMap = new Map(companies.map((company) => [String(company.id), company]));

                const state = {
                    tab: 'warehouse',
                    materials: payload.data.materials || [],
                    selected: new Map(),
                    currency: payload.data.currencySymbol || '{{ $currencySymbol ?? '$' }}',
                    companyMap,
                    defaultCompany,
                    selectedCompanyId: defaultCompany.id ?? null,
                };

                const codeInput = document.getElementById('material-request-code');
                const titleInput = document.getElementById('material-request-title');
                const regenerateBtn = document.getElementById('material-request-regenerate');
                const categoryFilter = document.getElementById('material-category-filter');
                const searchInput = document.getElementById('material-search');
                const warehouseList = document.getElementById('warehouse-material-list');
                const warehouseEmpty = document.getElementById('warehouse-material-empty');
                const catalogList = document.getElementById('catalog-material-list');
                const catalogEmpty = document.getElementById('catalog-material-empty');
                const selectedTable = document.getElementById('material-request-selected');
                const totalField = document.getElementById('material-request-total');
                const itemsField = document.getElementById('material-request-items');
                const grandTotalLabel = document.getElementById('material-request-grand-total');
                const itemCountLabel = document.getElementById('material-request-item-count');
                const tabButtons = document.querySelectorAll('[data-tab]');
                const panels = document.querySelectorAll('[data-tab-panel]');
                const openButton = document.getElementById('create-material-request-button');
                const form = document.getElementById('material-request-form');
                const submitBtn = document.getElementById('material-request-submit');
                const modalEl = document.getElementById('material-request-modal');
                const companySelect = document.getElementById('material-request-company');
                const companyLogoEl = document.getElementById('material-request-company-logo');
                const companyNameEl = document.getElementById('material-request-company-name');
                const companyAddressEl = document.getElementById('material-request-company-address');

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
                        companyAddressEl.textContent = target.address || state.defaultCompany?.address || 'Select the warehouse items needed for fulfillment.';
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
                            codeInput.value = data.code || codeInput.value;
                        })
                        .catch(() => {});
                };

                const filteredMaterials = () => {
                    const keyword = (searchInput.value || '').toLowerCase();
                    const category = categoryFilter.value;
                    return state.materials.filter((material) => {
                        const matchesCategory = category === 'all' || !category ? true : String(material.category_id) === category;
                        const matchesKeyword = keyword
                            ? (material.name || '').toLowerCase().includes(keyword) || (material.code || '').toLowerCase().includes(keyword)
                            : true;
                        return matchesCategory && matchesKeyword;
                    });
                };

                const renderMaterialCards = () => {
                    const list = state.tab === 'warehouse' ? warehouseList : catalogList;
                    const emptyNotice = state.tab === 'warehouse' ? warehouseEmpty : catalogEmpty;
                    list.innerHTML = '';
                    const materials = filteredMaterials();
                    if (!materials.length) {
                        emptyNotice.hidden = false;
                        return;
                    }
                    emptyNotice.hidden = true;
                    materials.forEach((material) => {
                        const card = document.createElement('div');
                        card.className = 'col-span-12 md:col-span-6 xl:col-span-4';
                        card.innerHTML = `
                            <div class="flex h-full flex-col rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4 shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                                <div class="flex-1">
                                    <p class="text-xs uppercase tracking-wide text-slate-400">${material.code || 'Material'}</p>
                                    <p class="mt-1 font-semibold text-slate-800 dark:text-slate-50">${material.name}</p>
                                    <p class="text-xs text-slate-500">${material.unit || 'Unit'} · ${state.currency}${Number(material.price || 0).toFixed(2)}</p>
                                </div>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">${material.category_name || 'Uncategorized'}</span>
                                    <button type="button" class="btn-tonal btn-tonal--primary btn-tonal--sm" data-add-material="${material.id}">
                                        <x-base.lucide icon="Plus" class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>`;
                        list.appendChild(card);
                    });
                };

                const renderSelected = () => {
                    selectedTable.innerHTML = '';
                    let total = 0;
                    state.selected.forEach((item) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-3">
                                <p class="font-semibold">${item.name}</p>
                                <p class="text-xs text-slate-500">${item.code}</p>
                            </td>
                            <td class="px-4 py-3">${item.unit || '-'}</td>
                            <td class="px-4 py-3">
                                <input type="number" min="1" step="1" value="${item.quantity}" data-qty="${item.material_id}" class="w-20 rounded-lg border border-slate-200 px-2 py-1 text-sm" />
                            </td>
                            <td class="px-4 py-3">${state.currency}${Number(item.unit_price).toFixed(2)}</td>
                            <td class="px-4 py-3 text-right">${state.currency}${Number(item.unit_price * item.quantity).toFixed(2)}</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" data-remove="${item.material_id}" class="text-danger">
                                    <x-base.lucide icon="Trash2" class="h-4 w-4" />
                                </button>
                            </td>`;
                        selectedTable.appendChild(row);
                        total += item.unit_price * item.quantity;
                    });
                    totalField.value = total.toFixed(2);
                    grandTotalLabel.textContent = `${state.currency}${Number(total).toFixed(2)}`;
                    itemsField.value = JSON.stringify(Array.from(state.selected.values()));
                    itemCountLabel.textContent = `${state.selected.size} item${state.selected.size === 1 ? '' : 's'}`;
                };

                const addMaterial = (id) => {
                    const material = state.materials.find((m) => String(m.id) === String(id));
                    if (!material) return;
                    if (state.selected.has(id)) {
                        const existing = state.selected.get(id);
                        existing.quantity += 1;
                        state.selected.set(id, existing);
                    } else {
                        state.selected.set(id, {
                            material_id: material.id,
                            code: material.code,
                            name: material.name,
                            unit: material.unit,
                            unit_price: Number(material.price || 0),
                            quantity: 1,
                        });
                    }
                    renderSelected();
                };

                const removeMaterial = (id) => {
                    state.selected.delete(id);
                    renderSelected();
                };

                document.addEventListener('click', (event) => {
                    const addBtn = event.target.closest('[data-add-material]');
                    if (addBtn) {
                        addMaterial(addBtn.getAttribute('data-add-material'));
                    }
                    const removeBtn = event.target.closest('[data-remove]');
                    if (removeBtn) {
                        removeMaterial(removeBtn.getAttribute('data-remove'));
                    }
                });

                document.addEventListener('input', (event) => {
                    const qtyInput = event.target.closest('[data-qty]');
                    if (qtyInput) {
                        const id = qtyInput.getAttribute('data-qty');
                        const value = Math.max(1, Number(qtyInput.value) || 1);
                        if (state.selected.has(id)) {
                            const item = state.selected.get(id);
                            item.quantity = value;
                            state.selected.set(id, item);
                            renderSelected();
                        }
                    }
                });

                tabButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        state.tab = button.getAttribute('data-tab');
                        tabButtons.forEach((btn) => btn.dataset.active = btn === button);
                        panels.forEach((panel) => {
                            panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== state.tab);
                        });
                        renderMaterialCards();
                    });
                });

                [categoryFilter, searchInput].forEach((el) => {
                    el.addEventListener('input', () => renderMaterialCards());
                });

                regenerateBtn.addEventListener('click', fetchCode);

                if (companySelect) {
                    if (state.defaultCompany?.id && !companySelect.value) {
                        companySelect.value = state.defaultCompany.id;
                    }
                    companySelect.addEventListener('change', () => {
                        syncCompanySelection();
                    });
                }

                syncCompanySelection();

                openButton?.addEventListener('click', () => {
                    fetchCode();
                    syncCompanySelection();
                    titleInput.focus();
                    renderMaterialCards();
                });

                const submitRequest = (event) => {
                    event.preventDefault();

                    if (!state.selected.size) {
                        showError('Please add at least one material to the request.');
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
                                showSuccess(response.message || 'Request submitted successfully');
                                if (typeof tailwind !== 'undefined' && tailwind.Modal) {
                                    tailwind.Modal.getOrCreateInstance(modalEl)?.hide();
                                }
                                form.reset();
                                state.selected.clear();
                                renderSelected();
                                renderMaterialCards();
                                window.materialRequestsTable?.ajax.reload();
                                if (companySelect) {
                                    if (state.defaultCompany?.id) {
                                        companySelect.value = state.defaultCompany.id;
                                    }
                                    syncCompanySelection();
                                }
                            } else {
                                const errors = response.errors ? Object.values(response.errors).flat().join('\n') : null;
                                showError(errors || response.message || 'Failed to submit material request.');
                            }
                        })
                        .catch(() => showError('Unexpected error while submitting the request.'))
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('opacity-70');
                        });
                };

                form?.addEventListener('submit', submitRequest);

                renderMaterialCards();
                renderSelected();
            };

            window.addEventListener('material-request:payload-ready', init, { once: true });
        })();
    </script>
</x-modal.form>
