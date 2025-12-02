@php
    $heroCompanyName = $defaultCompanyName ?? 'Smart ERP';
    $heroCompanyAddress = $defaultCompanyAddress ?? 'Prepare and ship the requested items.';
    $heroCompanyLogo = $defaultCompanyLogo
        ?? 'https://ui-avatars.com/api/?name=' . urlencode($heroCompanyName)
        . '&background=1D4ED8&color=fff';
@endphp

<x-modal.form id="create-do-modal" size="xxl" title="New Delivery Order">
    <form id="delivery-order-form" action="{{ route('warehouse.delivery-orders.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="total_amount" id="delivery-order-total" value="0">
        <input type="hidden" name="items" id="delivery-order-items" value="[]">
        <input type="hidden" name="status" value="pending">

        <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
            <div class="flex flex-wrap items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                    <img
                        id="delivery-order-company-logo"
                        src="{{ $heroCompanyLogo }}"
                        alt="{{ $heroCompanyName }} Logo"
                        class="h-full w-full object-cover"
                    >
                </div>
                <div class="flex-1 min-w-[200px]">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Delivery Order</p>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100" id="delivery-order-company-name">
                        {{ $heroCompanyName }}
                    </h3>
                    <p class="text-sm text-slate-500" id="delivery-order-company-address">
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
                        Order Details
                    </h4>
                </div>
                <div class="grid grid-cols-12 gap-2 px-5 py-4 text-sm">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-code">Order Code</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="delivery-order-code"
                                name="code"
                                type="text"
                                class="w-full text-sm"
                                readonly
                                placeholder="AUTO"
                            />
                            <x-base.button type="button" variant="outline-secondary" class="shrink-0" id="delivery-order-regenerate">
                                <x-base.lucide icon="RefreshCcw" class="h-4 w-4" />
                            </x-base.button>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-company">Company</x-base.form-label>
                        <x-base.form-select
                            id="delivery-order-company"
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
                        <x-base.form-label for="delivery-order-title">Title</x-base.form-label>
                        <x-base.form-input
                            id="delivery-order-title"
                            name="title"
                            type="text"
                            required
                            class="text-sm"
                            placeholder="Ex: Customer Delivery #1234"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-date">Delivery Date</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 dark:text-slate-400">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="delivery-order-date"
                                name="delivery_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-priority">Priority</x-base.form-label>
                        <x-base.form-select id="delivery-order-priority" name="priority" class="text-sm">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-project">Project</x-base.form-label>
                        <x-base.form-select
                            id="delivery-order-project"
                            name="project_id"
                            class="text-sm"
                        >
                            <option value="">Select project</option>
                            @foreach(($projects ?? collect()) as $project)
                                <option value="{{ $project->id }}">
                                    {{ $project->code ? $project->code . ' — ' : '' }}{{ $project->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="delivery-order-approval-template">Approval Template</x-base.form-label>
                        <x-base.form-select id="delivery-order-approval-template" name="approval_template_id" class="text-sm">
                            <option value="">Select approval template</option>
                            @foreach ($approvalTemplates ?? [] as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-12">
                        <x-base.form-label for="delivery-order-description">Notes</x-base.form-label>
                        <x-base.form-textarea
                            id="delivery-order-description"
                            name="description"
                            rows="3"
                            class="text-sm"
                            placeholder="Context, instructions, or delivery details..."
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
                <div class="border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-wrap items-start justify-between gap-2 text-sm">
                            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">Select Materials</h4>
                        </div>
                        <div class="grid grid-cols-12 gap-2 text-sm">
                            <div class="col-span-12 md:col-span-3">
                                <x-base.form-label for="delivery-order-warehouse">Warehouse</x-base.form-label>
                                <x-base.form-select id="delivery-order-warehouse" name="warehouse_id" required class="text-sm">
                                    <option value="">Select warehouse</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }} — {{ $warehouse->location }}</option>
                                    @endforeach
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 md:col-span-3" data-catalog-control="catalog">
                                <x-base.form-label for="delivery-order-catalog">Catalog</x-base.form-label>
                                <x-base.form-select id="delivery-order-catalog" class="text-sm">
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
                                <x-base.form-label for="delivery-order-sub-catalog">Sub Catalog</x-base.form-label>
                                <x-base.form-select id="delivery-order-sub-catalog" disabled class="text-sm">
                                    <option value="">Select sub catalog</option>
                                </x-base.form-select>
                            </div>
                            <div class="col-span-12 md:col-span-3" data-catalog-control="material">
                                <x-base.form-label for="delivery-order-material-select">Materials</x-base.form-label>
                                <x-base.tom-select id="delivery-order-material-select" data-placeholder="Search materials" class="text-sm" disabled>
                                    <option value="">Select material</option>
                                </x-base.tom-select>
                                <div class="mt-2">
                                    <x-base.form-input id="delivery-order-material-filter" type="text" placeholder="Type to search..." class="w-full text-sm" disabled />
                                </div>
                                <div id="delivery-order-material-template" class="hidden">
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
                    <div id="delivery-order-material-loader" class="mt-4 flex items-center gap-2 text-xs text-slate-500 hidden">
                        <x-base.lucide icon="Loader" class="h-4 w-4 animate-spin" />
                        Fetching materials...
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-sm dark:border-darkmode-400 dark:bg-darkmode-600">
            <div class="flex items-center justify-between border-b border-slate-200/60 pb-4 dark:border-darkmode-400">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-100">Selected Items</h4>
                <span class="text-xs text-slate-500" id="delivery-order-item-count">0 items</span>
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
                    <tbody id="delivery-order-selected" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <div></div>
                <div class="text-right">
                    <p class="text-xs uppercase text-slate-500">Grand Total</p>
                    <p class="text-2xl font-semibold text-slate-800">
                        <span id="delivery-order-grand-total">{{ $currencySymbol ?? '$' }}0.00</span>
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
                form="delivery-order-form"
                id="delivery-order-submit"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Submit Order
            </button>
        </div>
    </x-slot>

    <script>
        (() => {
            const initModal = () => {
                const payload = window.deliveryOrderPayload;
                if (!payload) {
                    console.warn('deliveryOrderPayload missing');
                    return;
                }

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

                const codeInput = document.getElementById('delivery-order-code');
                const regenerateBtn = document.getElementById('delivery-order-regenerate');
                const warehouseSelect = document.getElementById('delivery-order-warehouse');
                const catalogSelect = document.getElementById('delivery-order-catalog');
                const subCatalogSelect = document.getElementById('delivery-order-sub-catalog');
                const materialSelect = document.getElementById('delivery-order-material-select');
                const materialTemplate = document.getElementById('delivery-order-material-template');
                const materialFilterInput = document.getElementById('delivery-order-material-filter');
                const loaderEl = document.getElementById('delivery-order-material-loader');
                const selectedTable = document.getElementById('delivery-order-selected');
                const totalField = document.getElementById('delivery-order-total');
                const itemsField = document.getElementById('delivery-order-items');
                const grandTotalLabel = document.getElementById('delivery-order-grand-total');
                const itemCountLabel = document.getElementById('delivery-order-item-count');
                const form = document.getElementById('delivery-order-form');
                const submitBtn = document.getElementById('delivery-order-submit');
                const companySelect = document.getElementById('delivery-order-company');
                const companyLogoEl = document.getElementById('delivery-order-company-logo');
                const companyNameEl = document.getElementById('delivery-order-company-name');
                const companyAddressEl = document.getElementById('delivery-order-company-address');

                const fallbackMaterialImage = payload.meta?.materialPlaceholder || 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><rect width="80" height="80" fill="#e2e8f0"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#94a3b8" font-family="Arial" font-size="10">No Image</text></svg>');

                const showError = (message) => {
                    window.showError?.(message) ?? console.error(message);
                };

                const fallbackLogo = (name) => `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'Smart ERP')}&background=1D4ED8&color=fff`;

                const getCompanyData = (id) => {
                    if (!id) return null;
                    return state.companyMap.get(String(id)) || null;
                };

                const updateCompanyHero = (companyData) => {
                    const target = companyData || state.defaultCompany || {};
                    const companyName = target.name || state.defaultCompany?.name || 'Smart ERP';
                    if (companyNameEl) companyNameEl.textContent = companyName;
                    if (companyAddressEl) {
                        companyAddressEl.textContent = target.address || state.defaultCompany?.address || 'Prepare and ship the requested items.';
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
                    if (!payload.routes.previewCode || !codeInput) return;
                    fetch(payload.routes.previewCode)
                        .then((res) => res.json())
                        .then((data) => {
                            if (data && data.code) {
                                codeInput.value = data.code;
                            }
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
                                    const titleEl = template.querySelector('p.text-sm');
                                    if (titleEl) {
                                        titleEl.textContent = data.name;
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

                const addMaterial = (selectedId) => {
                    const material = state.materialLookup.get(String(selectedId));
                    if (!material) return;

                    const key = String(material.id);
                    const existing = state.selected.get(key);

                    if (existing) {
                        existing.quantity += 1;
                        state.selected.set(key, existing);
                    } else {
                        state.selected.set(key, {
                            material_id: material.id,
                            code: material.code,
                            name: material.name,
                            unit: material.unit_name,
                            unit_symbol: material.unit_symbol,
                            quantity: 1,
                            unit_price: material.price,
                        });
                    }

                    renderSelected();
                };

                if (warehouseSelect) {
                    warehouseSelect.addEventListener('change', () => {
                        state.selectedWarehouseId = warehouseSelect.value || null;
                        resetMaterialResults();
                        if (canQueryMaterials()) {
                            fetchMaterials();
                        }
                    });
                }

                if (catalogSelect) {
                    catalogSelect.addEventListener('change', () => {
                        const catalogId = catalogSelect.value || null;
                        state.selectedCatalogId = catalogId;

                        const children = state.catalogChildrenMap.get(String(catalogId)) || [];
                        subCatalogSelect.innerHTML = '<option value="">Select sub catalog</option>';
                        if (children.length) {
                            children.forEach((child) => {
                                const option = document.createElement('option');
                                option.value = child.id;
                                option.textContent = child.name;
                                subCatalogSelect.appendChild(option);
                            });
                            subCatalogSelect.disabled = false;
                        } else {
                            subCatalogSelect.disabled = true;
                        }

                        resetMaterialResults();
                        if (canQueryMaterials()) {
                            fetchMaterials();
                        }
                    });
                }

                if (subCatalogSelect) {
                    subCatalogSelect.addEventListener('change', () => {
                        state.selectedSubCatalogId = subCatalogSelect.value || null;
                        resetMaterialResults();
                        if (canQueryMaterials()) {
                            fetchMaterials();
                        }
                    });
                }

                if (materialSelect) {
                    materialSelect.addEventListener('change', () => {
                        const selectedId = materialSelect.value;
                        if (!selectedId) return;
                        addMaterial(selectedId);
                        if (materialSelect.tomselect) {
                            materialSelect.tomselect.clear(true);
                        }
                    });
                }

                if (selectedTable) {
                    selectedTable.addEventListener('input', (event) => {
                        const target = event.target;
                        if (target && target.hasAttribute('data-qty')) {
                            const key = target.getAttribute('data-qty');
                            const value = parseFloat(target.value || '0');
                            const existing = state.selected.get(String(key));
                            if (!existing) {
                                return;
                            }
                            existing.quantity = value > 0 ? value : 1;
                            state.selected.set(String(key), existing);
                            renderSelected();
                        }
                    });

                    selectedTable.addEventListener('click', (event) => {
                        const target = event.target.closest('[data-remove]');
                        if (!target) return;
                        const key = target.getAttribute('data-remove');
                        state.selected.delete(String(key));
                        renderSelected();
                    });
                }

                if (regenerateBtn) {
                    regenerateBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        fetchCode();
                    });
                }

                syncCompanySelection();

                if (companySelect) {
                    companySelect.addEventListener('change', syncCompanySelection);
                }

                fetchCode();

                if (form && submitBtn) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const jq = window.jQuery || window.$;
                        if (!jq) {
                            showError('jQuery not available on delivery order page.');
                            return;
                        }

                        const $ = jq;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        const formData = new FormData(form);
                        const originalHtml = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...';

                        $.ajax({
                            url: payload.routes.store,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.success) {
                                    window.showSuccess?.(response.message || 'Delivery order created successfully') ?? console.log(response.message || 'Delivery order created successfully');

                                    const modalElement = document.getElementById('create-do-modal');
                                    if (modalElement && window.tailwind?.Modal?.getOrCreateInstance) {
                                        const instance = window.tailwind.Modal.getOrCreateInstance(modalElement);
                                        instance.hide();
                                    }

                                    form.reset();
                                    state.selected.clear();
                                    renderSelected();

                                    if (window.deliveryOrdersTable) {
                                        window.deliveryOrdersTable.ajax.reload();
                                    }
                                } else {
                                    const errorMsg = response.message || 'Failed to create delivery order.';
                                    showError(errorMsg);
                                }
                            },
                            error: function(xhr) {
                                let message = 'An error occurred while saving the delivery order.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                showError(message);
                            },
                            complete: function() {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalHtml;
                                if (typeof window.lucide !== 'undefined') {
                                    window.lucide.createIcons();
                                }
                            }
                        });
                    });
                }
            };

            const init = () => {
                if (window.deliveryOrderPayload) {
                    initModal();
                } else {
                    window.addEventListener('delivery-order:payload-ready', initModal, { once: true });
                }

                const openBtn = document.getElementById('open-create-do-modal');
                if (openBtn) {
                    openBtn.addEventListener('click', () => {
                        if (window.deliveryOrderPayload) {
                            initModal();
                        }
                    });
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
</x-modal.form>
