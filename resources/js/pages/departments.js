// Departments Page JavaScript
export function initializeDepartmentsPage() {
    const tableEl = document.getElementById('departments-table');

    if (!tableEl) {
        return;
    }

    const datatableUrl = tableEl.dataset.departmentsDatatableUrl;
    const deleteUrlBase = tableEl.dataset.departmentsDeleteUrlBase;
    // New filters
    const filterValue = document.getElementById('departments-filter-value');
    const companyFilter = document.getElementById('company-filter');
    const statusFilter = document.getElementById('status-filter');
    const lengthSelect = document.getElementById('departments-filter-length');
    const filterResetBtn = document.getElementById('departments-filter-reset');
    const exportBtn = document.getElementById('departments-export');
    const pdfBtn = document.getElementById('departments-export-pdf');
    const printBtn = document.getElementById('departments-print');
    const exportPdfForm = document.getElementById('departments-export-pdf-form');
    const exportExcelForm = document.getElementById('departments-export-excel-form');
    const refreshBtn = document.getElementById('departments-refresh');
    const createForm = document.getElementById('create-department-form');
    const codeInput = createForm?.querySelector('#code');
    const editForm = document.getElementById('edit-department-form');
    const editTrigger = document.getElementById('edit-department-trigger');
    const updateUrlBase = editForm?.dataset.updateUrlBase;
    const createPreviewUrl = createForm?.dataset.previewUrl;

    let searchTimeout = null;

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined' || typeof window.erpCrud?.initDataTable !== 'function') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;
        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

        const tableInstance = window.erpCrud.initDataTable({
            tableSelector: '#departments-table',
            ajaxUrl: datatableUrl,
            ajaxData: function (d) {
                d.search_value = filterValue?.value?.trim() || '';
                d.company_id = companyFilter?.value || '';
                d.status = statusFilter?.value || '';
                d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
            },
            pageLength: initialLength,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap text-center font-medium', orderable: false },
                { data: 'code', name: 'code', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap', defaultContent: '-' },
                { data: 'name', name: 'name', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                {
                    data: 'company',
                    name: 'company.name',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                    render: (data) => (data && data.name ? data.name : '-')
                },
                {
                    data: 'manager',
                    name: 'manager.full_name',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                    render: (data) => (data && data.full_name ? data.full_name : '-')
                },
                { data: 'employees_count', name: 'employees_count', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center whitespace-nowrap font-medium' },
                {
                    data: 'is_active',
                    name: 'is_active',
                    className: 'text-center',
                    render: (value) => (window.erpCrud?.renderStatusBadge ? window.erpCrud.renderStatusBadge(value) : (value ? 'Active' : 'Inactive'))
                },
                { data: 'actions', name: 'actions', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
            ]
        });

        if (!tableInstance) {
            return;
        }

        // Stats elements
        const statsTotal = document.getElementById('stats-total');
        const statsActive = document.getElementById('stats-active');
        const statsInactive = document.getElementById('stats-inactive');

        // Update stats based on current filters
        const updateStats = () => {
            const params = new URLSearchParams();
            if (filterValue?.value?.trim()) params.append('search_value', filterValue.value.trim());
            if (companyFilter?.value) params.append('company_id', companyFilter.value);

            fetch(datatableUrl.replace('/datatable', '/stats') + '?' + params.toString(), {
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (statsTotal) statsTotal.textContent = data.total;
                if (statsActive) statsActive.textContent = data.active;
                if (statsInactive) statsInactive.textContent = data.inactive;
            })
            .catch(() => {});
        };

        const reloadTable = () => {
            tableInstance.ajax.reload(null, false);
            updateStats();
        };

        // Search with debounce
        filterValue?.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadTable, 400);
        });

        // Instant filter on dropdown change
        companyFilter?.addEventListener('change', reloadTable);
        statusFilter?.addEventListener('change', reloadTable);

        lengthSelect?.addEventListener('change', () => {
            const newLength = parseInt(lengthSelect.value, 10) || initialLength;
            tableInstance.page.len(newLength).draw();
        });

        filterResetBtn?.addEventListener('click', () => {
            if (filterValue) filterValue.value = '';
            if (companyFilter) companyFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (lengthSelect) {
                lengthSelect.value = '10';
                tableInstance.page.len(10).draw();
            }
            reloadTable();
        });
        refreshBtn?.addEventListener('click', reloadTable);
        printBtn?.addEventListener('click', () => window.print());

        const refreshDepartmentCode = () => {
            if (!createPreviewUrl || !codeInput) {
                return;
            }

            fetch(createPreviewUrl)
                .then((response) => (response.ok ? response.json() : Promise.reject(new Error('Preview code failed'))))
                .then((data) => {
                    codeInput.value = data.code || '';
                })
                .catch(() => {
                    codeInput.value = '';
                });
        };

        // Refresh code immediately on page load when the create form exists
        if (createForm) {
            refreshDepartmentCode();

            document.addEventListener('show.tw.modal', (event) => {
                if (event.target?.id === 'create-department-modal') {
                    refreshDepartmentCode();
                }
            });
        }

        if (window.erpCrud) {
            window.erpCrud.handleCreateForm({
                formSelector: '#create-department-form',
                modalSelector: '#create-department-modal',
                onSuccess: () => {
                    refreshDepartmentCode();
                    reloadTable();
                }
            });

            window.erpCrud.handleEditForm({
                formSelector: '#edit-department-form',
                modalSelector: '#edit-department-modal',
                onSuccess: () => reloadTable()
            });

            window.erpCrud.handleDelete({
                urlBuilder: (id) => `${deleteUrlBase}/${id}`,
                onSuccess: () => reloadTable()
            });
        }

        window.openDepartmentEditModal = function (payload) {
            if (!payload || !editForm || !editTrigger) {
                return;
            }

            editForm.action = updateUrlBase ? `${updateUrlBase}/${payload.id}` : editForm.action;

            const setValue = (selector, value) => {
                const el = editForm.querySelector(selector);
                if (el) {
                    el.value = value ?? '';
                }
            };

            setValue('#edit-department-name', payload.name || '');
            setValue('#edit-department-description', payload.description || '');
            setValue('#edit-department-parent_id', payload.parent_id ?? '');
            setValue('#edit-department-manager_id', payload.manager_id ?? '');

            editTrigger.click();
        };

        exportBtn?.addEventListener('click', () => {
            if (exportExcelForm) {
                exportExcelForm.submit();
            } else {
                console.warn('[Departments] Export Excel form not found');
            }
        });

        pdfBtn?.addEventListener('click', () => {
            if (exportPdfForm) {
                exportPdfForm.submit();
            } else {
                console.warn('[Departments] Export PDF form not found');
            }
        });
    };

    waitForDependencies();
}

// Auto-initialize
window.initializeDepartmentsPage = initializeDepartmentsPage;
