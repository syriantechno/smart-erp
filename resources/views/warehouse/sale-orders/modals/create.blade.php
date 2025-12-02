@php
    $soCurrencySymbol = $currencySymbol ?? config('app.currency_symbol', '$');
@endphp

<x-modal.form id="sale-order-modal" size="xxl" title="New Sale Order">
    <form id="sale-order-form" action="{{ route('warehouse.sale-orders.store') }}" method="POST" class="space-y-6">
        @csrf

        <input type="hidden" name="total_amount" id="sale-order-total" value="0">
        <input type="hidden" name="items" id="sale-order-items" value="[]">
        <input type="hidden" name="is_active" value="1">

        <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4">
            <div class="flex flex-wrap items-center gap-3">
                <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                    <x-base.lucide icon="shopping-bag" class="h-7 w-7 text-royalDark" />
                </div>
                <div class="flex-1 min-w-[200px]">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Sale Order</p>
                    <h3 class="text-lg font-semibold text-slate-800" id="sale-order-company-name">
                        {{ config('app.name') }}
                    </h3>
                    <p class="text-sm text-slate-500" id="sale-order-company-address">
                        Create a new sale order and select outgoing materials.
                    </p>
                </div>
                <div class="text-right text-sm text-slate-500">
                    <p>Currency</p>
                    <p class="text-base font-semibold text-slate-700">{{ $soCurrencySymbol }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm">
                <div class="border-b border-slate-200/60 px-5 py-3">
                    <h4 class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <x-base.lucide icon="Info" class="h-4 w-4" />
                        Order Details
                    </h4>
                </div>
                <div class="grid grid-cols-12 gap-2 px-5 py-4 text-sm">
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-code">Order Code</x-base.form-label>
                        <div class="flex gap-2">
                            <x-base.form-input
                                id="sale-order-code"
                                name="code"
                                type="text"
                                class="w-full text-sm"
                                readonly
                                placeholder="AUTO"
                            />
                            <x-base.button type="button" variant="outline-secondary" class="shrink-0" id="sale-order-regenerate">
                                <x-base.lucide icon="RefreshCcw" class="h-4 w-4" />
                            </x-base.button>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-title">Title</x-base.form-label>
                        <x-base.form-input
                            id="sale-order-title"
                            name="title"
                            type="text"
                            required
                            class="text-sm"
                            placeholder="Ex: Outgoing clinic supplies"
                        />
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-date">Order Date</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="sale-order-date"
                                name="order_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                                value="{{ now()->format('Y-m-d') }}"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-company">Company</x-base.form-label>
                        <x-base.form-select
                            id="sale-order-company"
                            name="company_id"
                            required
                            class="text-sm"
                        >
                            <option value="">Select company</option>
                            @foreach ($companies as $comp)
                                <option value="{{ $comp->id }}" @if(isset($company) && $company && $company->id === $comp->id) selected @endif>
                                    {{ $comp->name }}
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-warehouse">Warehouse</x-base.form-label>
                        <x-base.form-select
                            id="sale-order-warehouse"
                            name="warehouse_id"
                            required
                            class="text-sm"
                        >
                            <option value="">Select warehouse</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-expected-date">Expected Delivery</x-base.form-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500">
                                <x-base.lucide icon="Calendar" class="h-4 w-4" />
                            </div>
                            <x-base.litepicker
                                id="sale-order-expected-date"
                                name="expected_delivery_date"
                                class="w-full pl-12 text-sm"
                                data-single-mode="true"
                                data-format="YYYY-MM-DD"
                            />
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-project">Project</x-base.form-label>
                        <x-base.form-select id="sale-order-project" name="project_id" class="text-sm">
                            <option value="">Select project (optional)</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->code }} - {{ $project->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-6 lg:col-span-3">
                        <x-base.form-label for="sale-order-priority">Priority</x-base.form-label>
                        <x-base.form-select id="sale-order-priority" name="priority" class="text-sm">
                            <option value="normal" selected>Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-12 lg:col-span-6">
                        <x-base.form-label for="sale-order-approval-template">Approval Template</x-base.form-label>
                        <x-base.form-select
                            id="sale-order-approval-template"
                            name="approval_template_id"
                            class="text-sm"
                            required
                        >
                            <option value="">Select approval template</option>
                            @foreach ($approvalTemplates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12 sm:col-span-12 lg:col-span-6">
                        <x-base.form-label for="sale-order-description">Notes</x-base.form-label>
                        <x-base.form-textarea
                            id="sale-order-description"
                            name="description"
                            rows="3"
                            class="text-sm"
                            placeholder="Context, customer details, or instructions..."
                        ></x-base.form-textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm">
                <div class="border-b border-slate-200/60 px-5 py-3">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h4 class="text-sm font-semibold text-slate-700">Select Materials</h4>
                        <div class="flex flex-wrap items-center gap-2 text-sm">
                            <x-base.form-select id="sale-order-material-select" class="min-w-[220px] text-sm">
                                <option value="">Select material</option>
                                @foreach ($materials as $material)
                                    <option
                                        value="{{ $material['id'] }}"
                                        data-code="{{ $material['code'] }}"
                                        data-unit-symbol="{{ $material['unit_symbol'] ?? '' }}"
                                        data-price="{{ $material['price'] ?? 0 }}"
                                    >
                                        {{ $material['code'] ? $material['code'] . ' — ' : '' }}{{ $material['name'] }}
                                    </option>
                                @endforeach
                            </x-base.form-select>
                            <x-base.form-input
                                id="sale-order-material-qty"
                                type="number"
                                min="1"
                                step="1"
                                value="1"
                                class="w-20 text-sm"
                                placeholder="Qty"
                            />
                            <x-base.button type="button" id="sale-order-add-item" variant="primary" class="btn-royal btn-royal--sm">
                                <x-base.lucide icon="PlusCircle" class="h-4 w-4 mr-1" />
                                Add
                            </x-base.button>
                        </div>
                    </div>
                </div>
                <div class="px-5 pb-4 text-sm">
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
                            <tbody id="sale-order-selected" class="divide-y divide-slate-100"></tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-xs text-slate-500" id="sale-order-item-count">0 items</div>
                        <div class="text-right">
                            <p class="text-xs uppercase text-slate-500">Grand Total</p>
                            <p class="text-2xl font-semibold text-slate-800">
                                <span id="sale-order-grand-total">{{ $soCurrencySymbol }}0.00</span>
                            </p>
                        </div>
                    </div>
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
                form="sale-order-form"
                id="sale-order-submit"
                class="btn-royal btn-royal--gold group"
            >
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Save Order
            </button>
        </div>
    </x-slot>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jq = window.jQuery || window.$;
            if (!jq) {
                console.error('jQuery not available for sale order modal.');
                return;
            }

            const $ = jq;

            const form = document.getElementById('sale-order-form');
            const submitBtn = $('#sale-order-submit');
            const regenerateBtn = $('#sale-order-regenerate');
            const codeInput = document.getElementById('sale-order-code');
            const materialSelect = document.getElementById('sale-order-material-select');
            const qtyInput = document.getElementById('sale-order-material-qty');
            const addItemBtn = document.getElementById('sale-order-add-item');
            const selectedTable = document.getElementById('sale-order-selected');
            const totalField = document.getElementById('sale-order-total');
            const itemsField = document.getElementById('sale-order-items');
            const grandTotalLabel = document.getElementById('sale-order-grand-total');
            const itemCountLabel = document.getElementById('sale-order-item-count');

            const state = {
                selected: new Map(),
                currency: @json($soCurrencySymbol),
            };

            const refreshCode = () => {
                $.get('{{ route("warehouse.sale-orders.preview-code") }}')
                    .done(function (response) {
                        if (response && response.code) {
                            codeInput.value = response.code;
                        }
                    });
            };

            if (regenerateBtn.length) {
                regenerateBtn.on('click', function () {
                    refreshCode();
                });
            }

            // initial code
            refreshCode();

            const renderSelected = () => {
                selectedTable.innerHTML = '';
                let grandTotal = 0;

                state.selected.forEach((item) => {
                    const row = document.createElement('tr');
                    const lineTotal = item.quantity * item.unit_price;
                    grandTotal += lineTotal;

                    row.innerHTML = `
                        <td class="px-4 py-3">
                            <p class="font-semibold">${item.name}</p>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">${item.code || ''}</td>
                        <td class="px-4 py-3">
                            <input type="number" min="1" step="1" value="${item.quantity}" data-qty="${item.material_id}" class="w-20 rounded-lg border border-slate-200 px-2 py-1 text-sm" />
                        </td>
                        <td class="px-4 py-3">${state.currency}${Number(item.unit_price).toFixed(2)}</td>
                        <td class="px-4 py-3 text-right" data-row-total="${item.material_id}">${state.currency}${Number(lineTotal).toFixed(2)}</td>
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

                totalField.value = grandTotal.toFixed(2);
                itemsField.value = JSON.stringify(Array.from(state.selected.values()));
                itemCountLabel.textContent = `${state.selected.size} items`;
                grandTotalLabel.textContent = `${state.currency}${grandTotal.toFixed(2)}`;

                if (typeof window.lucide !== 'undefined' && window.lucide.createIcons) {
                    window.lucide.createIcons();
                }

                // bind quantity & remove events
                selectedTable.querySelectorAll('input[data-qty]').forEach((input) => {
                    input.addEventListener('input', () => {
                        const id = input.getAttribute('data-qty');
                        const qty = parseInt(input.value || '0', 10) || 0;
                        const item = state.selected.get(id);
                        if (!item) return;
                        item.quantity = Math.max(qty, 1);
                        state.selected.set(id, item);
                        renderSelected();
                    });
                });

                selectedTable.querySelectorAll('button[data-remove]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-remove');
                        state.selected.delete(id);
                        renderSelected();
                    });
                });
            };

            const addItem = () => {
                const materialId = materialSelect.value;
                if (!materialId) return;

                const option = materialSelect.options[materialSelect.selectedIndex];
                const name = option.textContent.trim();
                const code = option.getAttribute('data-code') || '';
                const price = parseFloat(option.getAttribute('data-price') || '0') || 0;
                const qty = parseInt(qtyInput.value || '1', 10) || 1;

                const existing = state.selected.get(materialId) || {
                    material_id: materialId,
                    name,
                    code,
                    unit_price: price,
                    quantity: 0,
                };

                existing.quantity += qty;
                state.selected.set(materialId, existing);

                renderSelected();
            };

            if (addItemBtn) {
                addItemBtn.addEventListener('click', addItem);
            }

            if (materialSelect) {
                materialSelect.addEventListener('change', () => {
                    // no-op for now
                });
            }

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const originalHtml = submitBtn.html();

                    submitBtn.prop('disabled', true)
                        .html('<i class="w-4 h-4 mr-2 animate-spin" data-lucide="loader"></i> Saving...');

                    $.ajax({
                        url: form.getAttribute('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']")?.getAttribute('content') || ''
                        },
                        success: function (response) {
                            if (response.success) {
                                const modalEl = document.getElementById('sale-order-modal');
                                if (modalEl && window.tailwind?.Modal?.getOrCreateInstance) {
                                    const instance = window.tailwind.Modal.getOrCreateInstance(modalEl);
                                    instance.hide();
                                }

                                form.reset();
                                state.selected.clear();
                                renderSelected();

                                if (window.saleOrdersTable) {
                                    window.saleOrdersTable.ajax.reload();
                                }

                                if (typeof window.showSuccess === 'function') {
                                    window.showSuccess(response.message || 'Sale order created successfully');
                                }
                            } else if (response.errors) {
                                const messages = Object.values(response.errors).flat().join('\n');
                                window.showError && window.showError(messages || 'Failed to create sale order.');
                            } else {
                                window.showError && window.showError(response.message || 'Failed to create sale order.');
                            }
                        },
                        error: function (xhr) {
                            let message = 'An error occurred while creating sale order.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            window.showError && window.showError(message);
                        },
                        complete: function () {
                            submitBtn.prop('disabled', false).html(originalHtml);
                            if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                                lucide.createIcons();
                            }
                        }
                    });
                });
            }
        });
    </script>
</x-modal.form>
