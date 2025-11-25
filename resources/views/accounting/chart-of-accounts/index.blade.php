@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Chart of Accounts - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Departments template matches Positions) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="book-open" class="w-7 h-7" />
                <span>Chart of Accounts</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Total accounts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="book-open" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight" id="total-accounts">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Total
                    </div>
                </div>

                {{-- Asset accounts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="trending-up" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight" id="asset-accounts">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Assets
                    </div>
                </div>

                {{-- Liability accounts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="trending-down" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight" id="liability-accounts">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Liabilities
                    </div>
                </div>

                {{-- Income accounts --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="dollar-sign" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight" id="income-accounts">
                            0
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Income
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Account Statistics -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="BarChart3" class="h-5 w-5"></x-base.lucide>
                        Account Overview
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-3">
                            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600" id="total-accounts">0</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Total Accounts</div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-green-600" id="asset-accounts">0</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Asset Accounts</div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-red-600" id="liability-accounts">0</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Liability Accounts</div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-3">
                            <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600" id="income-accounts">0</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Income Accounts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Advanced Filters Section -->
            <x-base.preview-component class="intro-y box mb-6">
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <x-base.lucide icon="Filter" class="h-5 w-5"></x-base.lucide>
                        Account Filters
                        <span
                            id="active-filters-indicator"
                            class="hidden items-center gap-1 ml-3 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-0.5 text-xs font-semibold text-emerald-700"
                        >
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </span>
                    </h3>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Type Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Type
                            </label>
                            <x-base.form-select id="type-filter" class="w-full">
                                <option value="">All Types</option>
                                <option value="asset">Asset</option>
                                <option value="liability">Liability</option>
                                <option value="equity">Equity</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </x-base.form-select>
                        </div>

                        <!-- Category Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Category
                            </label>
                            <x-base.form-select id="category-filter" class="w-full">
                                <option value="">All Categories</option>
                                <option value="current_asset">Current Asset</option>
                                <option value="fixed_asset">Fixed Asset</option>
                                <option value="current_liability">Current Liability</option>
                                <option value="long_term_liability">Long-term Liability</option>
                                <option value="owner_equity">Owner Equity</option>
                                <option value="retained_earnings">Retained Earnings</option>
                                <option value="operating_income">Operating Income</option>
                                <option value="other_income">Other Income</option>
                                <option value="cost_of_goods_sold">Cost of Goods Sold</option>
                                <option value="operating_expense">Operating Expense</option>
                                <option value="other_expense">Other Expense</option>
                            </x-base.form-select>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Filter by Status
                            </label>
                            <x-base.form-select id="status-filter" class="w-full">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </x-base.form-select>
                        </div>

                        <!-- Level Filter -->
                        <div class="col-span-12 md:col-span-3">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Account Level
                            </label>
                            <x-base.form-select id="level-filter" class="w-full">
                                <option value="">All Levels</option>
                                <option value="1">Level 1 (Main)</option>
                                <option value="2">Level 2 (Sub)</option>
                                <option value="3">Level 3 (Sub-sub)</option>
                                <option value="4">Level 4+</option>
                            </x-base.form-select>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-slate-500 dark:text-slate-400">
                            Use these filters to refine the accounts table. You can reset them anytime.
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button
                                type="button"
                                id="clear-advanced-filters"
                                class="btn-royal btn-royal--outline btn-royal--sm min-h-[42px] px-4 group"
                            >
                                <x-base.lucide icon="RotateCcw" class="w-4 h-4 icon-hover-rise" />
                                Clear Filters
                            </button>
                            <button
                                type="button"
                                id="apply-filters"
                                class="btn-royal btn-royal--dark btn-royal--sm min-h-[42px] px-4 group"
                            >
                                <x-base.lucide icon="Search" class="w-4 h-4 icon-hover-rise" />
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <!-- Persistent side tree column -->
        <div class="intro-y col-span-12 lg:col-span-3 xl:col-span-3">
            <x-base.preview-component class="intro-y box h-full">
                <div class="p-4 lg:p-5 flex flex-col h-full">
                    <div class="mb-3 flex items-center justify-between gap-2">
                        <h3 class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-white">
                            <x-base.lucide icon="FolderTree" class="h-4 w-4" />
                            <span>Accounts Tree</span>
                        </h3>
                        <span class="rounded-full bg-slate-50 px-2 py-0.5 text-[10px] font-medium text-slate-500 dark:bg-darkmode-600 dark:text-slate-300">
                            Hierarchy
                        </span>
                    </div>
                    <div id="accounts-tree" class="mt-1 flex-1 overflow-y-auto text-sm text-slate-700 dark:text-slate-300 custom-scrollbar thin-scrollbar max-h-[540px]">
                        <div class="text-xs text-slate-500 dark:text-slate-400">
                            Loading accounts tree...
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>

        <!-- Main table column -->
        <div class="intro-y col-span-12 lg:col-span-9 xl:col-span-9">
            <x-base.preview-component class="intro-y box h-full">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="account-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="account-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="name">Name</option>
                                    <option value="type">Type</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="account-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="account-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="account-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0 flex flex-col gap-2">
                                <button
                                    id="account-filter-go"
                                    type="button"
                                    class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group"
                                >
                                    <x-base.lucide icon="Search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button
                                    id="account-filter-reset"
                                    type="button"
                                    class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group"
                                >
                                    <x-base.lucide icon="RotateCcw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Journal Entries" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark"
                                    data-tw-toggle="modal"
                                    data-tw-target="#journal-entries-modal"
                                >
                                    <x-base.lucide icon="book-open" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="account-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export" placement="bottom">
                                <button id="account-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="account-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm  group text-royalDark">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Account button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new account" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#add-account-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="account-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Account Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Parent Account</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Balance</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </x-base.preview-component>
        </div>
    </div>

    @include('accounting.chart-of-accounts.modals.add')
    @include('accounting.journal-entries.modals.list')
    @stack('modals')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script>
    try {
        document.addEventListener('DOMContentLoaded', function () {
            const filterField = document.getElementById('account-filter-field');
            const filterType = document.getElementById('account-filter-type');
            const filterValue = document.getElementById('account-filter-value');
            const lengthSelect = document.getElementById('account-filter-length');
            const filterGoBtn = document.getElementById('account-filter-go');
            const filterResetBtn = document.getElementById('account-filter-reset');
            const exportBtn = document.getElementById('account-export');
            const refreshBtn = document.getElementById('account-refresh');

            // Advanced filters
            const typeFilter = document.getElementById('type-filter');
            const categoryFilter = document.getElementById('category-filter');
            const statusFilter = document.getElementById('status-filter');
            const levelFilter = document.getElementById('level-filter');
            const applyFiltersBtn = document.getElementById('apply-filters');
            const clearAdvancedFiltersBtn = document.getElementById('clear-advanced-filters');
            const activeFiltersIndicator = document.getElementById('active-filters-indicator');

            // Statistics elements
            const totalAccounts = document.getElementById('total-accounts');
            const assetAccounts = document.getElementById('asset-accounts');
            const liabilityAccounts = document.getElementById('liability-accounts');
            const incomeAccounts = document.getElementById('income-accounts');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = window.erpCrud.initDataTable({
                tableSelector: '#account-table',
                ajaxUrl: '{{ route("accounting.chart-of-accounts.datatable") }}',
                ajaxData: function (d) {
                    if (filterField) {
                        d.filter_field = filterField.value || 'all';
                    }
                    if (filterType) {
                        d.filter_type = filterType.value || 'contains';
                    }
                    if (filterValue) {
                        d.filter_value = filterValue.value || '';
                    }
                    if (typeFilter) {
                        d.type = typeFilter.value || '';
                    }
                    if (categoryFilter) {
                        d.category = categoryFilter.value || '';
                    }
                    if (statusFilter) {
                        d.status = statusFilter.value || '';
                    }
                    if (levelFilter) {
                        d.level = levelFilter.value || '';
                    }
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                pageLength: initialLength,
                order: [[2, 'asc']],
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                    { data: 'parent_name', name: 'parent_name', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                    {
                        data: 'type_badge',
                        name: 'type_badge',
                        render: function (value) {
                            return value;
                        }
                    },
                    { data: 'balance_formatted', name: 'balance_formatted', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap text-green-600 font-medium' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function (value) {
                            return value;
                        }
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function () {
                    if (typeof window.lucide !== 'undefined') {
                        window.lucide.createIcons();
                    }
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                    updateAccountStatistics();
                    updateActiveFiltersIndicator();
                }
            });

            window.accountTable = table;

            if (!table) {
                return;
            }

            // Load initial stats
            updateAccountStatistics();

            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
                updateAccountStatistics();
            };

            if (filterGoBtn) {
                filterGoBtn.addEventListener('click', reloadTable);
            }

            if (filterValue) {
                filterValue.addEventListener('keyup', function (event) {
                    if (event.key === 'Enter') {
                        reloadTable();
                    }
                });
            }

            if (filterResetBtn) {
                filterResetBtn.addEventListener('click', function () {
                    if (filterField) filterField.value = 'all';
                    if (filterType) filterType.value = 'contains';
                    if (filterValue) filterValue.value = '';
                    if (lengthSelect) {
                        lengthSelect.value = String(initialLength);
                        table.page.len(initialLength).draw();
                    }
                    // Reset advanced filters
                    if (typeFilter) typeFilter.value = '';
                    if (categoryFilter) categoryFilter.value = '';
                    if (statusFilter) statusFilter.value = '';
                    if (levelFilter) levelFilter.value = '';
                    reloadTable();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            // Advanced filters
            if (applyFiltersBtn) {
                applyFiltersBtn.addEventListener('click', reloadTable);
            }

            if (clearAdvancedFiltersBtn) {
                clearAdvancedFiltersBtn.addEventListener('click', function () {
                    if (typeFilter) typeFilter.value = '';
                    if (categoryFilter) categoryFilter.value = '';
                    if (statusFilter) statusFilter.value = '';
                    if (levelFilter) levelFilter.value = '';
                    reloadTable();
                });
            }

            const autoApplyAdvancedFilters = function () {
                setTimeout(reloadTable, 250);
            };

            if (typeFilter) {
                typeFilter.addEventListener('change', autoApplyAdvancedFilters);
            }
            if (categoryFilter) {
                categoryFilter.addEventListener('change', autoApplyAdvancedFilters);
            }
            if (statusFilter) {
                statusFilter.addEventListener('change', autoApplyAdvancedFilters);
            }
            if (levelFilter) {
                levelFilter.addEventListener('change', autoApplyAdvancedFilters);
            }

            // Export functionality
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data available for export.', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Name', 'Parent Account', 'Type', 'Balance', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                '"' + (row.name || '').replace(/"/g, '""') + '"',
                                '"' + (row.parent_name || '').replace(/"/g, '""') + '"',
                                row.type_label || 'Unknown',
                                row.balance_formatted ? parseFloat(row.balance_formatted.replace('$', '').replace(',', '')) : 0,
                                row.is_active ? 'Active' : 'Inactive'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = 'chart_of_accounts_' + new Date().toISOString().split('T')[0] + '.csv';
                        link.click();
                        URL.revokeObjectURL(link);

                        showToast('Chart of Accounts exported successfully', 'success');
                    } catch (error) {
                        console.error('Export error:', error);
                        showToast('Failed to export chart of accounts', 'error');
                    }
                });
            }

            // PDF export
            const pdfBtn = document.getElementById('account-pdf');
            if (pdfBtn) {
                pdfBtn.addEventListener('click', function () {
                    showToast('PDF export functionality not implemented yet', 'info');
                });
            }

            // Refresh functionality
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function () {
                    table.ajax.reload(null, false);
                    updateAccountStatistics();
                    showToast('Data refreshed', 'success');
                });
            }

            function updateAccountStatistics() {
                // This would normally fetch from server, but for now we'll calculate from current table data
                const info = table.page.info();
                if (totalAccounts) {
                    totalAccounts.textContent = info.recordsTotal || 0;
                }
                // Additional statistics would be fetched from server
            }

            function updateActiveFiltersIndicator() {
                const basicFiltersActive =
                    (filterField && filterField.value && filterField.value !== 'all') ||
                    (filterType && filterType.value && filterType.value !== 'contains') ||
                    (filterValue && filterValue.value && filterValue.value.trim() !== '');

                const advancedFiltersActive =
                    (typeFilter && typeFilter.value) ||
                    (categoryFilter && categoryFilter.value) ||
                    (statusFilter && statusFilter.value) ||
                    (levelFilter && levelFilter.value);

                if (activeFiltersIndicator) {
                    if (basicFiltersActive || advancedFiltersActive) {
                        activeFiltersIndicator.classList.remove('hidden');
                        activeFiltersIndicator.classList.add('flex');
                    } else {
                        activeFiltersIndicator.classList.add('hidden');
                        activeFiltersIndicator.classList.remove('flex');
                    }
                }
            }

            // Accounts Tree rendering
            const treeContainer = document.getElementById('accounts-tree');

            function renderAccountsTree(nodes, container, level = 0) {
                if (!container) {
                    return;
                }

                container.innerHTML = '';

                if (!Array.isArray(nodes) || !nodes.length) {
                    const empty = document.createElement('div');
                    empty.className = 'text-xs text-slate-500 dark:text-slate-400';
                    empty.textContent = 'No accounts found.';
                    container.appendChild(empty);
                    return;
                }

                const list = document.createElement('ul');
                list.className = 'space-y-0.5';

                nodes.forEach((node) => {
                    const hasChildren = Array.isArray(node.children) && node.children.length > 0;

                    const item = document.createElement('li');
                    item.className = 'group';

                    const row = document.createElement('div');
                    row.className = 'flex items-center rounded-md px-2 py-1 cursor-pointer hover:bg-slate-100 dark:hover:bg-darkmode-600 text-[13px]';

                    const indentLevel = Math.max((node.level || level || 1) - 1, 0);
                    row.style.marginLeft = `${indentLevel * 1.0}rem`;

                    const toggle = document.createElement('button');
                    toggle.type = 'button';
                    toggle.className = 'mr-1 flex h-4 w-4 items-center justify-center text-[11px] text-slate-400 group-hover:text-slate-600';
                    toggle.textContent = hasChildren ? '▾' : '·';

                    const icon = document.createElement('span');
                    icon.className = 'mr-2 text-slate-500 flex items-center justify-center';
                    icon.setAttribute('data-lucide', hasChildren ? 'folder' : 'file');
                    icon.style.width = '14px';
                    icon.style.height = '14px';

                    const label = document.createElement('span');
                    label.className = 'truncate text-[12px] text-slate-700 dark:text-slate-200';
                    label.textContent = `${node.code || ''}${node.code && node.name ? ' - ' : ' '}${node.name || ''}`.trim();

                    row.appendChild(toggle);
                    row.appendChild(icon);
                    row.appendChild(label);

                    if (!node.is_active) {
                        const inactive = document.createElement('span');
                        inactive.className = 'ml-2 text-[10px] uppercase tracking-wide text-rose-500';
                        inactive.textContent = 'inactive';
                        row.appendChild(inactive);
                    }

                    item.appendChild(row);

                    if (hasChildren) {
                        const childrenContainer = document.createElement('div');
                        childrenContainer.className = 'mt-0.5 space-y-0.5 border-l border-slate-200 dark:border-darkmode-500 ml-3 pl-2';
                        renderAccountsTree(node.children, childrenContainer, (node.level || level || 1) + 1);

                        let expanded = true;

                        toggle.addEventListener('click', (event) => {
                            event.stopPropagation();
                            expanded = !expanded;
                            childrenContainer.style.display = expanded ? '' : 'none';
                            toggle.textContent = expanded ? '▾' : '▸';
                        });

                        item.appendChild(childrenContainer);
                    }

                    list.appendChild(item);
                });

                container.appendChild(list);

                // Re-init Lucide icons for dynamically added nodes
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }
            }

            function loadAccountsTree() {
                if (!treeContainer) {
                    return;
                }

                fetch('{{ route("accounting.chart-of-accounts.tree") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                })
                    .then((response) => response.json())
                    .then((payload) => {
                        if (!payload || payload.success === false) {
                            throw new Error(payload?.message || 'Failed to load accounts tree');
                        }
                        renderAccountsTree(payload.data || [], treeContainer);
                    })
                    .catch((error) => {
                        console.error('Error loading accounts tree:', error);
                        if (treeContainer) {
                            treeContainer.innerHTML = '<div class="text-xs text-red-500">Failed to load accounts tree.</div>';
                        }
                    });
            }

            loadAccountsTree();
        });

    } catch (error) {
        console.error('❌ Error loading accounting page:', error);
    }
    </script>
@endpush
