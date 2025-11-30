// Positions Page JavaScript
export function initializePositionsPage() {
    const tableEl = document.getElementById('positions-table');

    if (!tableEl) {
        return;
    }

    const datatableUrl = tableEl.dataset.positionsDatatableUrl;
    const deleteUrlBase = tableEl.dataset.positionsDeleteUrlBase;
    // New filters
    const filterValue = document.getElementById('positions-filter-value');
    const departmentFilter = document.getElementById('department-filter');
    const statusFilter = document.getElementById('status-filter');
    const lengthSelect = document.getElementById('positions-filter-length');
    const filterResetBtn = document.getElementById('positions-filter-reset');
    const exportBtn = document.getElementById('positions-export');
    const pdfBtn = document.getElementById('positions-export-pdf');
    const printBtn = document.getElementById('positions-print');
    const exportPdfForm = document.getElementById('positions-export-pdf-form');
    const exportExcelForm = document.getElementById('positions-export-excel-form');
    const refreshBtn = document.getElementById('positions-refresh');
    const createForm = document.getElementById('create-position-form');
    const codeInput = createForm?.querySelector('#position-code');
    const editForm = document.getElementById('edit-position-form');
    const editTrigger = document.getElementById('edit-modal-trigger');
    const updateUrlBase = editForm?.dataset.updateUrlBase;

    let searchTimeout = null;

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined' || typeof window.erpCrud?.initDataTable !== 'function') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;
        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

        const tableInstance = window.erpCrud.initDataTable({
            tableSelector: '#positions-table',
            ajaxUrl: datatableUrl,
            ajaxData: function (d) {
                d.search_value = filterValue?.value?.trim() || '';
                d.department_id = departmentFilter?.value || '';
                d.status = statusFilter?.value || '';
                d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
            },
            pageLength: initialLength,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap text-center font-medium', orderable: false },
                { data: 'code', name: 'code', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap', defaultContent: '-' },
                { data: 'title', name: 'title', className: 'px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                {
                    data: 'department',
                    name: 'department.name',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                    render: (data) => (data && data.name ? data.name : '-')
                },
                {
                    data: 'salary_range',
                    name: 'salary_range_min',
                    className: 'px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap',
                },
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
            if (departmentFilter?.value) params.append('department_id', departmentFilter.value);

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
        departmentFilter?.addEventListener('change', reloadTable);
        statusFilter?.addEventListener('change', reloadTable);

        lengthSelect?.addEventListener('change', () => {
            const newLength = parseInt(lengthSelect.value, 10) || initialLength;
            tableInstance.page.len(newLength).draw();
        });

        filterResetBtn?.addEventListener('click', () => {
            if (filterValue) filterValue.value = '';
            if (departmentFilter) departmentFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (lengthSelect) {
                lengthSelect.value = '10';
                tableInstance.page.len(10).draw();
            }
            reloadTable();
        });
        refreshBtn?.addEventListener('click', reloadTable);
        printBtn?.addEventListener('click', () => window.print());

        const createPreviewUrl = createForm?.dataset.previewUrl;

        const refreshPositionCode = () => {
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

        if (createForm) {
            refreshPositionCode();

            document.addEventListener('show.tw.modal', (event) => {
                if (event.target?.id === 'create-position-modal') {
                    refreshPositionCode();
                }
            });
        }

        if (window.erpCrud) {
            window.erpCrud.handleCreateForm({
                formSelector: '#create-position-form',
                modalSelector: '#create-position-modal',
                onSuccess: () => {
                    refreshPositionCode();
                    reloadTable();
                }
            });

            window.erpCrud.handleEditForm({
                formSelector: '#edit-position-form',
                modalSelector: '#edit-position-modal',
                onSuccess: () => reloadTable()
            });

            window.erpCrud.handleDelete({
                urlBuilder: (id) => `${deleteUrlBase}/${id}`,
                onSuccess: () => reloadTable()
            });
        }

        window.openPositionEditModal = function (payload) {
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

            setValue('#edit-position-code', payload.code || '');
            setValue('#edit-title', payload.title || '');
            setValue('#edit-department_id', payload.department_id ?? '');
            setValue('#edit-salary_range_min', payload.salary_min ?? '');
            setValue('#edit-salary_range_max', payload.salary_max ?? '');
            setValue('#edit-description', payload.description || '');
            setValue('#edit-requirements', payload.requirements || '');

            editTrigger.click();
        };

        // Backwards compatibility for legacy inline handlers
        window.openEditModal = function (
            id,
            title,
            code,
            departmentId,
            salaryMin,
            salaryMax,
            description,
            requirements
        ) {
            window.openPositionEditModal?.({
                id,
                title,
                code,
                department_id: departmentId,
                salary_min: salaryMin,
                salary_max: salaryMax,
                description,
                requirements,
            });
        };

        window.deletePosition = function (id, name) {
            window.erpDeleteRecord?.(id, name);
        };

        exportBtn?.addEventListener('click', () => {
            if (exportExcelForm) {
                exportExcelForm.submit();
            } else {
                console.warn('[Positions] Export Excel form not found');
            }
        });

        pdfBtn?.addEventListener('click', () => {
            if (exportPdfForm) {
                exportPdfForm.submit();
            } else {
                console.warn('[Positions] Export PDF form not found');
            }
        });
    };

    waitForDependencies();
}

// Auto-initialize
window.initializePositionsPage = initializePositionsPage;
