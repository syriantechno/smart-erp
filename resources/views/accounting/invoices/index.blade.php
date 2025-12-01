@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('invoices.page_title') }} - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
@include('components.global-notifications')

{{-- Header with Stats --}}
<div class="intro-y mt-6 mb-2 flex flex-col gap-1">
    <div class="flex items-baseline justify-between gap-6">
        <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
            <x-base.lucide icon="receipt" class="w-7 h-7" />
            <span>{{ __('invoices.page_title') }}</span>
        </h2>

        <div class="flex flex-row items-end gap-6 md:gap-10 justify-end">
            {{-- Overdue --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-rose-100 px-1.5 py-1">
                        <x-base.lucide icon="alert-triangle" class="w-4 h-4 text-[color:#303030]" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-[color:#303030]">
                        {{ $overdueInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('invoices.stats.overdue') }}</div>
            </div>

            {{-- Pending --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-amber-100 px-1.5 py-1">
                        <x-base.lucide icon="clock" class="w-4 h-4 text-[color:#303030]" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-[color:#303030]">
                        {{ $pendingInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('invoices.stats.pending') }}</div>
            </div>

            {{-- Paid --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-1.5 py-1">
                        <x-base.lucide icon="check-circle-2" class="w-4 h-4 text-[color:#303030]" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-[color:#303030]">
                        {{ $paidInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('invoices.stats.paid') }}</div>
            </div>

            {{-- Total --}}
            <div class="flex flex-col items-center gap-1">
                <div class="flex items-baseline gap-2">
                    <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                        <x-base.lucide icon="receipt" class="w-4 h-4 text-[color:#303030]" />
                    </div>
                    <div class="text-4xl md:text-5xl font-semibold tracking-tight text-[color:#303030]">
                        {{ $totalInvoices ?? 0 }}
                    </div>
                </div>
                <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">{{ __('invoices.stats.total') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="intro-y col-span-12">
        <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
            <div class="p-5">
                {{-- Filters & Actions in One Row --}}
                <div class="flex flex-wrap items-center gap-2 mb-4 md:flex-nowrap">
                    {{-- Search Input --}}
                    <div class="relative min-w-[180px]">
                        <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                        <x-base.form-input
                            id="invoices-filter-value"
                            type="text"
                            placeholder="{{ __('invoices.filters.search_placeholder') }}"
                            class="pl-9 w-full text-sm py-1.5"
                        />
                    </div>

                    {{-- Customer Filter --}}
                    <x-base.form-select id="customer-filter" class="w-auto text-sm py-1.5">
                        <option value="">{{ __('invoices.filters.customer_all') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->code }} - {{ $customer->name }}</option>
                        @endforeach
                    </x-base.form-select>

                    {{-- Type Filter --}}
                    <x-base.form-select id="type-filter" class="w-auto text-sm py-1.5">
                        <option value="">{{ __('invoices.filters.type_all') }}</option>
                        <option value="sales">{{ __('invoices.types.sales') }}</option>
                        <option value="purchase">{{ __('invoices.types.purchase') }}</option>
                    </x-base.form-select>

                    {{-- Status Filter --}}
                    <x-base.form-select id="status-filter" class="w-auto text-sm py-1.5">
                        <option value="">{{ __('invoices.filters.status_all') }}</option>
                        <option value="paid">{{ __('invoices.statuses.paid') }}</option>
                        <option value="pending">{{ __('invoices.statuses.pending') }}</option>
                        <option value="overdue">{{ __('invoices.statuses.overdue') }}</option>
                        <option value="cancelled">{{ __('invoices.statuses.cancelled') }}</option>
                    </x-base.form-select>

                    {{-- Date Range Filter --}}
                    <x-base.litepicker
                        id="date-from-filter"
                        name="date_from_filter"
                        class="w-auto text-sm py-1.5"
                        placeholder="{{ __('invoices.filters.date_from') }}"
                        autocomplete="off"
                    />
                    <x-base.litepicker
                        id="date-to-filter"
                        name="date_to_filter"
                        class="w-auto text-sm py-1.5"
                        placeholder="{{ __('invoices.filters.date_to') }}"
                        autocomplete="off"
                    />

                    {{-- Page Length --}}
                    <x-base.form-select id="invoices-filter-length" class="w-auto text-sm py-1.5">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                        <option value="1000">1000</option>
                    </x-base.form-select>

                    {{-- Reset Button --}}
                    <x-base.tippy as="button" id="invoices-filter-reset" type="button" content="{{ __('invoices.actions.reset_filters', [], 'en') ?? __('invoices.actions.reset_filters', [], app()->getLocale()) ?? __('messages.actions.reset') }}" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                        <x-base.lucide icon="x" class="w-4 h-4" />
                    </x-base.tippy>

                    {{-- Spacer --}}
                    <div class="flex-1"></div>

                    {{-- Action Buttons (match Positions page layout) --}}
                    <div class="flex items-center gap-1">
                        <x-base.tippy content="{{ __('invoices.buttons.print') }}" placement="bottom">
                            <button type="button" id="invoices-print" class="btn-royal btn-royal--outline btn-royal--sm px-2 group" title="{{ __('invoices.buttons.print') }}">
                                <x-base.lucide icon="printer" class="w-4 h-4" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('invoices.buttons.export_pdf') }}" placement="bottom">
                            <button id="invoices-export-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group" title="{{ __('invoices.buttons.export_pdf') }}">
                                <x-base.lucide icon="file-text" class="w-4 h-4" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('invoices.buttons.export_excel') }}" placement="bottom">
                            <button id="invoices-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group" title="{{ __('invoices.buttons.export_excel') }}">
                                <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('invoices.buttons.import') }}" placement="bottom">
                            <button id="invoices-import" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group" title="{{ __('invoices.buttons.import') }}">
                                <x-base.lucide icon="upload-cloud" class="w-4 h-4" />
                            </button>
                        </x-base.tippy>
                        <x-base.tippy content="{{ __('invoices.buttons.refresh') }}" placement="bottom">
                            <button id="invoices-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2 group" title="{{ __('invoices.buttons.refresh') }}">
                                <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                            </button>
                        </x-base.tippy>

                        {{-- Add Button --}}
                        <x-base.tippy content="{{ __('invoices.buttons.add') }}" placement="bottom">
                            <button type="button" class="btn-royal btn-royal--gold btn-royal--sm px-2 group" data-tw-toggle="modal" data-tw-target="#create-invoice-modal">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                <span class="hidden sm:inline">{{ __('invoices.buttons.add') }}</span>
                            </button>
                        </x-base.tippy>
                    </div>
                </div>

                {{-- Invoices DataTable --}}
                <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                    <table id="invoices-table" data-tw-merge data-erp-table class="w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">#</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('invoices.table.number') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('invoices.table.customer') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('invoices.table.type') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('invoices.table.date') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-right">{{ __('invoices.table.amount') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('invoices.table.status') }}</th>
                                <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('invoices.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data will be loaded via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </x-base.preview-component>
    </div>
</div>

{{-- Hidden button to trigger create modal --}}
<button id="create-invoice-trigger" data-tw-toggle="modal" data-tw-target="#create-invoice-modal" class="hidden"></button>
<button id="edit-invoice-trigger" data-tw-toggle="modal" data-tw-target="#edit-invoice-modal" class="hidden"></button>

{{-- Inline modals -- include both modals directly --}}
@include('accounting.invoices.partials.create-modal')
@include('accounting.invoices.partials.edit-modal')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    let currentInvoiceId = null;
    let invoiceLineIndex = 0;

    document.addEventListener('DOMContentLoaded', function () {
        console.log('[invoices] DOMContentLoaded - scripts initialized');
        // Filter elements
        const filterValue = document.getElementById('invoices-filter-value');
        const customerFilter = document.getElementById('customer-filter');
        const typeFilter = document.getElementById('type-filter');
        const statusFilter = document.getElementById('status-filter');
        const dateFromFilter = document.getElementById('date-from-filter');
        const dateToFilter = document.getElementById('date-to-filter');
        const lengthSelect = document.getElementById('invoices-filter-length');
        const filterResetBtn = document.getElementById('invoices-filter-reset');
        const exportBtn = document.getElementById('invoices-export');
        const exportPdfBtn = document.getElementById('invoices-export-pdf');
        const refreshBtn = document.getElementById('invoices-refresh');
        const importBtn = document.getElementById('invoices-import');

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 25 : 25;
        let searchTimeout = null;

        // Check if any filter is active
        function hasFilters() {
            return (filterValue && filterValue.value.trim() !== '') ||
                   (customerFilter && customerFilter.value !== '') ||
                   (typeFilter && typeFilter.value !== '') ||
                   (statusFilter && statusFilter.value !== '') ||
                   (dateFromFilter && dateFromFilter.value !== '') ||
                   (dateToFilter && dateToFilter.value !== '');
        }

        // High-performance DataTable with 10M+ records support
        const table = (window.erpCrud && window.erpCrud.initDataTable) ? window.erpCrud.initDataTable({
            tableSelector: '#invoices-table',
            ajaxUrl: '{{ route("accounting.invoices.datatable") }}',
            ajaxData: function (d) {
                d.search_value = filterValue ? filterValue.value.trim() : '';
                d.customer_id = customerFilter ? customerFilter.value : '';
                d.type = typeFilter ? typeFilter.value : '';
                d.status = statusFilter ? statusFilter.value : '';
                d.date_from = dateFromFilter ? dateFromFilter.value : '';
                d.date_to = dateToFilter ? dateToFilter.value : '';
                d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                // Add performance optimizations for large datasets
                d.performance_mode = true;
                return d;
            },
            pageLength: initialLength,
            // Optimized ordering for large datasets
            order: [[3, 'desc']], // Order by date descending
            dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
            // Server-side processing for high performance
            serverSide: true,
            processing: true,
            deferRender: true,
            // Optimized columns for large datasets
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium',
                    orderable: false,
                    searchable: false,
                    width: '5%'
                },
                {
                    data: 'number',
                    name: 'number',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap',
                    orderable: true,
                    searchable: true,
                    width: '15%'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300',
                    orderable: true,
                    searchable: true,
                    width: '20%'
                },
                {
                    data: 'type',
                    name: 'type',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: true,
                    searchable: false,
                    width: '10%',
                    render: function (value) {
                        if (value === 'sales') {
                            return '<span class="inline-flex items-center gap-1 text-emerald-600"><i data-lucide="trending-up" class="w-4 h-4"></i> مبيعات</span>';
                        } else {
                            return '<span class="inline-flex items-center gap-1 text-blue-600"><i data-lucide="trending-down" class="w-4 h-4"></i> مشتريات</span>';
                        }
                    }
                },
                {
                    data: 'invoice_date',
                    name: 'invoice_date',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: true,
                    searchable: false,
                    width: '12%'
                },
                {
                    data: 'total',
                    name: 'total',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-right font-semibold',
                    orderable: true,
                    searchable: false,
                    width: '15%'
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: true,
                    searchable: false,
                    width: '13%',
                    render: function (value) {
                        const statusConfig = {
                            'paid': { color: 'emerald', text: 'مدفوعة', icon: 'check-circle' },
                            'pending': { color: 'amber', text: 'معلقة', icon: 'clock' },
                            'overdue': { color: 'rose', text: 'متأخرة', icon: 'alert-triangle' },
                            'cancelled': { color: 'slate', text: 'ملغاة', icon: 'x-circle' }
                        };
                        const config = statusConfig[value] || { color: 'slate', text: value, icon: 'circle' };
                        return `<span class="inline-flex items-center gap-1 px-2 py-1 bg-${config.color}-100 text-${config.color}-600 rounded text-xs font-semibold">
                                    <i data-lucide="${config.icon}" class="w-3 h-3"></i> ${config.text}
                                </span>`;
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    searchable: false,
                    width: '10%',
                    render: function (data, type, row) {
                        return `
                            <div class="flex justify-center gap-1">
                                <button class="p-1.5 rounded hover:bg-blue-50 text-blue-600 hover:text-blue-800 transition-colors" title="عرض" onclick="viewInvoice('${row.id}')">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="p-1.5 rounded hover:bg-amber-50 text-amber-600 hover:text-amber-800 transition-colors" title="تعديل" onclick="openEditModal('${row.id}')">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="p-1.5 rounded hover:bg-emerald-50 text-emerald-600 hover:text-emerald-800 transition-colors" title="طباعة" onclick="printInvoice('${row.id}')">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </button>
                                <button class="p-1.5 rounded hover:bg-red-50 text-slate-500 hover:text-red-600 transition-colors" title="حذف" onclick="deleteInvoice('${row.id}', '${row.number}')">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function (settings) {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
                }

                const info = settings.api().page.info();
                const totalInvoicesCount = document.getElementById('total-invoices-count');
                const filteredInvoicesCount = document.getElementById('filtered-invoices-count');

                if (totalInvoicesCount) {
                    totalInvoicesCount.textContent = info.recordsTotal.toLocaleString();
                }
                if (filteredInvoicesCount) {
                    filteredInvoicesCount.textContent = info.recordsDisplay.toLocaleString();
                }

                const activeFiltersIndicator = document.getElementById('active-filters-indicator');
                if (activeFiltersIndicator) {
                    activeFiltersIndicator.classList.toggle('hidden', !hasFilters());
                }

                // Update stats
                updateInvoiceStats();
            },
            // Performance optimizations for large datasets
            stateSave: true,
            stateDuration: 60 * 60 * 24, // 24 hours
            responsive: false, // Disable responsive for better performance
            scrollX: false,
            // Optimized language
            language: {
                processing: '<div class="flex items-center justify-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div><span class="ml-2">جاري التحميل...</span></div>',
                emptyTable: '<div class="text-center py-8"><i data-lucide="inbox" class="w-12 h-12 mx-auto mb-2 opacity-50"></i><p>لا توجد فواتير</p></div>',
                zeroRecords: '<div class="text-center py-8"><i data-lucide="search-x" class="w-12 h-12 mx-auto mb-2 opacity-50"></i><p>لم يتم العثور على نتائج</p></div>'
            }
        }) : null;

        if (!table) {
            console.error('Failed to initialize DataTable');
            return;
        }

        // Stats elements
        const statsTotal = document.getElementById('stats-total');
        const statsPaid = document.getElementById('stats-paid');
        const statsPending = document.getElementById('stats-pending');
        const statsOverdue = document.getElementById('stats-overdue');

        // Update stats based on current filters
        function updateInvoiceStats() {
            const params = new URLSearchParams();
            if (filterValue && filterValue.value.trim()) params.append('search_value', filterValue.value.trim());
            if (customerFilter && customerFilter.value) params.append('customer_id', customerFilter.value);
            if (typeFilter && typeFilter.value) params.append('type', typeFilter.value);
            if (statusFilter && statusFilter.value) params.append('status', statusFilter.value);
            if (dateFromFilter && dateFromFilter.value) params.append('date_from', dateFromFilter.value);
            if (dateToFilter && dateToFilter.value) params.append('date_to', dateToFilter.value);

            fetch('{{ route("accounting.invoices.stats") }}?' + params.toString(), {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (statsTotal) statsTotal.textContent = data.total || '—';
                if (statsPaid) statsPaid.textContent = data.paid || '—';
                if (statsPending) statsPending.textContent = data.pending || '—';
                if (statsOverdue) statsOverdue.textContent = data.overdue || '—';
            })
            .catch(() => {
                // Keep existing values on error
            });
        }

        const reloadTable = function () {
            table.ajax.reload(null, false);
        };

        // Search with debounce (auto-search as you type)
        if (filterValue) {
            filterValue.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(reloadTable, 500); // Longer delay for server-side processing
            });
        }

        // Instant filter on dropdown change
        [customerFilter, typeFilter, statusFilter, dateFromFilter, dateToFilter].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', reloadTable);
            }
        });

        if (lengthSelect) {
            lengthSelect.addEventListener('change', function () {
                const newLength = parseInt(this.value, 10) || initialLength;
                table.page.len(newLength).draw();
            });
        }

        // Reset all filters
        if (filterResetBtn) {
            filterResetBtn.addEventListener('click', function () {
                if (filterValue) filterValue.value = '';
                if (customerFilter) customerFilter.value = '';
                if (typeFilter) typeFilter.value = '';
                if (statusFilter) statusFilter.value = '';
                if (dateFromFilter) dateFromFilter.value = '';
                if (dateToFilter) dateToFilter.value = '';
                if (lengthSelect) {
                    lengthSelect.value = String(initialLength);
                    table.page.len(initialLength);
                }
                reloadTable();
            });
        }

        // Export functionality
        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                try {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("accounting.invoices.export") }}';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                    }

                    const params = {
                        'search_value': filterValue ? filterValue.value : '',
                        'customer_id': customerFilter ? customerFilter.value : '',
                        'type': typeFilter ? typeFilter.value : '',
                        'status': statusFilter ? statusFilter.value : '',
                        'date_from': dateFromFilter ? dateFromFilter.value : '',
                        'date_to': dateToFilter ? dateToFilter.value : ''
                    };

                    Object.entries(params).forEach(function ([key, value]) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = value || '';
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                    if (typeof showToast === 'function') {
                        showToast('Export started successfully', 'success');
                    }
                } catch (error) {
                    if (typeof showToast === 'function') {
                        showToast('Failed to export data', 'error');
                    }
                }
            });
        }

        // PDF Export
        if (exportPdfBtn) {
            exportPdfBtn.addEventListener('click', function () {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("accounting.invoices.export-pdf") }}';

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);
                }

                const params = {
                    'search_value': filterValue ? filterValue.value : '',
                    'customer_id': customerFilter ? customerFilter.value : '',
                    'type': typeFilter ? typeFilter.value : '',
                    'status': statusFilter ? statusFilter.value : '',
                    'date_from': dateFromFilter ? dateFromFilter.value : '',
                    'date_to': dateToFilter ? dateToFilter.value : ''
                };

                Object.entries(params).forEach(function ([key, value]) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value || '';
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            });
        }

        // Refresh functionality
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function () {
                reloadTable();
                if (typeof showToast === 'function') {
                    showToast('Table refreshed successfully', 'success');
                }
            });
        }

        // Modal management
        document.addEventListener('hidden.tw.modal', function () {
            if (document.activeElement && typeof document.activeElement.blur === 'function') {
                document.activeElement.blur();
            }
            reloadTable();
        });

        // Use shared CRUD helper for delete
        if (window.erpCrud) {
            window.erpCrud.handleDelete({
                urlBuilder: function (id) {
                    return `{{ route('accounting.invoices.destroy', '') }}/${id}`;
                },
                onSuccess: function () {
                    reloadTable();
                },
            });

            // Keep backwards-compatible function name
            window.deleteInvoice = function (id, name) {
                if (typeof window.erpDeleteRecord === 'function') {
                    window.erpDeleteRecord(id, name);
                }
            };
        }
    });

    // Modal functions (exposed globally for inline handlers)
    window.openCreateInvoiceModal = function () {
        console.log('[invoices] openCreateInvoiceModal() called');

        // Wait for DOM to be fully loaded and modals to be rendered
        if (document.readyState !== 'complete') {
            console.log('[invoices] DOM not ready, waiting...');
            setTimeout(window.openCreateInvoiceModal, 100);
            return;
        }

        const modal = document.getElementById('create-invoice-modal');
        if (!modal) {
            console.log('[invoices] create-invoice-modal element not found, searching again...');
            // Try to find it in a stack or other location
            const stackedModal = document.querySelector('#create-invoice-modal');
            if (stackedModal) {
                console.log('[invoices] Found modal in stack');
                stackedModal.style.display = 'flex';
                return;
            }
            console.log('[invoices] create-invoice-modal element still not found');
            return;
        }

        console.log('[invoices] showing create-invoice-modal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        if (!modal.classList.contains('flex')) {
            modal.classList.add('flex');
        }

        // Reinitialize Lucide icons in modal
        setTimeout(() => {
            if (typeof window.Lucide !== 'undefined') {
                window.Lucide.createIcons();
            }
        }, 100);
    };

    window.closeCreateInvoiceModal = function () {
        const modal = document.getElementById('create-invoice-modal');
        if (modal) {
            console.log('[invoices] closeCreateInvoiceModal() - hiding modal');
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }
    };

    window.closeEditInvoiceModal = function () {
        const modal = document.getElementById('edit-invoice-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    };

    window.openEditModal = function (id) {
        currentInvoiceId = id;
        // Load invoice data and populate form
        fetch(`{{ route('accounting.invoices.show', '') }}/${id}`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit-customer_id').value = data.customer_id || '';
                document.getElementById('edit-type').value = data.type || 'sales';
                document.getElementById('edit-invoice_date').value = data.invoice_date || '';
                document.getElementById('edit-due_date').value = data.due_date || '';
                document.getElementById('edit-reference').value = data.reference || '';
                document.getElementById('edit-status').value = data.status || 'pending';
                document.getElementById('edit-notes').value = data.notes || '';

                // Load invoice lines
                loadEditInvoiceLines(data.lines || []);

                // Update form action
                const form = document.getElementById('edit-invoice-form');
                form.action = `{{ route('accounting.invoices.update', '') }}/${id}`;

                // Show modal
                const modalTrigger = document.getElementById('edit-invoice-trigger');
                if (modalTrigger) {
                    modalTrigger.click();
                }
            })
            .catch(error => {
                console.error('Error loading invoice:', error);
                if (typeof showToast === 'function') {
                    showToast('Failed to load invoice data', 'error');
                }
            });
    };

    function loadEditInvoiceLines(lines) {
        const container = document.getElementById('edit-invoice-lines');
        container.innerHTML = '';

        lines.forEach((line, index) => {
            const lineHtml = `
                <div class="grid grid-cols-12 gap-4 p-4 border border-slate-200 rounded-lg bg-slate-50/50" data-line="${index}">
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-sm font-medium text-slate-700 mb-1">الوصف <span class="text-danger">*</span></label>
                        <input name="lines[${index}][description]" type="text" value="${line.description || ''}" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <label class="block text-sm font-medium text-slate-700 mb-1">الحساب <span class="text-danger">*</span></label>
                        <select name="lines[${index}][account_id]" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
                            <option value="">اختر الحساب</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" ${line.account_id == {{ $account->id }} ? 'selected' : ''}>
                                    {{ $account->code }} - {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-6 md:col-span-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1">الكمية <span class="text-danger">*</span></label>
                        <input name="lines[${index}][quantity]" type="number" min="0" step="0.001" value="${line.quantity || 1}" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                    </div>
                    <div class="col-span-6 md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">السعر <span class="text-danger">*</span></label>
                        <input name="lines[${index}][unit_price]" type="number" min="0" step="0.01" value="${line.unit_price || 0}" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                    </div>
                    <div class="col-span-12 md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">المجموع</label>
                        <input name="lines[${index}][total]" type="number" min="0" step="0.01" value="${line.total || 0}" class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100" readonly />
                    </div>
                    <div class="col-span-12 md:col-span-1 flex items-end">
                        <button type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full" onclick="removeEditInvoiceLine(${index})">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', lineHtml);
        });

        // Reinitialize Lucide icons
        if (typeof window.Lucide !== 'undefined') {
            window.Lucide.createIcons();
        }

        calculateEditInvoiceTotals();
    }

    function addInvoiceLine() {
        const container = document.getElementById('invoice-lines');
        const lineIndex = container.children.length;
        const lineHtml = `
            <div class="grid grid-cols-12 gap-4 p-4 border border-slate-200 rounded-lg bg-slate-50/50" data-line="${lineIndex}">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label class="text-sm">الوصف <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input name="lines[${lineIndex}][description]" type="text" placeholder="وصف البند" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label class="text-sm">الحساب <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select name="lines[${lineIndex}][account_id]" required>
                        <option value="">اختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->code }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-6 md:col-span-1">
                    <x-base.form-label class="text-sm">الكمية <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input name="lines[${lineIndex}][quantity]" type="number" min="0" step="0.001" value="1" required />
                </div>
                <div class="col-span-6 md:col-span-2">
                    <x-base.form-label class="text-sm">السعر <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input name="lines[${lineIndex}][unit_price]" type="number" min="0" step="0.01" value="0" required />
                </div>
                <div class="col-span-12 md:col-span-2">
                    <x-base.form-label class="text-sm">المجموع</x-base.form-label>
                    <x-base.form-input name="lines[${lineIndex}][total]" type="number" min="0" step="0.01" value="0" class="bg-slate-100" readonly />
                </div>
                <div class="col-span-12 md:col-span-1 flex items-end">
                    <button type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full" onclick="removeInvoiceLine(${lineIndex})">
                        <x-base.lucide icon="trash-2" class="w-4 h-4" />
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', lineHtml);

        // Reinitialize Lucide icons
        if (typeof window.Lucide !== 'undefined') {
            window.Lucide.createIcons();
        }
    }

    function removeInvoiceLine(index) {
        const line = document.querySelector(`#invoice-lines [data-line="${index}"]`);
        if (line) {
            line.remove();
            recalculateLineIndices('invoice-lines');
            calculateInvoiceTotals();
        }
    }

    function addEditInvoiceLine() {
        const container = document.getElementById('edit-invoice-lines');
        const lineIndex = container.children.length;
        const lineHtml = `
            <div class="grid grid-cols-12 gap-4 p-4 border border-slate-200 rounded-lg bg-slate-50/50" data-line="${lineIndex}">
                <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">الوصف <span class="text-danger">*</span></label>
                    <input name="lines[${lineIndex}][description]" type="text" placeholder="وصف البند" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 mb-1">الحساب <span class="text-danger">*</span></label>
                    <select name="lines[${lineIndex}][account_id]" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <option value="">اختر الحساب</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->code }} - {{ $account->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 md:col-span-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1">الكمية <span class="text-danger">*</span></label>
                    <input name="lines[${lineIndex}][quantity]" type="number" min="0" step="0.001" value="1" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                </div>
                <div class="col-span-6 md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">السعر <span class="text-danger">*</span></label>
                    <input name="lines[${lineIndex}][unit_price]" type="number" min="0" step="0.01" value="0" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required />
                </div>
                <div class="col-span-12 md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">المجموع</label>
                    <input name="lines[${lineIndex}][total]" type="number" min="0" step="0.01" value="0" class="w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100" readonly />
                </div>
                <div class="col-span-12 md:col-span-1 flex items-end">
                    <button type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full" onclick="removeEditInvoiceLine(${lineIndex})">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', lineHtml);

        // Reinitialize Lucide icons
        if (typeof window.Lucide !== 'undefined') {
            window.Lucide.createIcons();
        }
    }

    function removeEditInvoiceLine(index) {
        const line = document.querySelector(`#edit-invoice-lines [data-line="${index}"]`);
        if (line) {
            line.remove();
            recalculateLineIndices('edit-invoice-lines');
            calculateEditInvoiceTotals();
        }
    }

    function recalculateLineIndices(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const lines = container.querySelectorAll('[data-line]');
        lines.forEach((line, index) => {
            line.setAttribute('data-line', index);
            const inputs = line.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                }
            });
            const removeBtn = line.querySelector('button[onclick]');
            if (removeBtn) {
                removeBtn.setAttribute('onclick', removeBtn.getAttribute('onclick').replace(/\(\d+\)/, `(${index})`));
            }
        });
    }

    function calculateInvoiceTotals() {
        const lines = document.querySelectorAll('#invoice-lines [data-line]');
        let subtotal = 0;

        lines.forEach(line => {
            const quantity = parseFloat(line.querySelector('input[name*="[quantity]"]').value) || 0;
            const unitPrice = parseFloat(line.querySelector('input[name*="[unit_price]"]').value) || 0;
            const total = quantity * unitPrice;

            const totalInput = line.querySelector('input[name*="[total]"]');
            if (totalInput) {
                totalInput.value = total.toFixed(2);
            }

            subtotal += total;
        });

        const taxRate = {{ $taxRate ?? 0 }};
        const taxAmount = (subtotal * taxRate) / 100;
        const total = subtotal + taxAmount;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('tax-amount').textContent = taxAmount.toFixed(2);
        document.getElementById('total-amount').textContent = total.toFixed(2);
    }

    function calculateEditInvoiceTotals() {
        const lines = document.querySelectorAll('#edit-invoice-lines [data-line]');
        let subtotal = 0;

        lines.forEach(line => {
            const quantity = parseFloat(line.querySelector('input[name*="[quantity]"]').value) || 0;
            const unitPrice = parseFloat(line.querySelector('input[name*="[unit_price]"]').value) || 0;
            const total = quantity * unitPrice;

            const totalInput = line.querySelector('input[name*="[total]"]');
            if (totalInput) {
                totalInput.value = total.toFixed(2);
            }

            subtotal += total;
        });

        const taxRate = {{ $taxRate ?? 0 }};
        const taxAmount = (subtotal * taxRate) / 100;
        const total = subtotal + taxAmount;

        document.getElementById('edit-subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('edit-tax-amount').textContent = taxAmount.toFixed(2);
        document.getElementById('edit-total-amount').textContent = total.toFixed(2);
    }

    function saveInvoice() {
        const form = document.getElementById('create-invoice-form');
        const formData = new FormData(form);

        const saveBtn = document.getElementById('save-invoice-btn');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-2"></i> جاري الحفظ...';
        saveBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeCreateInvoiceModal();
                if (typeof showToast === 'function') {
                    showToast('Invoice created successfully', 'success');
                }
                // Reload table
                if (window.table) {
                    window.table.ajax.reload(null, false);
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to create invoice', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while creating the invoice', 'error');
            }
        })
        .finally(() => {
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            if (typeof window.Lucide !== 'undefined') {
                window.Lucide.createIcons();
            }
        });
    }

    function updateInvoice() {
        const form = document.getElementById('edit-invoice-form');
        const formData = new FormData(form);

        const updateBtn = document.getElementById('update-invoice-btn');
        const originalText = updateBtn.innerHTML;
        updateBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin mr-2"></i> جاري التحديث...';
        updateBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeEditInvoiceModal();
                if (typeof showToast === 'function') {
                    showToast('Invoice updated successfully', 'success');
                }
                // Reload table
                if (window.table) {
                    window.table.ajax.reload(null, false);
                }
            } else {
                if (typeof showToast === 'function') {
                    showToast(data.message || 'Failed to update invoice', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showToast === 'function') {
                showToast('An error occurred while updating the invoice', 'error');
            }
        })
        .finally(() => {
            updateBtn.innerHTML = originalText;
            updateBtn.disabled = false;
            if (typeof window.Lucide !== 'undefined') {
                window.Lucide.createIcons();
            }
        });
    }

    // Auto-calculate totals on input change
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[name*="[quantity]"], input[name*="[unit_price]"]')) {
            if (e.target.closest('#invoice-lines')) {
                calculateInvoiceTotals();
            } else if (e.target.closest('#edit-invoice-lines')) {
                calculateEditInvoiceTotals();
            }
        }
    });

    // View Invoice function
    function viewInvoice(invoiceId) {
        // TODO: Implement invoice viewing modal or redirect to invoice details page
        if (typeof showToast === 'function') {
            showToast('View invoice functionality coming soon', 'info');
        }
    }

    // Print Invoice function
    function printInvoice(invoiceId) {
        // TODO: Implement invoice printing
        if (typeof showToast === 'function') {
            showToast('Print invoice functionality coming soon', 'info');
        }
    }
    </script>
