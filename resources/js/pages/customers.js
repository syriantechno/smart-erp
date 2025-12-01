// Customers Page JavaScript
export function initializeCustomersPage() {
    const tableEl = document.getElementById('customers-table');

    if (!tableEl) {
        return;
    }

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined' || typeof window.erpCrud?.initDataTable !== 'function') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;

        // DataTable filters & controls
        const filterField = document.getElementById('customers-filter-field');
        const filterType = document.getElementById('customers-filter-type');
        const filterValue = document.getElementById('customers-filter-value');
        const statusFilter = document.getElementById('customers-filter-status');
        const lengthSelect = document.getElementById('customers-filter-length');
        const filterResetBtn = document.getElementById('customers-filter-reset');
        const refreshBtn = document.getElementById('customers-refresh');
        const printBtn = document.getElementById('customers-print');
        const exportPdfBtn = document.getElementById('customers-export-pdf');
        const exportExcelBtn = document.getElementById('customers-export');
        const exportPdfForm = document.getElementById('customers-export-pdf-form');
        const exportExcelForm = document.getElementById('customers-export-excel-form');
        const exportFieldInput = document.getElementById('customers-export-field');
        const exportTypeInput = document.getElementById('customers-export-type');
        const exportValueInput = document.getElementById('customers-export-value');
        const exportStatusInput = document.getElementById('customers-export-status');
        const exportExcelFieldInput = document.getElementById('customers-export-excel-field');
        const exportExcelTypeInput = document.getElementById('customers-export-excel-type');
        const exportExcelValueInput = document.getElementById('customers-export-excel-value');
        const exportExcelStatusInput = document.getElementById('customers-export-excel-status');
        const createForm = document.getElementById('create-customer-form');
        const previewCodeUrl = createForm?.dataset.previewUrl || null;
        const accountsUrl = createForm?.dataset.accountsUrl || null;

        let searchTimeout = null;

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 25 : 25;

        const table = window.erpCrud.initDataTable({
            tableSelector: '#customers-table',
            ajaxUrl: tableEl.dataset.customersDatatableUrl,
            ajaxData: function (d) {
                d.field = $('#customers-filter-field').val();
                d.type = $('#customers-filter-type').val();
                d.value = $('#customers-filter-value').val();
                d.status = $('#customers-filter-status').val();
                d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
            },
            pageLength: initialLength,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                { data: 'customer_type', name: 'customer_type', className: 'px-5 py-3 border-b dark:border-darkmode-300 capitalize' },
                { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                { data: 'phone', name: 'phone', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                { data: 'credit_limit_formatted', name: 'credit_limit', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                { data: 'linked_account', name: 'linked_account', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                {
                    data: 'status',
                    name: 'status',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    render: function (value) {
                        if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                            return window.erpCrud.renderStatusBadge(value === 'active');
                        }
                        const isActive = value === 'active';
                        const badgeClass = isActive
                            ? 'bg-green-100 text-green-700'
                            : value === 'inactive'
                                ? 'bg-red-100 text-red-700'
                                : 'bg-yellow-100 text-yellow-700';
                        const label = isActive ? 'Active' : value === 'inactive' ? 'Inactive' : 'Suspended';
                        return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    searchable: false,
                }
            ],
            drawCallback: function () {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
                } else if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                    lucide.createIcons();
                }
            },
        });

        window.customersTable = table;

        const reloadTable = () => {
            table.ajax.reload(null, false);
        };

        // Filters behavior (aligned with departments)
        filterValue?.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadTable, 400);
        });

        filterField?.addEventListener('change', reloadTable);
        filterType?.addEventListener('change', reloadTable);
        statusFilter?.addEventListener('change', reloadTable);

        filterResetBtn?.addEventListener('click', function () {
            if (filterField) filterField.value = 'all';
            if (filterType) filterType.value = 'contains';
            if (filterValue) filterValue.value = '';
            if (statusFilter) statusFilter.value = '';
            if (lengthSelect) {
                lengthSelect.value = String(initialLength);
                table.page.len(initialLength).draw();
            }
            reloadTable();
        });

        refreshBtn?.addEventListener('click', () => {
            reloadTable();

            if (typeof window.showSuccess === 'function') {
                window.showSuccess('Customers list refreshed');
            } else if (typeof window.showToast === 'function') {
                window.showToast('Customers list refreshed', 'info');
            }
        });

        lengthSelect?.addEventListener('change', function () {
            const newLength = parseInt(this.value, 10) || initialLength;
            table.page.len(newLength).draw();
        });

        printBtn?.addEventListener('click', () => window.print());

        const syncExportFilters = () => {
            const fieldVal = filterField?.value || 'all';
            const typeVal = filterType?.value || 'contains';
            const valueVal = filterValue?.value || '';
            const statusVal = statusFilter?.value ?? '';

            if (exportFieldInput) exportFieldInput.value = fieldVal;
            if (exportTypeInput) exportTypeInput.value = typeVal;
            if (exportValueInput) exportValueInput.value = valueVal;
            if (exportStatusInput) exportStatusInput.value = statusVal;

            if (exportExcelFieldInput) exportExcelFieldInput.value = fieldVal;
            if (exportExcelTypeInput) exportExcelTypeInput.value = typeVal;
            if (exportExcelValueInput) exportExcelValueInput.value = valueVal;
            if (exportExcelStatusInput) exportExcelStatusInput.value = statusVal;
        };

        exportPdfBtn?.addEventListener('click', () => {
            if (exportPdfForm) {
                syncExportFilters();
                exportPdfForm.submit();
            } else {
                console.warn('[Customers] Export PDF form not found');
            }
        });

        exportExcelBtn?.addEventListener('click', () => {
            if (exportExcelForm) {
                syncExportFilters();
                exportExcelForm.submit();
            } else {
                console.warn('[Customers] Export Excel form not found');
            }
        });

        // Modal helpers
        window.refreshCustomerCode = function () {
            const codeInput = document.getElementById('create-customer-code');
            if (!codeInput || !previewCodeUrl) return;

            fetch(previewCodeUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to preview customer code');
                    }
                    return response.json();
                })
                .then(data => {
                    const code = data.code || '-';
                    codeInput.value = code;
                })
                .catch(() => {
                    codeInput.value = '-';
                });
        };

        window.loadAccountsForCustomer = function () {
            const accountSelect = document.getElementById('create-customer-account');
            if (!accountSelect || !accountsUrl) return;

            accountSelect.innerHTML = '<option value="">Auto-create account</option>';

            fetch(accountsUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load accounts');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.data) {
                        data.data.forEach(account => {
                            const option = document.createElement('option');
                            option.value = account.id;
                            option.textContent = account.text;
                            accountSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading accounts:', error);
                });
        };

        if (createForm) {
            window.refreshCustomerCode();

            document.addEventListener('show.tw.modal', (event) => {
                if (event.target?.id === 'create-customer-modal') {
                    window.refreshCustomerCode();
                    window.loadAccountsForCustomer();
                }
            });
        }

        if (window.erpCrud) {
            window.erpCrud.handleDelete({
                urlBuilder: (id) => `/customers/${id}`,
                onSuccess: () => reloadTable(),
            });
        }

        window.viewCustomer = function (id) {
            if (typeof window.showInfo === 'function') {
                window.showInfo('Customer details view is coming soon.');
            } else {
                console.info('[Customers] viewCustomer', id);
            }
        };

        window.editCustomer = function (id) {
            if (typeof window.showInfo === 'function') {
                window.showInfo('Customer edit is coming soon.');
            } else {
                console.info('[Customers] editCustomer', id);
            }
        };
    };

    waitForDependencies();
}

// Auto-initialize on window
window.initializeCustomersPage = initializeCustomersPage;
