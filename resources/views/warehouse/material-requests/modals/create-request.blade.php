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

        <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
            <div class="flex flex-wrap items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
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

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                <div class="border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <h4 class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-100">
                        <x-base.lucide icon="Info" class="h-4 w-4" />
                        Request Details
                    </h4>
                </div>
                <div class="grid grid-cols-12 gap-2 px-5 py-4 text-sm">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-code">Request Code</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="material-request-code"
                                name="code"
                                type="text"
                                class="w-full text-sm"
                                readonly
                                placeholder="AUTO"
                            />
                            <x-base.button type="button" variant="outline-secondary" class="shrink-0" id="material-request-regenerate">
                                <x-base.lucide icon="RefreshCcw" class="h-4 w-4" />
                            </x-base.button>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-company">Company</x-base.form-label>
                        <x-base.form-select
                            id="material-request-company"
                            name="company_id"
                            required
                            class="text-sm"
                        >
                            <option value="">Select company</option>
                            @foreach ($companies as $companyOption)
                                <option value="{{ $companyOption->id }}" @selected(($defaultCompanyId ?? null) === $companyOption->id)>
                                    {{ $companyOption->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-title">Title</x-base.form-label>
                        <x-base.form-input
                            id="material-request-title"
                            name="title"
                            type="text"
                            required
                            class="text-sm"
                            placeholder="Ex: Monthly Clinic Supplies"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-date">Request Date</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="material-request-date"
                                name="request_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-priority">Priority</x-base.form-label>
                        <x-base.form-select id="material-request-priority" name="priority" class="text-sm">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="material-request-approval-template">Approval Template</x-base.form-label>
                        <x-base.form-select id="material-request-approval-template" name="approval_template_id" required class="text-sm">
                            <option value="">Select approval template</option>
                            @foreach ($approvalTemplates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-12">
                        <x-base.form-label for="material-request-description">Notes</x-base.form-label>
                        <x-base.form-textarea
                            id="material-request-description"
                            name="description"
                            rows="3"
                            class="text-sm"
                            placeholder="Context, instructions, or receiving details..."
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                <div class="border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-start justify-between gap-2 text-sm">
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">Select Materials</h4>
                            <p class="text-xs text-slate-500">Choose warehouse, catalog, and sub catalog to load materials.</p>
                        </div>
                        <div class="grid grid-cols-12 gap-2 text-sm">
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="material-request-warehouse">Warehouse</x-base.form-label>
                                <x-base.form-select id="material-request-warehouse" name="warehouse_id" required class="text-sm">
                                    <option value="">Select warehouse</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }} — {{ $warehouse->location }}</option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 md:col-span-3" data-catalog-control="catalog">
                                <x-base.form-label for="material-request-catalog">Catalog</x-base.form-label>
                                <x-base.form-select id="material-request-catalog" class="text-sm">
                                    <option value="">Select catalog</option>
                                    @foreach ($categories as $catalog)
                                        @php
                                            $childOptions = $catalog->children->map(fn ($child) => [
                                                'id' => $child->id,
                                                'name' => $child->name,
                                            ])->values();
                                        @endphp
                                        <option
                                            value="{{ $catalog->id }}"
                                            data-children='@json($childOptions)'
                                        >
                                            {{ $catalog->name }}
                                        </option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 md:col-span-3" data-catalog-control="sub">
                                <x-base.form-label for="material-request-sub-catalog">Sub Catalog</x-base.form-label>
                                <x-base.form-select id="material-request-sub-catalog" disabled class="text-sm">
                                    <option value="">Select sub catalog</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 md:col-span-3" data-catalog-control="material">
                                <x-base.form-label for="material-request-material-select">Materials</x-base.form-label>
                                <x-base.tom-select id="material-request-material-select" data-placeholder="Search materials" class="text-sm" disabled>
                                    <option value="">Select material</option>
                                </x-base.tom-select>
                                <div class="mt-2">
                                    <x-base.form-input id="material-request-material-filter" type="text" placeholder="Type to search..." class="w-full text-sm" disabled />
                                </div>
                                <div id="material-request-material-template" class="hidden">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 overflow-hidden rounded-lg bg-slate-100">
                                            <img src="" alt="Material" class="h-full w-full object-cover" loading="lazy" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-700"></p>
                                            <p class="text-xs text-slate-500"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-5 pb-4 text-sm">
                    <div class="text-xs text-slate-500">
                        Use the filters above, then type inside the material list to search and add items.
                    </div>
                    <div id="material-request-material-loader" class="mt-4 flex items-center gap-2 text-xs text-slate-500 hidden">
                        <x-base.lucide icon="Loader" class="h-4 w-4 animate-spin" />
                        Fetching materials...
                    </div>
                    <p class="mt-3 text-xs text-slate-500" id="material-request-material-notice">Select warehouse, catalog, and sub catalog to enable the material list.</p>
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
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button
                type="button"
                class="btn-royal btn-royal--outline group"
                data-tw-dismiss="modal"
            >
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button
                type="submit"
                form="material-request-form"
                id="material-request-submit"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Submit Request
            </button>
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
                    materials: [],
                    materialLookup: new Map(),
                    selected: new Map(),
                    currency: payload.data.currencySymbol || '{{ $currencySymbol ?? '$' }}',
                    companyMap,
                    defaultCompany,
                    selectedCompanyId: defaultCompany.id ?? null,
                    catalogs: payload.data.catalogs || [],
                    catalogChildrenMap: new Map((payload.data.catalogs || []).map((catalog) => [String(catalog.id), catalog.children || []])),
                    selectedWarehouseId: null,
                    selectedCatalogId: null,
                    selectedSubCatalogId: null,
                    isLoading: false,
                };

                const codeInput = document.getElementById('material-request-code');
                const titleInput = document.getElementById('material-request-title');
                const regenerateBtn = document.getElementById('material-request-regenerate');
                const warehouseSelect = document.getElementById('material-request-warehouse');
                const catalogSelect = document.getElementById('material-request-catalog');
                const subCatalogSelect = document.getElementById('material-request-sub-catalog');
                const materialSelect = document.getElementById('material-request-material-select');
                const materialTemplate = document.getElementById('material-request-material-template');
                const materialFilterInput = document.getElementById('material-request-material-filter');
                const fallbackMaterialImage = payload.meta?.materialPlaceholder || 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><rect width="80" height="80" fill="#e2e8f0"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#94a3b8" font-family="Arial" font-size="10">No Image</text></svg>');
                const loaderEl = document.getElementById('material-request-material-loader');
                const noticeEl = document.getElementById('material-request-material-notice');
                const selectedTable = document.getElementById('material-request-selected');
                const totalField = document.getElementById('material-request-total');
                const itemsField = document.getElementById('material-request-items');
                const grandTotalLabel = document.getElementById('material-request-grand-total');
                const itemCountLabel = document.getElementById('material-request-item-count');
                const openButton = document.getElementById('create-material-request-button');
                const form = document.getElementById('material-request-form');
                const submitBtn = document.getElementById('material-request-submit');
                const modalEl = document.getElementById('material-request-modal');
                const companySelect = document.getElementById('material-request-company');
                const templateSelect = document.getElementById('material-request-approval-template');
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

                const canQueryMaterials = () => {
                    return state.selectedWarehouseId && state.selectedCatalogId;
                };

                const resetMaterialResults = () => {
                    state.materials = [];
                    state.materialLookup.clear();
                    if (materialSelect?.tomselect) {
                        materialSelect.tomselect.clearOptions();
                        materialSelect.tomselect.clear();
                        materialSelect.tomselect.disable();
                    } else if (materialSelect) {
                        materialSelect.innerHTML = '<option value="">Select material</option>';
                        materialSelect.disabled = true;
                    }
                    if (materialFilterInput) {
                        materialFilterInput.value = '';
                        materialFilterInput.disabled = true;
                    }
                };

                const toggleLoader = (show) => {
                    state.isLoading = !!show;
                    loaderEl?.classList.toggle('hidden', !show);
                };

                const updateNotice = () => {
                    if (!noticeEl) return;
                    if (!canQueryMaterials()) {
                        noticeEl.textContent = 'Select warehouse, catalog, and sub catalog to view materials.';
                        noticeEl.hidden = false;
                    } else if (state.isLoading) {
                        noticeEl.hidden = true;
                    } else if (!state.materials.length) {
                        noticeEl.textContent = 'No materials found for the selected filters.';
                        noticeEl.hidden = false;
                    } else {
                        noticeEl.hidden = true;
                    }
                };

                let materialSelectInstance = null;

                const renderMaterialOptions = () => {
                    if (!materialSelect) return;

                    const previousValue = materialSelectInstance?.getValue?.() || '';

                    if (!materialSelectInstance) {
                        if (materialSelect.tomselect) {
                            materialSelect.tomselect.destroy();
                        }

                        materialSelectInstance = new TomSelect(materialSelect, {
                            valueField: 'id',
                            labelField: 'name',
                            searchField: ['name', 'code'],
                            maxOptions: 1000,
                            plugins: {
                                clear_button: { title: 'Clear selection' },
                            },
                            render: {
                                option: (data) => {
                                    const template = materialTemplate?.firstElementChild?.cloneNode(true);
                                    if (!template) {
                                        return `<div>
                                            <div class="flex flex-col">
                                                <span class="font-semibold">${data.name}</span>
                                                <span class="text-xs text-slate-500">${data.code}</span>
                                            </div>
                                        </div>`;
                                    }

                                    const img = template.querySelector('img');
                                    if (img) {
                                        img.src = data.image_url || fallbackMaterialImage;
                                    }
                                    const title = template.querySelector('p.text-sm');
                                    if (title) {
                                        title.textContent = data.name;
                                    }
                                    const subtitle = template.querySelector('p.text-xs');
                                    if (subtitle) {
                                        subtitle.textContent = `${data.code || 'No code'} · ${state.currency}${Number(data.price || 0).toFixed(2)}`;
                                    }

                                    return template.outerHTML;
                                },
                                item: (data) => {
                                    return `<div class="flex flex-col">
                                        <span class="font-semibold text-sm">${data.name}</span>
                                        <span class="text-xs text-slate-500">${data.code}</span>
                                    </div>`;
                                },
                            },
                        });

                        const selectInstance = materialSelectInstance;
                        materialSelect.addEventListener('change', () => {
                            const selectedId = materialSelect.value;
                            if (!selectedId) return;
                            addMaterial(selectedId);
                            selectInstance?.clear?.();
                        });

                        if (materialFilterInput) {
                            materialFilterInput.addEventListener('input', (event) => {
                                const keyword = (event.target.value || '').trim();
                                selectInstance?.setTextboxValue(keyword);
                                selectInstance?.refreshOptions(keyword.length > 0);
                            });
                        }
                    }

                    const mapped = state.materials.map((material) => ({
                        id: String(material.id),
                        name: material.name,
                        code: material.code,
                        price: material.price,
                        image_url: material.image_url,
                    }));

                    if (materialSelectInstance) {
                        materialSelectInstance.clearOptions();
                        materialSelectInstance.addOptions(mapped);
                        materialSelectInstance.refreshOptions(false);
                        if (previousValue) {
                            materialSelectInstance.setValue(previousValue, true);
                        }

                        const hasMaterials = !!state.materials.length;
                        if (hasMaterials) {
                            materialSelectInstance.enable();
                            materialFilterInput && (materialFilterInput.disabled = false);
                        } else {
                            materialSelectInstance.disable();
                            if (materialFilterInput) {
                                materialFilterInput.value = '';
                                materialFilterInput.disabled = true;
                            }
                        }
                    }
                };

                const fetchMaterials = (append = false, page = 1) => {
                    if (!payload.routes.materials || !canQueryMaterials()) {
                        resetMaterialResults();
                        updateNotice();
                        return;
                    }

                    toggleLoader(true);
                    const params = new URLSearchParams({
                        warehouse_id: state.selectedWarehouseId,
                        catalog_id: state.selectedCatalogId,
                        page: page.toString(),
                    });

                    if (state.selectedSubCatalogId) {
                        params.append('sub_catalog_id', state.selectedSubCatalogId);
                    }

                    fetch(`${payload.routes.materials}?${params.toString()}`)
                        .then((res) => res.json())
                        .then((response) => {
                            if (!response.success) {
                                throw new Error(response.message || 'Failed to fetch materials');
                            }

                            const items = response.data?.items || [];
                            if (append) {
                                state.materials = state.materials.concat(items);
                            } else {
                                state.materials = items;
                            }

                            items.forEach((item) => {
                                state.materialLookup.set(String(item.id), item);
                            });

                            renderMaterialOptions();
                        })
                        .catch((error) => {
                            console.error(error);
                            showError('Unable to load materials.');
                        })
                        .finally(() => {
                            toggleLoader(false);
                            updateNotice();
                        });
                };

                const renderSelected = () => {
                    selectedTable.innerHTML = '';
                    state.selected.forEach((item) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-3">
                                <p class="font-semibold">${item.name}</p>
                                <p class="text-xs text-slate-500">${item.code}</p>
                            </td>
                            <td class="px-4 py-3">${item.unit || item.unit_symbol || '-'}</td>
                            <td class="px-4 py-3">
                                <input type="tel" inputmode="numeric" pattern="[0-9]*" min="1" step="1" value="${item.quantity}" data-qty="${item.material_id}" class="w-20 rounded-lg border border-slate-200 px-2 py-1 text-sm" />
                            </td>
                            <td class="px-4 py-3">${state.currency}${Number(item.unit_price).toFixed(2)}</td>
                            <td class="px-4 py-3 text-right" data-row-total="${item.material_id}">${state.currency}${Number(item.unit_price * item.quantity).toFixed(2)}</td>
                            <td class="px-4 py-3 text-center">
                                <button
                                    type="button"
                                    data-remove="${item.material_id}"
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
                    let total = 0;
                    state.selected.forEach((item) => {
                        total += item.unit_price * item.quantity;
                    });

                    totalField.value = total.toFixed(2);
                    grandTotalLabel.textContent = `${state.currency}${Number(total).toFixed(2)}`;
                    itemsField.value = JSON.stringify(Array.from(state.selected.values()));
                    itemCountLabel.textContent = `${state.selected.size} item${state.selected.size === 1 ? '' : 's'}`;
                };

                const addMaterial = (id) => {
                    const material = state.materialLookup.get(String(id));
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
                    const removeBtn = event.target.closest('[data-remove]');
                    if (removeBtn) {
                        removeMaterial(removeBtn.getAttribute('data-remove'));
                    }
                });

                document.addEventListener('input', (event) => {
                    const qtyInput = event.target.closest('[data-qty]');
                    if (qtyInput) {
                        const id = qtyInput.getAttribute('data-qty');
                        let numericValue = qtyInput.value.replace(/[^0-9]/g, '');
                        if (!numericValue) {
                            numericValue = '1';
                        }
                        qtyInput.value = numericValue;
                        const value = Math.max(1, Number(numericValue) || 1);
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
                });

                const handleWarehouseChange = () => {
                    state.selectedWarehouseId = warehouseSelect?.value || null;
                    triggerMaterialFetch();
                };

                const getChildrenFromOption = (catalogId) => {
                    if (!catalogSelect || !catalogId) {
                        return [];
                    }
                    const selectedOption = catalogSelect.querySelector(`option[value="${catalogId}"]`);
                    if (!selectedOption || !selectedOption.dataset.children) {
                        return [];
                    }
                    try {
                        return JSON.parse(selectedOption.dataset.children) || [];
                    } catch (error) {
                        return [];
                    }
                };

                const resolveSubCatalogs = (catalogId) => {
                    if (!catalogId) {
                        return [];
                    }
                    const mapKey = String(catalogId);
                    let children = state.catalogChildrenMap.get(mapKey);

                    if (!children || !children.length) {
                        const catalogFromState = (state.catalogs || []).find((catalog) => String(catalog.id) === mapKey);
                        if (catalogFromState && Array.isArray(catalogFromState.children) && catalogFromState.children.length) {
                            children = catalogFromState.children;
                        }
                    }

                    if (!children || !children.length) {
                        children = getChildrenFromOption(mapKey);
                    }

                    if (children && children.length) {
                        state.catalogChildrenMap.set(mapKey, children);
                        return children;
                    }

                    return [];
                };

                const fetchSubCatalogs = (catalogId) => {
                    return new Promise((resolve) => {
                        if (!catalogId || !payload.routes.categoryChildren) {
                            return resolve([]);
                        }

                        fetch(`${payload.routes.categoryChildren}?parent_id=${catalogId}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                        })
                            .then((res) => {
                                if (!res.ok) {
                                    throw new Error('Failed to load sub catalogs');
                                }
                                return res.json();
                            })
                            .then((data) => {
                                if (Array.isArray(data) && data.length) {
                                    state.catalogChildrenMap.set(String(catalogId), data);
                                    resolve(data);
                                } else {
                                    resolve([]);
                                }
                            })
                            .catch(() => resolve([]));
                    });
                };

                const populateSubCatalogs = async () => {
                    if (!subCatalogSelect) return;
                    const catalogId = state.selectedCatalogId;
                    let children = resolveSubCatalogs(catalogId);
                    if ((!children || !children.length) && catalogId) {
                        children = await fetchSubCatalogs(catalogId);
                    }
                    subCatalogSelect.innerHTML = '<option value="">Select sub catalog</option>';
                    children.forEach((child) => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.name;
                        subCatalogSelect.appendChild(option);
                    });
                    if (children.length) {
                        subCatalogSelect.disabled = false;
                        subCatalogSelect.removeAttribute('disabled');
                    } else {
                        subCatalogSelect.disabled = true;
                        subCatalogSelect.setAttribute('disabled', 'disabled');
                    }
                    if (!children.length) {
                        state.selectedSubCatalogId = null;
                        subCatalogSelect.value = '';
                    } else if (state.selectedSubCatalogId) {
                        subCatalogSelect.value = state.selectedSubCatalogId;
                    }
                };

                const handleCatalogChange = async () => {
                    state.selectedCatalogId = catalogSelect?.value || null;
                    state.selectedSubCatalogId = null;
                    await populateSubCatalogs();
                    triggerMaterialFetch();
                };

                const handleSubCatalogChange = () => {
                    state.selectedSubCatalogId = subCatalogSelect?.value || null;
                    triggerMaterialFetch();
                };

                const triggerMaterialFetch = () => {
                    const enabled = canQueryMaterials();
                    resetMaterialResults();
                    updateNotice();
                    if (enabled) {
                        fetchMaterials(false, 1);
                    }
                };

                warehouseSelect?.addEventListener('change', handleWarehouseChange);
                catalogSelect?.addEventListener('change', handleCatalogChange);
                subCatalogSelect?.addEventListener('change', handleSubCatalogChange);

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
                fetchCode();

                openButton?.addEventListener('click', () => {
                    fetchCode();
                    syncCompanySelection();
                    titleInput.focus();
                });

                modalEl?.addEventListener('shown.tw.modal', () => {
                    fetchCode();
                });

                const submitRequest = (event) => {
                    event.preventDefault();

                    if (!state.selected.size) {
                        showError('Please add at least one material to the request.');
                        return;
                    }

                    if (templateSelect && !templateSelect.value) {
                        showError('Please select an approval template.');
                        templateSelect.focus();
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

                renderSelected();
                updateNotice();
                setTimeout(() => {
                    window.dispatchEvent(new Event('material-request:modal-ready'));
                }, 0);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

</x-modal.form>
