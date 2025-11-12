@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Shift Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Shift Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-shift-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Shift
        </x-base.button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="shifts-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="shifts-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="code">Code</option>
                                    <option value="name">Name</option>
                                    <option value="company">Company</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="shifts-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="shifts-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Display
                                </label>
                                <x-base.form-select id="shifts-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="shifts-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Search
                                </x-base.button>
                                <x-base.button id="shifts-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="shifts-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="shifts-refresh" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                            <x-base.button id="shifts-clear-cache" variant="outline-warning" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Trash2" class="mr-2 h-4 w-4" /> Clear Cache
                            </x-base.button>
                            <x-base.button id="shifts-cache-stats" variant="outline-info" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="BarChart3" class="mr-2 h-4 w-4" /> Cache Stats
                            </x-base.button>
                            <div id="connection-status" class="flex items-center px-3 py-2 text-sm">
                                <div class="w-2 h-2 rounded-full bg-green-500 mr-2" id="connection-dot"></div>
                                <span id="connection-text">Online</span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="shifts-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Working Hours</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Color</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Apply To</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
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

    @include('hr.shifts.modals.create')
    @stack('shift-modals')
@endsection

@push('scripts')
    <script src="{{ asset('js/data-cache-manager.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            console.log('🚀 Loading shifts page...');

            // Initialize DataTable
            const filterField = document.getElementById('shifts-filter-field');
            const filterType = document.getElementById('shifts-filter-type');
            const filterValue = document.getElementById('shifts-filter-value');
            const lengthSelect = document.getElementById('shifts-filter-length');
            const filterGoBtn = document.getElementById('shifts-filter-go');
            const filterResetBtn = document.getElementById('shifts-filter-reset');
            const exportBtn = document.getElementById('shifts-export');
            const refreshBtn = document.getElementById('shifts-refresh');

            const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

            // Preload essential data first
            Promise.all([
                preloadCompanies(),
                // Load departments for first company if available
                preloadCompanies().then(companies => {
                    if (companies && companies.length > 0) {
                        return preloadDepartments(companies[0].id);
                    }
                }).catch(() => null)
            ]).then(() => {
                console.log('🎯 Essential data loaded, initializing DataTable...');
                initializeDataTable();
            }).catch(error => {
                console.error('Failed to preload data, initializing DataTable anyway:', error);
                initializeDataTable();
            });

            function initializeDataTable() {
                const table = createOfflineDataTable('#shifts-table', {
                ajax: {
                    url: '{{ route("hr.shifts.datatable") }}',
                    type: 'GET',
                    data: function (d) {
                        if (filterField) {
                            d.filter_field = filterField.value || 'all';
                        }
                        if (filterType) {
                            d.filter_type = filterType.value || 'contains';
                        }
                        if (filterValue) {
                            d.filter_value = filterValue.value || '';
                        }
                        d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                    },
                    error: function (xhr, textStatus, error) {
                        console.error('❌ Error loading shift data:', textStatus, error, xhr.responseText);
                        console.error('Requested URL:', '{{ route("hr.shifts.datatable") }}');
                        console.error('Request data:', xhr);
                    },
                    success: function (data) {
                        console.log('✅ Shift data loaded successfully:', data);
                    }
                },
                pageLength: initialLength,
                lengthChange: false,
                searching: false,
                order: [[2, 'asc']], // Order by name column (index 2)
                dom:
                    "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium' },
                    { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'formatted_time', name: 'formatted_time', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                    {
                        data: 'color',
                        name: 'color',
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        render: function(data) {
                            return '<div class="flex items-center justify-center"><div class="w-6 h-6 rounded-full border-2 border-gray-300" style="background-color: ' + data + '"></div></div>';
                        }
                    },
                    { data: 'applicable_text', name: 'applicable_text', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        className: 'text-center',
                        render: function(value) {
                            var status = Boolean(value);
                            var badgeClass = status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                            var label = status ? 'Active' : 'Inactive';
                            return '<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ' + badgeClass + '">' + label + '</span>';
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
                rawColumns: ['status', 'actions'],
                drawCallback: function () {
                    if (typeof window.Lucide !== 'undefined') {
                        window.Lucide.createIcons();
                    }
                }
            });

            // Handle filters
            if (lengthSelect) {
                lengthSelect.addEventListener('change', function () {
                    const newLength = parseInt(this.value, 10) || initialLength;
                    table.page.len(newLength).draw();
                });
            }

            const reloadTable = function () {
                table.ajax.reload(null, false);
            };

            // Make it global
            window.reloadTable = reloadTable;

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
                    reloadTable();
                });
            }

            if (refreshBtn) {
                refreshBtn.addEventListener('click', reloadTable);
            }

            // Clear cache button
            if (document.getElementById('shifts-clear-cache')) {
                document.getElementById('shifts-clear-cache').addEventListener('click', function() {
                    if (confirm('Are you sure you want to clear all cached data?')) {
                        // Clear localStorage cache
                        OfflineManager.clearData();

                        // Clear dataCache
                        if (typeof window.dataCache !== 'undefined') {
                            window.dataCache.clear();
                        }

                        showToast('Cache cleared successfully', 'success');
                        reloadTable();
                    }
                });
            }

            // Cache stats button
            if (document.getElementById('shifts-cache-stats')) {
                document.getElementById('shifts-cache-stats').addEventListener('click', function() {
                    if (typeof window.dataCache !== 'undefined') {
                        const stats = window.dataCache.getStats();
                        let message = `📊 Cache Statistics:\n`;
                        message += `Total cached items: ${stats.totalItems}\n`;
                        message += `Items currently loading: ${stats.loadingItems}\n\n`;

                        if (stats.items.length > 0) {
                            message += `Cached items:\n`;
                            stats.items.forEach(item => {
                                const age = Math.round(item.age / 1000 / 60); // minutes
                                message += `- ${item.key}: ${age}min old, ${item.size} bytes\n`;
                            });
                        } else {
                            message += `No items in cache`;
                        }

                        alert(message);
                    } else {
                        showToast('Cache manager not available', 'warning');
                    }
                });
            }

            // Update connection status
            function updateConnectionStatus() {
                const dot = document.getElementById('connection-dot');
                const text = document.getElementById('connection-text');

                if (OfflineManager.isOnline()) {
                    dot.className = 'w-2 h-2 rounded-full bg-green-500 mr-2';
                    text.textContent = 'Online';
                } else {
                    dot.className = 'w-2 h-2 rounded-full bg-red-500 mr-2';
                    text.textContent = 'Offline';
                }
            }

            // Initial status
            updateConnectionStatus();

            // Monitor online/offline status
            window.addEventListener('online', function() {
                console.log('🌐 Back online - syncing data...');
                OfflineManager.syncData();
                updateConnectionStatus();
                showToast('Back online - data synced', 'success');
            });

            window.addEventListener('offline', function() {
                console.log('📴 Gone offline - using local data');
                updateConnectionStatus();
                showToast('You are offline - using cached data', 'warning');
            });

            // Handle export
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    try {
                        const rows = table.rows({ search: 'applied' }).data().toArray();
                        if (!rows.length) {
                            showToast('No data to export', 'error');
                            return;
                        }

                        const headers = ['#', 'Code', 'Name', 'Working Hours', 'Color', 'Apply To', 'Status'];
                        const csvRows = [headers.join(',')];

                        rows.forEach(function (row) {
                            const csvRow = [
                                row.DT_RowIndex,
                                '"' + (row.code || '').replace(/"/g, '""') + '"',
                                '"' + (row.name || '').replace(/"/g, '""') + '"',
                                '"' + (row.formatted_time || '').replace(/"/g, '""') + '"',
                                row.color || '',
                                '"' + (row.applicable_text || '').replace(/"/g, '""') + '"',
                                row.is_active ? 'Active' : 'Inactive'
                            ];
                            csvRows.push(csvRow.join(','));
                        });

                        const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = `shifts_${new Date().toISOString().split('T')[0]}.csv`;
                        link.click();
                        URL.revokeObjectURL(link);

                        showToast('Data exported successfully', 'success');
                    } catch (error) {
                        console.error('Export error:', error);
                        showToast('Failed to export data', 'error');
                    }
                });
            }

            console.log('✅ Shifts page loaded successfully');

        } catch (error) {
            console.error('❌ Error loading shifts page:', error);
        }
    });

    // Global functions
    window.deleteShift = function (id, name) {
        if (!confirm(`Are you sure you want to delete the shift "${name}"?`)) {
            return;
        }

        fetch(`{{ route('hr.shifts.destroy', '') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.reloadTable) {
                    window.reloadTable();
                } else {
                    location.reload();
                }
                showToast(data.message || 'Shift deleted successfully', 'success');
            } else {
                showToast(data.message || 'Failed to delete shift', 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting shift:', error);
            showToast('An error occurred while deleting', 'error');
        });
    };

    window.toggleShiftStatus = function (id) {
        fetch(`{{ route('hr.shifts.toggle-status', '') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.reloadTable) {
                    window.reloadTable();
                } else {
                    location.reload();
                }
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Failed to update shift status', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating shift status:', error);
            showToast('An error occurred while updating', 'error');
        });
    };

    // Database Service for offline/online data management
    const DatabaseService = {
        // API base URL
        apiUrl: window.location.origin,

        // Cache settings
        cacheExpiry: 5 * 60 * 1000, // 5 minutes in milliseconds

        // Make API request with offline fallback
        async request(endpoint, options = {}) {
            const cacheKey = `cache_${endpoint}_${JSON.stringify(options.body || {})}`;

            // Check if offline
            if (!OfflineManager.isOnline()) {
                console.log('📴 Offline mode - using cached data');
                const cachedData = OfflineManager.getData(cacheKey);
                if (cachedData && this.isCacheValid(cachedData.timestamp)) {
                    return cachedData.data;
                } else {
                    throw new Error('No cached data available and offline');
                }
            }

            try {
                const response = await fetch(`${this.apiUrl}${endpoint}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        ...options.headers
                    },
                    ...options
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();

                // Cache the response
                OfflineManager.storeData(cacheKey, {
                    data: data,
                    timestamp: Date.now()
                });

                return data;
            } catch (error) {
                console.error('API request failed:', error);

                // Try to use cached data as fallback
                const cachedData = OfflineManager.getData(cacheKey);
                if (cachedData && this.isCacheValid(cachedData.timestamp)) {
                    console.log('📦 Using cached data as fallback');
                    return cachedData.data;
                }

                throw error;
            }
        },

        // Check if cache is still valid
        isCacheValid(timestamp) {
            return (Date.now() - timestamp) < this.cacheExpiry;
        },

        // CRUD operations
        async get(endpoint, params = {}) {
            const queryString = new URLSearchParams(params).toString();
            const url = queryString ? `${endpoint}?${queryString}` : endpoint;
            return this.request(url, { method: 'GET' });
        },

        async post(endpoint, data) {
            return this.request(endpoint, {
                method: 'POST',
                body: JSON.stringify(data)
            });
        },

        async put(endpoint, data) {
            return this.request(endpoint, {
                method: 'PUT',
                body: JSON.stringify(data)
            });
        },

        async delete(endpoint) {
            return this.request(endpoint, { method: 'DELETE' });
        }
    };

// Data Preloader - تحميل البيانات الأساسية مسبقاً
const DataPreloader = {
    // البيانات المحملة
    data: {
        companies: null,
        departments: null,
        employees: null,
        shifts: null
    },

    // حالة التحميل
    loading: {
        companies: false,
        departments: false,
        employees: false,
        shifts: false
    },

    // تحميل البيانات الأساسية
    async preloadEssentialData() {
        console.log('🔄 Preloading essential data...');

        // تحميل الشركات
        if (!this.data.companies) {
            this.loading.companies = true;
            try {
                this.data.companies = await DatabaseService.get('/hr/employees/companies');
                OfflineManager.storeData('companies', this.data.companies);
                console.log('✅ Companies loaded:', this.data.companies?.length || 0);
            } catch (error) {
                console.error('❌ Failed to load companies:', error);
                // استخدم البيانات المحلية كبديل
                this.data.companies = OfflineManager.getData('companies');
            }
            this.loading.companies = false;
        }

        // تحميل الأقسام إذا كانت هناك شركات
        if (this.data.companies && this.data.companies.length > 0) {
            await this.preloadDepartmentsForCompany(this.data.companies[0]?.id);
        }

        console.log('✅ Essential data preloaded');
    },

    // تحميل الأقسام لشركة معينة
    async preloadDepartmentsForCompany(companyId) {
        if (!companyId || this.loading.departments) return;

        this.loading.departments = true;
        try {
            const cacheKey = `departments_${companyId}`;
            this.data.departments = await DatabaseService.get(`/hr/departments/api/company/${companyId}`);
            OfflineManager.storeData(cacheKey, this.data.departments);
            console.log('✅ Departments loaded for company:', companyId, this.data.departments?.length || 0);
        } catch (error) {
            console.error('❌ Failed to load departments:', error);
            this.data.departments = OfflineManager.getData(`departments_${companyId}`);
        }
        this.loading.departments = false;
    },

    // تحميل الموظفين لقسم معين
    async preloadEmployeesForDepartment(departmentId) {
        if (!departmentId || this.loading.employees) return;

        this.loading.employees = true;
        try {
            const cacheKey = `employees_${departmentId}`;
            this.data.employees = await DatabaseService.get(`/hr/employees/positions/department?department_id=${departmentId}`);
            OfflineManager.storeData(cacheKey, this.data.employees);
            console.log('✅ Employees loaded for department:', departmentId, this.data.employees?.length || 0);
        } catch (error) {
            console.error('❌ Failed to load employees:', error);
            this.data.employees = OfflineManager.getData(`employees_${departmentId}`);
        }
        this.loading.employees = false;
    },

    // الحصول على البيانات المحملة
    getCompanies() {
        return this.data.companies || [];
    },

    getDepartments() {
        return this.data.departments || [];
    },

    getEmployees() {
        return this.data.employees || [];
    },

    // تحديث البيانات
    async refreshData(type) {
        switch(type) {
            case 'companies':
                this.data.companies = null;
                await this.preloadEssentialData();
                break;
            case 'departments':
                this.data.departments = null;
                if (this.data.companies?.length > 0) {
                    await this.preloadDepartmentsForCompany(this.data.companies[0].id);
                }
                break;
            case 'employees':
                this.data.employees = null;
                // سيتم تحميلها عند الحاجة
                break;
        }
    }
};

// Make DataPreloader globally available
window.DataPreloader = DataPreloader;

// Enhanced table with offline support
function createOfflineDataTable(selector, config) {
        if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            console.error('jQuery or DataTables not loaded yet, retrying...');
            setTimeout(() => createOfflineDataTable(selector, config), 100);
            return null;
        }

        const originalAjax = config.ajax;

        config.ajax = function(data, callback, settings) {
            if (!OfflineManager.isOnline()) {
                // Offline mode - use cached data
                console.log('📴 Loading data from cache...');
                const cacheKey = 'datatable_shifts';
                const cachedData = OfflineManager.getData(cacheKey);

                if (cachedData && DatabaseService.isCacheValid(cachedData.timestamp)) {
                    callback({
                        draw: data.draw,
                        recordsTotal: cachedData.data.length,
                        recordsFiltered: cachedData.data.length,
                        data: cachedData.data
                    });
                    showToast('Using cached data (offline)', 'info');
                } else {
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: [],
                        error: 'No cached data available'
                    });
                    showToast('No data available offline', 'warning');
                }
                return;
            }

            // Online mode - make API call
            DatabaseService.get(originalAjax.url, data)
                .then(response => {
                    // Cache the data
                    OfflineManager.storeData('datatable_shifts', {
                        data: response.data || [],
                        timestamp: Date.now()
                    });

                    callback({
                        draw: data.draw,
                        recordsTotal: response.recordsTotal || 0,
                        recordsFiltered: response.recordsFiltered || 0,
                        data: response.data || []
                    });
                })
                .catch(error => {
                    console.error('DataTable AJAX error:', error);
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        data: [],
                        error: error.message
                    });
                });
        };

        return $(selector).DataTable(config);
    }

    window.viewShift = function (id) {
        console.log('Viewing shift details:', id);
        // Modal for viewing details can be added here
        showToast('View shift details coming soon', 'info');
    };
    </script>
@endpush
