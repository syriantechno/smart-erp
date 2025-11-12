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
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Chart of Accounts</h2>
        <div class="flex items-center gap-2">
            <x-base.button
                variant="outline-secondary"
                data-tw-toggle="modal"
                data-tw-target="#journal-entries-modal"
            >
                <x-base.lucide icon="BookOpen" class="w-4 h-4 mr-2" />
                Journal Entries
            </x-base.button>
            <x-base.button
                variant="primary"
                data-tw-toggle="modal"
                data-tw-target="#add-account-modal"
            >
                <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
                Add Account
            </x-base.button>
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
                        <span id="active-filters-indicator" class="hidden ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Active</span>
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
                    <div class="mt-4 flex justify-end">
                        <x-base.button id="apply-filters" variant="primary" size="sm">
                            <x-base.lucide icon="Search" class="w-4 h-4 mr-1" />
                            Apply Filters
                        </x-base.button>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
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
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="account-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="account-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="account-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="account-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
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

            // Statistics elements
            const totalAccounts = document.getElementById('total-accounts');
            const assetAccounts = document.getElementById('asset-accounts');
            const liabilityAccounts = document.getElementById('liability-accounts');
            const incomeAccounts = document.getElementById('income-accounts');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            const table = window.initDataTable('#account-table', {
                ajax: {
                    url: '{{ route("accounting.chart-of-accounts.datatable") }}',
                    type: 'GET',
                    data: function (d) {
                        console.log('DataTable sending data:', d);
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
                    error: function (xhr, textStatus, error) {
                        console.error('DataTables AJAX error:', textStatus, error, xhr.responseText);
                    }
                },
                pageLength: initialLength,
                lengthChange: false,
                searching: false,
                order: [[2, 'asc']],
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
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
                rawColumns: ['type_badge', 'status', 'actions'],
                drawCallback: function () {
                    console.log('DataTable draw callback - table data:', table.rows().data().toArray());
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                    updateAccountStatistics();
                }
            });

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

            function updateAccountStatistics() {
                // This would normally fetch from server, but for now we'll calculate from current table data
                const info = table.page.info();
                if (totalAccounts) {
                    totalAccounts.textContent = info.recordsTotal || 0;
                }
                // Additional statistics would be fetched from server
            }
        });

    } catch (error) {
        console.error('❌ Error loading accounting page:', error);
    }
    </script>
@endpush
