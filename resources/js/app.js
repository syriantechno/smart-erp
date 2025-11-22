// Load static files
import.meta.glob(["../images/**"]);

// Load theme settings for settings page
import './theme-settings';
import './erp/crud';

// Configure axios for CSRF protection
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set CSRF token for all axios requests
let token = document.head?.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

window.initializeDepartmentsPage = window.initializeDepartmentsPage || initializeDepartmentsPage;

function initializeAttendancePage() {
    const pageEl = document.getElementById('attendance-page');

    if (!pageEl) {
        return;
    }

    const indexUrl = pageEl.dataset.attendanceIndexUrl || window.location.pathname;
    const storeUrl = pageEl.dataset.attendanceStoreUrl;
    const attendanceTable = document.getElementById('attendance-table');
    const attendanceForm = document.getElementById('attendance-form');
    const addAttendanceBtn = document.getElementById('add-attendance-btn');
    const exportBtn = document.getElementById('export-btn');
    const loadMonthBtn = document.getElementById('load-month-btn');
    const yearSelect = document.getElementById('year-select');
    const monthSelect = document.getElementById('month-select');

    const toggleEntryType = (type) => {
        const employeeSelection = document.getElementById('employee-selection');
        const departmentSelection = document.getElementById('department-selection');
        const employeeField = attendanceForm?.querySelector('[name="employee_id"]');
        const departmentField = attendanceForm?.querySelector('[name="department_id"]');

        if (type === 'individual') {
            if (employeeSelection) {
                employeeSelection.style.display = 'block';
            }
            if (departmentSelection) {
                departmentSelection.style.display = 'none';
            }
            if (employeeField) {
                employeeField.required = true;
                employeeField.style.display = 'block';
            }
            if (departmentField) {
                departmentField.required = false;
                departmentField.style.display = 'none';
            }
        } else {
            if (employeeSelection) {
                employeeSelection.style.display = 'none';
            }
            if (departmentSelection) {
                departmentSelection.style.display = 'block';
            }
            if (departmentField) {
                departmentField.required = true;
                departmentField.style.display = 'block';
            }
            if (employeeField) {
                employeeField.required = false;
                employeeField.style.display = 'none';
            }
        }
    };

    const showModal = (modal) => {
        if (!modal) {
            return;
        }

        if (typeof window.twModal?.show === 'function') {
            window.twModal.show(modal);
            modal.style.zIndex = '99999';
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.style.zIndex = '99998';
            }
            return;
        }

        modal.style.display = 'block';
        modal.classList.add('show');
        modal.removeAttribute('aria-hidden');
        modal.style.zIndex = '99999';
        document.body.classList.add('modal-open');

        let backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.style.zIndex = '99998';
            document.body.appendChild(backdrop);
        }

        setTimeout(() => modal.focus(), 100);
    };

    const openAttendanceModal = (employeeId = null, date = null, status = null) => {
        const modal = document.getElementById('attendanceEntryModal');
        if (!modal || !attendanceForm) {
            return;
        }

        attendanceForm.reset();

        const individualRadio = attendanceForm.querySelector('input[name="entry_type"][value="individual"]');
        if (individualRadio) {
            individualRadio.checked = true;
            toggleEntryType('individual');
        }

        const dateField = attendanceForm.querySelector('[name="attendance_date"]');
        if (dateField) {
            const defaultDate = date || new Date().toISOString().split('T')[0];
            dateField.value = defaultDate;
        }

        if (employeeId && attendanceForm.employee_id) {
            attendanceForm.employee_id.value = employeeId;
        }

        if (status && attendanceForm.status) {
            attendanceForm.status.value = status;
        }

        if (typeof date !== 'undefined' && date && attendanceForm.attendance_date) {
            attendanceForm.attendance_date.value = date;
        }

        showModal(modal);
    };

    const closeAttendanceModal = () => {
        const modal = document.getElementById('attendanceEntryModal');
        if (!modal) {
            return;
        }

        const dismissTrigger = modal.querySelector('[data-tw-dismiss="modal"]');
        if (dismissTrigger) {
            dismissTrigger.click();
            return;
        }

        if (typeof window.twModal?.hide === 'function') {
            window.twModal.hide(modal);
        } else {
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    };

    const normalizeDate = (value) => {
        if (!value) {
            return '';
        }
        const parsed = new Date(value);
        if (Number.isNaN(parsed.getTime())) {
            return value;
        }
        const year = parsed.getFullYear();
        const month = String(parsed.getMonth() + 1).padStart(2, '0');
        const day = String(parsed.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const saveAttendance = () => {
        if (!attendanceForm) {
            return;
        }

        const formData = new FormData(attendanceForm);
        const data = Object.fromEntries(formData.entries());
        data.attendance_date = normalizeDate(data.attendance_date);

        if (data.entry_type === 'individual') {
            if (!data.employee_id) {
                window.showToast?.('Please select an employee', 'error');
                return;
            }
        } else if (data.entry_type === 'department') {
            if (!data.department_id) {
                window.showToast?.('Please select a department', 'error');
                return;
            }
        } else {
            window.showToast?.('Please select entry type', 'error');
            return;
        }

        if (!data.attendance_date) {
            window.showToast?.('Please select a date', 'error');
            return;
        }

        if (!data.status) {
            window.showToast?.('Please select a status', 'error');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const targetUrl = storeUrl || attendanceForm.action;

        if (!targetUrl) {
            window.showToast?.('Unable to submit attendance right now', 'error');
            return;
        }

        fetch(targetUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
            },
            body: JSON.stringify(data)
        })
            .then(async (response) => {
                let payload = null;
                try {
                    payload = await response.json();
                } catch (error) {
                    payload = null;
                }

                if (response.ok && payload?.success !== false) {
                    window.showToast?.(payload?.message || 'Attendance saved successfully', 'success');
                    closeAttendanceModal();
                    setTimeout(() => window.location.reload(), 800);
                    return;
                }

                const errorMessage = payload?.message || 'Failed to save attendance';
                window.showToast?.(errorMessage, 'error');
                if (payload?.errors) {
                    console.error('[Attendance] Validation errors:', payload.errors);
                }
            })
            .catch((error) => {
                console.error('[Attendance] Save failed:', error);
                window.showToast?.('Error occurred while saving', 'error');
            });
    };

    const exportAttendance = () => {
        const selectedYear = yearSelect?.value;
        const selectedMonth = monthSelect?.value;

        if (!selectedYear || !selectedMonth) {
            window.showToast?.('Please select year and month', 'error');
            return;
        }

        const headers = ['Employee'];
        for (let day = 1; day <= 31; day += 1) {
            headers.push(day.toString());
        }

        const rows = [headers.join(',')];
        const statusMap = {
            present: 'Present',
            absent: 'Absent',
            vacation: 'Vacation',
            travel: 'Travel',
            half_day: 'Half Day',
            holiday: 'Holiday',
            '': 'Not Recorded'
        };

        attendanceTable?.querySelectorAll('tbody tr').forEach((row) => {
            const employeeName = row.querySelector('td:first-child .font-bold')?.textContent?.trim() || '';
            const cells = [`"${employeeName.replace(/"/g, '""')}"`];

            row.querySelectorAll('td:not(:first-child)').forEach((cell) => {
                const status = cell.querySelector('.attendance-status-display')?.dataset.status || '';
                cells.push(`"${(statusMap[status] || '').replace(/"/g, '""')}"`);
            });

            rows.push(cells.join(','));
        });

        const blob = new Blob(['\ufeff' + rows.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `attendance_${selectedYear}_${selectedMonth}.csv`;
        link.click();
        URL.revokeObjectURL(link.href);

        window.showToast?.('Data exported successfully', 'success');
    };

    pageEl.querySelectorAll('.attendance-status-display').forEach((span) => {
        span.addEventListener('click', () => {
            const { employeeId, date, status } = span.dataset;
            openAttendanceModal(employeeId, date, status);
        });
    });

    addAttendanceBtn?.addEventListener('click', () => openAttendanceModal());

    attendanceForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        saveAttendance();
    });

    pageEl.querySelectorAll('input[name="entry_type"]').forEach((radio) => {
        radio.addEventListener('change', (event) => {
            toggleEntryType(event.target.value);
        });
    });

    exportBtn?.addEventListener('click', exportAttendance);

    loadMonthBtn?.addEventListener('click', () => {
        const selectedYear = yearSelect?.value;
        const selectedMonth = monthSelect?.value;

        if (!selectedYear || !selectedMonth) {
            window.showToast?.('Please select year and month', 'error');
            return;
        }

        const query = new URLSearchParams({ year: selectedYear, month: selectedMonth });
        window.location.href = `${indexUrl}?${query.toString()}`;
    });

    const initialType = attendanceForm?.querySelector('input[name="entry_type"]:checked')?.value || 'individual';
    toggleEntryType(initialType);

    window.openAttendanceModal = openAttendanceModal;
}

function initializeLeavePage() {
    const pageEl = document.getElementById('leave-page');

    if (!pageEl) {
        return;
    }

    const config = {
        datatableUrl: pageEl.dataset.leaveDatatableUrl,
        summaryUrl: pageEl.dataset.leaveSummaryUrl,
        previewUrl: pageEl.dataset.leavePreviewUrl,
        baseUrl: pageEl.dataset.leaveBaseUrl
    };

    const getEl = (selector) => (selector ? document.querySelector(selector) : null);

    const refs = {
        tableSelector: '#leave-table',
        filterField: getEl('#leave-filter-field'),
        filterType: getEl('#leave-filter-type'),
        filterValue: getEl('#leave-filter-value'),
        typeSelect: getEl('#leave-filter-type-select'),
        statusSelect: getEl('#leave-filter-status'),
        fromInput: getEl('#leave-filter-from'),
        toInput: getEl('#leave-filter-to'),
        filterApply: getEl('#leave-filter-apply'),
        filterReset: getEl('#leave-filter-reset'),
        refreshButton: getEl('#leave-refresh'),
        exportButton: getEl('#leave-export'),
        pdfButton: getEl('#leave-pdf'),
        summaryButton: getEl('#leave-export-summary'),
        createForm: getEl('#create-leave-form'),
        editForm: getEl('#edit-leave-form'),
        createEmployeeMeta: getEl('#create-leave-employee-meta'),
        editEmployeeMeta: getEl('#edit-leave-employee-meta'),
        summaryEls: {
            total: document.querySelector('[data-leave-total]'),
            approved: document.querySelector('[data-leave-approved]'),
            pending: document.querySelector('[data-leave-pending]'),
            rejected: document.querySelector('[data-leave-rejected]')
        },
        editModalTrigger: document.getElementById('open-edit-leave-modal')
    };

    const tableEl = document.querySelector(refs.tableSelector);

    if (!tableEl) {
        return;
    }

    const updateEmployeeMeta = (selectElement, metaTarget) => {
        if (!selectElement || !metaTarget) {
            return;
        }

        const selected = selectElement.options[selectElement.selectedIndex];
        if (!selected) {
            metaTarget.textContent = '—';
            return;
        }

        const position = selected.dataset.position || '—';
        const department = selected.dataset.department || '—';
        const company = selected.dataset.company || '—';
        metaTarget.textContent = `${position} • ${department} • ${company}`;
    };

    const attachEmployeeMetaListener = (selectElement, metaElement) => {
        if (!selectElement || !metaElement) {
            return;
        }
        selectElement.addEventListener('change', () => updateEmployeeMeta(selectElement, metaElement));
        updateEmployeeMeta(selectElement, metaElement);
    };

    const attachDaysListener = (startSelector, endSelector, targetSelector) => {
        const start = getEl(startSelector);
        const end = getEl(endSelector);
        const target = getEl(targetSelector);

        if (!start || !end || !target) {
            return;
        }

        const compute = () => {
            if (!start.value || !end.value) {
                target.value = '';
                return;
            }

            const startDate = new Date(start.value);
            const endDate = new Date(end.value);
            const diff = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24));
            target.value = Math.max(diff + 1, 1);
        };

        start.addEventListener('change', compute);
        end.addEventListener('change', compute);
        compute();
    };

    attachEmployeeMetaListener(getEl('#create-leave-employee-id'), refs.createEmployeeMeta);
    attachEmployeeMetaListener(getEl('#edit-leave-employee-id'), refs.editEmployeeMeta);
    attachDaysListener('#create-leave-start-date', '#create-leave-end-date', '#create-leave-days');
    attachDaysListener('#edit-leave-start-date', '#edit-leave-end-date', '#edit-leave-days');

    const initSummary = () => {
        if (!config.summaryUrl) {
            return;
        }

        fetch(config.summaryUrl, { headers: { Accept: 'application/json' } })
            .then((response) => response.json())
            .then((payload) => {
                const data = payload.data || {};
                if (refs.summaryEls.total) refs.summaryEls.total.textContent = data.total ?? 0;
                if (refs.summaryEls.approved) refs.summaryEls.approved.textContent = data.approved ?? 0;
                if (refs.summaryEls.pending) refs.summaryEls.pending.textContent = data.pending ?? 0;
                if (refs.summaryEls.rejected) refs.summaryEls.rejected.textContent = data.rejected ?? 0;
            })
            .catch(() => {});
    };

    const fetchPreviewCode = () => {
        if (!config.previewUrl) {
            return;
        }

        fetch(config.previewUrl, { headers: { Accept: 'application/json' } })
            .then((response) => response.json())
            .then((payload) => {
                const codeInput = document.getElementById('create-leave-code');
                if (codeInput) {
                    codeInput.value = payload.code || '';
                }
            })
            .catch(() => {});
    };

    const placeholderExport = (type) => {
        if (typeof window.showToast === 'function') {
            window.showToast(`${type} export will be enabled soon`, 'info');
        } else {
            alert(`${type} export will be enabled soon.`);
        }
    };

    const waitForDependencies = () => {
        if (typeof window.erpCrud?.initDataTable !== 'function' || typeof window.jQuery === 'undefined') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const dataTable = window.erpCrud.initDataTable({
            tableSelector: refs.tableSelector,
            ajaxUrl: config.datatableUrl,
            ajaxData: (d) => {
                d.filter_field = refs.filterField?.value || 'all';
                d.filter_type = refs.filterType?.value || 'contains';
                d.filter_value = refs.filterValue?.value || '';
                d.filter_leave_type = refs.typeSelect?.value || '';
                d.filter_status = refs.statusSelect?.value || '';
                d.filter_from = refs.fromInput?.value || '';
                d.filter_to = refs.toInput?.value || '';
            },
            columns: [
                { data: 'request', name: 'code', orderable: false, searchable: false },
                { data: 'employee', name: 'employee', orderable: false, searchable: false },
                { data: 'period', name: 'start_date', orderable: false, searchable: false },
                { data: 'reason', name: 'reason_category', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        const reloadTable = () => dataTable?.ajax.reload(null, false);

        refs.filterApply?.addEventListener('click', reloadTable);
        refs.filterReset?.addEventListener('click', () => {
            if (refs.filterField) refs.filterField.value = 'all';
            if (refs.filterType) refs.filterType.value = 'contains';
            if (refs.filterValue) refs.filterValue.value = '';
            if (refs.typeSelect) refs.typeSelect.value = '';
            if (refs.statusSelect) refs.statusSelect.value = '';
            if (refs.fromInput) refs.fromInput.value = '';
            if (refs.toInput) refs.toInput.value = '';
            reloadTable();
        });

        refs.refreshButton?.addEventListener('click', () => {
            reloadTable();
            initSummary();
        });

        refs.exportButton?.addEventListener('click', () => placeholderExport('Excel'));
        refs.pdfButton?.addEventListener('click', () => placeholderExport('PDF'));
        refs.summaryButton?.addEventListener('click', () => placeholderExport('Summary'));

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        window.leaveUI = window.leaveUI || {};

        window.leaveUI.edit = (id) => {
            if (!id || !refs.editForm || !config.baseUrl) {
                return;
            }

            fetch(`${config.baseUrl}/${id}`, { headers: { Accept: 'application/json' } })
                .then((response) => response.json())
                .then((payload) => {
                    const data = payload.data;
                    if (!data) {
                        return;
                    }

                    refs.editForm.action = `${config.baseUrl}/${data.id}`;
                    const idField = refs.editForm.querySelector('[name="id"]');
                    if (idField) {
                        idField.value = data.id;
                    }
                    getEl('#edit-leave-code').value = data.code || '';
                    getEl('#edit-leave-employee-id').value = data.employee_id;
                    updateEmployeeMeta(getEl('#edit-leave-employee-id'), refs.editEmployeeMeta);
                    getEl('#edit-leave-type').value = data.leave_type || '';
                    getEl('#edit-leave-reason').value = data.reason_category || '';
                    getEl('#edit-leave-start-date').value = data.start_date || '';
                    getEl('#edit-leave-end-date').value = data.end_date || '';
                    getEl('#edit-leave-days').value = data.days_count || '';
                    getEl('#edit-leave-reason-details').value = data.reason_details || '';
                    getEl('#edit-leave-notes').value = data.notes || '';
                    getEl('#edit-leave-status').value = data.status || '';
                    const paidCheckbox = document.getElementById('edit-leave-paid');
                    if (paidCheckbox) {
                        paidCheckbox.checked = Boolean(data.is_paid);
                    }

                    refs.editModalTrigger?.click();
                })
                .catch(() => {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Failed to load leave request', 'error');
                    }
                });
        };

        window.leaveUI.delete = (id, code) => {
            if (!id || !config.baseUrl) {
                return;
            }

            const performDelete = () => {
                fetch(`${config.baseUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
                    }
                })
                    .then((response) => response.json())
                    .then((payload) => {
                        if (payload?.success) {
                            window.showToast?.('Leave request deleted', 'success');
                            reloadTable();
                            initSummary();
                        } else {
                            window.showToast?.(payload?.message || 'Failed to delete', 'error');
                        }
                    })
                    .catch(() => {
                        window.showToast?.('Failed to delete leave request', 'error');
                    });
            };

            if (typeof window.confirmDelete === 'function') {
                window.confirmDelete(code || 'leave request', performDelete);
            } else if (window.confirm('Delete this leave request?')) {
                performDelete();
            }
        };

        if (window.erpCrud) {
            window.erpCrud.handleCreateForm({
                formSelector: '#create-leave-form',
                modalSelector: '#create-leave-modal',
                onSuccess: () => {
                    reloadTable();
                    initSummary();
                    fetchPreviewCode();
                }
            });

            window.erpCrud.handleEditForm({
                formSelector: '#edit-leave-form',
                modalSelector: '#edit-leave-modal',
                onSuccess: () => {
                    reloadTable();
                    initSummary();
                }
            });
        }

        fetchPreviewCode();
        initSummary();
    };

    waitForDependencies();
}

function initializePayrollModal() {
    const modalEl = document.getElementById('generate-payroll-modal');

    if (!modalEl) {
        return;
    }

    const generateUrl = modalEl.dataset.payrollGenerateUrl;
    const processUrl = modalEl.dataset.payrollProcessUrl;
    const departmentsUrlBase = modalEl.dataset.payrollDepartmentsUrl;

    const form = modalEl.querySelector('#generate-payroll-form');
    const monthInput = form?.querySelector('#generate-month');
    const companySelect = form?.querySelector('#generate-company-filter');
    const departmentSelect = form?.querySelector('#generate-department-filter');
    const includeInactiveCheckbox = form?.querySelector('#include-inactive');
    const previewBtn = form?.querySelector('#generate-preview-btn');
    const processBtn = form?.querySelector('#process-payroll-btn');
    const payrollPreview = form?.querySelector('#payroll-preview');
    const payrollEmptyState = form?.querySelector('#payroll-empty-state');
    const payrollDetailsTable = form?.querySelector('#payroll-details-table');
    const summaryElements = {
        total: form?.querySelector('#preview-employee-count'),
        totalAmount: form?.querySelector('#preview-total-amount'),
        avgSalary: form?.querySelector('#preview-avg-salary'),
        month: form?.querySelector('#preview-month-display')
    };

    if (!form || !previewBtn || !processBtn || !payrollDetailsTable) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const setButtonLoading = (button, isLoading, defaultHtml, loadingText) => {
        if (!button) {
            return;
        }
        if (isLoading) {
            button.disabled = true;
            button.dataset.defaultHtml = defaultHtml ?? button.innerHTML;
            button.innerHTML = loadingText;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.defaultHtml || button.innerHTML;
        }
    };

    const showToastMessage = (message, type = 'info') => {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        }
    };

    const resetPreview = () => {
        payrollDetailsTable.innerHTML = '';
        payrollPreview?.classList.add('hidden');
        payrollEmptyState?.classList.remove('hidden');
        processBtn.classList.add('hidden');
    };

    const displayPayrollPreview = (data) => {
        payrollEmptyState?.classList.add('hidden');
        payrollPreview?.classList.remove('hidden');

        if (summaryElements.total) {
            summaryElements.total.textContent = data.total_employees ?? 0;
        }
        if (summaryElements.totalAmount) {
            const totalAmount = Number(data.total_amount || 0);
            summaryElements.totalAmount.textContent = `$${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }
        if (summaryElements.avgSalary) {
            const employees = Number(data.total_employees || 0);
            const totalAmount = Number(data.total_amount || 0);
            const avg = employees > 0 ? totalAmount / employees : 0;
            summaryElements.avgSalary.textContent = `$${avg.toFixed(2)}`;
        }
        if (summaryElements.month && data.month) {
            const date = new Date(`${data.month}-01`);
            summaryElements.month.textContent = date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
        }

        payrollDetailsTable.innerHTML = '';
        const details = Array.isArray(data.payroll_data) ? data.payroll_data : [];

        if (!details.length) {
            payrollDetailsTable.innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">No employees found for the selected criteria</td></tr>';
            return;
        }

        details.forEach((employee) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50 dark:hover:bg-darkmode-600';
            row.innerHTML = `
                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">
                    ${employee.employee_name} (${employee.employee_code})
                </td>
                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">
                    ${employee.position || 'N/A'}
                </td>
                <td class="px-4 py-3 text-sm text-green-600 font-medium">
                    $${Number(employee.base_salary || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Ready
                    </span>
                </td>
            `;
            payrollDetailsTable.appendChild(row);
        });
    };

    const buildRequestBody = () => ({
        month: monthInput?.value || '',
        company_id: companySelect?.value || null,
        department_id: departmentSelect?.value || null,
        include_inactive: includeInactiveCheckbox?.checked ?? false
    });

    const generatePreview = () => {
        const payload = buildRequestBody();
        if (!payload.month) {
            showToastMessage('Please select a payroll month', 'error');
            return;
        }

        if (!generateUrl) {
            showToastMessage('Payroll preview route is missing', 'error');
            return;
        }

        setButtonLoading(previewBtn, true, previewBtn.innerHTML, '<span class="inline-flex items-center"><span class="loader mr-2"></span>Generating...</span>');

        fetch(generateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
            .then((response) => response.json())
            .then((data) => {
                if (data?.success) {
                    displayPayrollPreview(data.data || {});
                    processBtn.classList.remove('hidden');
                } else {
                    showToastMessage(data?.message || 'Failed to generate payroll preview', 'error');
                    resetPreview();
                }
            })
            .catch((error) => {
                console.error('[Payroll] Preview error:', error);
                showToastMessage('An error occurred while generating payroll preview', 'error');
                resetPreview();
            })
            .finally(() => {
                setButtonLoading(previewBtn, false);
            });
    };

    const processPayroll = () => {
        if (!processUrl) {
            showToastMessage('Payroll processing route is missing', 'error');
            return;
        }

        const rows = Array.from(payrollDetailsTable.querySelectorAll('tr'));
        const payrollData = rows
            .map((row) => {
                const cells = row.querySelectorAll('td');
                if (cells.length < 3) {
                    return null;
                }
                const [nameCell, , salaryCell] = cells;
                const nameParts = nameCell.textContent.split('(');
                const employeeName = nameParts[0]?.trim() || '';
                const employeeCode = nameParts[1]?.replace(')', '').trim() || '';
                const baseSalary = salaryCell.textContent.replace(/[^0-9.]/g, '');

                return {
                    employee_name: employeeName,
                    employee_code: employeeCode,
                    base_salary: baseSalary
                };
            })
            .filter(Boolean);

        if (!payrollData.length) {
            showToastMessage('No payroll data to process', 'error');
            return;
        }

        const requestPayload = {
            payroll_data: payrollData,
            month: monthInput?.value || ''
        };

        setButtonLoading(processBtn, true, processBtn.innerHTML, '<span class="inline-flex items-center"><span class="loader mr-2"></span>Processing...</span>');

        fetch(processUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestPayload)
        })
            .then((response) => response.json())
            .then((data) => {
                if (data?.success) {
                    showToastMessage(data.message || 'Payroll processed successfully', 'success');
                    form.reset();
                    resetPreview();

                    if (typeof window.twModal?.hide === 'function') {
                        window.twModal.hide(modalEl);
                    }

                    if (window.payrollTable?.ajax) {
                        window.payrollTable.ajax.reload(null, false);
                    }
                } else {
                    showToastMessage(data?.message || 'Failed to process payroll', 'error');
                }
            })
            .catch((error) => {
                console.error('[Payroll] Process error:', error);
                showToastMessage('An error occurred while processing payroll', 'error');
            })
            .finally(() => {
                setButtonLoading(processBtn, false);
            });
    };

    const loadDepartments = (companyId) => {
        if (!departmentSelect) {
            return;
        }

        if (!companyId) {
            departmentSelect.innerHTML = '<option value="">All Departments</option>';
            return;
        }

        if (!departmentsUrlBase) {
            return;
        }

        departmentSelect.innerHTML = '<option value="">Loading departments...</option>';

        fetch(`${departmentsUrlBase}/${companyId}`, {
            headers: {
                Accept: 'application/json',
                ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response) => response.json())
            .then((data) => {
                departmentSelect.innerHTML = '<option value="">All Departments</option>';
                if (Array.isArray(data)) {
                    data.forEach((dept) => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.name;
                        departmentSelect.appendChild(option);
                    });
                }
            })
            .catch((error) => {
                console.error('[Payroll] Department load error:', error);
                departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
            });
    };

    previewBtn.addEventListener('click', generatePreview);
    processBtn.addEventListener('click', processPayroll);
    companySelect?.addEventListener('change', (event) => {
        loadDepartments(event.target.value);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initializeProjectsPage === 'function') {
        window.initializeProjectsPage();
    }
    if (typeof window.initializeDepartmentsPage === 'function') {
        window.initializeDepartmentsPage();
    }
    if (typeof window.initializePositionsPage === 'function') {
        window.initializePositionsPage();
    }
    if (typeof window.initializeAttendancePage === 'function') {
        window.initializeAttendancePage();
    }
    if (typeof window.initializeLeavePage === 'function') {
        window.initializeLeavePage();
    }
    if (typeof window.initializePayrollModal === 'function') {
        window.initializePayrollModal();
    }
});

function initializeDepartmentsPage() {
    const tableEl = document.getElementById('departments-table');

    if (!tableEl) {
        return;
    }

    const datatableUrl = tableEl.dataset.departmentsDatatableUrl;
    const deleteUrlBase = tableEl.dataset.departmentsDeleteUrlBase;
    const filterField = document.getElementById('departments-filter-field');
    const filterType = document.getElementById('departments-filter-type');
    const filterValue = document.getElementById('departments-filter-value');
    const lengthSelect = document.getElementById('departments-filter-length');
    const filterGoBtn = document.getElementById('departments-filter-go');
    const filterResetBtn = document.getElementById('departments-filter-reset');
    const exportBtn = document.getElementById('departments-export');
    const refreshBtn = document.getElementById('departments-refresh');
    const createForm = document.getElementById('create-department-form');
    const codeInput = createForm?.querySelector('#code');
    const editForm = document.getElementById('edit-department-form');
    const editTrigger = document.getElementById('edit-department-trigger');
    const updateUrlBase = editForm?.dataset.updateUrlBase;
    const createPreviewUrl = createForm?.dataset.previewUrl;

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined' || typeof window.erpCrud?.initDataTable !== 'function') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;
        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 25 : 25;

        const tableInstance = window.erpCrud.initDataTable({
            tableSelector: '#departments-table',
            ajaxUrl: datatableUrl,
            ajaxData: function (d) {
                d.filter_field = filterField?.value || 'all';
                d.filter_type = filterType?.value || 'contains';
                d.filter_value = filterValue?.value || '';
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

        const reloadTable = () => tableInstance.ajax.reload(null, false);

        lengthSelect?.addEventListener('change', () => {
            const newLength = parseInt(lengthSelect.value, 10) || initialLength;
            tableInstance.page.len(newLength).draw();
        });

        filterGoBtn?.addEventListener('click', reloadTable);
        filterValue?.addEventListener('keyup', (event) => {
            if (event.key === 'Enter') {
                reloadTable();
            }
        });
        filterResetBtn?.addEventListener('click', () => {
            if (filterField) filterField.value = 'all';
            if (filterType) filterType.value = 'contains';
            if (filterValue) filterValue.value = '';
            if (lengthSelect) {
                lengthSelect.value = '25';
                tableInstance.page.len(25).draw();
            }
            reloadTable();
        });
        refreshBtn?.addEventListener('click', reloadTable);

        const refreshDepartmentCode = () => {
            if (!createPreviewUrl || !codeInput) {
                return;
            }

            fetch(createPreviewUrl)
                .then((response) => response.ok ? response.json() : Promise.reject(new Error('Preview code failed')))
                .then((data) => {
                    codeInput.value = data.code || '';
                })
                .catch(() => {
                    codeInput.value = '';
                });
        };

        if (createForm) {
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

        const parentSelect = document.getElementById('edit-department-parent');
        window.openDepartmentEditModal = function (id, name, companyId, parentId, managerId, description) {
            if (!editForm || !editTrigger) {
                console.error('[Departments] Missing edit form/trigger');
                return;
            }

            editForm.querySelector('#edit-department-current-id').value = id;
            editForm.querySelector('#edit-department-name').value = name || '';
            editForm.querySelector('#edit-department-description').value = description || '';
            editForm.querySelector('#edit-department-company').value = companyId || '';
            editForm.querySelector('#edit-department-manager').value = managerId || '';

            if (parentSelect) {
                Array.from(parentSelect.options).forEach((option) => {
                    if (companyId && option.dataset.company && option.value) {
                        option.hidden = option.dataset.company !== String(companyId);
                    } else {
                        option.hidden = false;
                    }
                });
                parentSelect.value = parentId || '';
            }

            if (updateUrlBase) {
                editForm.action = `${updateUrlBase}/${id}`;
            }

            editTrigger.click();
        };

        exportBtn?.addEventListener('click', () => {
            try {
                const rows = tableInstance.rows({ search: 'applied' }).data().toArray();
                if (!rows.length) {
                    window.showToast?.('No data available for export', 'error');
                    return;
                }

                const headers = ['#', 'Name', 'Company', 'Manager', 'Employees', 'Status'];
                const csvRows = [headers.join(',')];

                rows.forEach((row) => {
                    csvRows.push([
                        row.DT_RowIndex,
                        `"${(row.name || '').replace(/"/g, '""')}"`,
                        `"${((row.company && row.company.name) ? row.company.name : '').replace(/"/g, '""')}"`,
                        `"${((row.manager && row.manager.full_name) ? row.manager.full_name : '').replace(/"/g, '""')}"`,
                        row.employees_count ?? '',
                        row.is_active ? 'Active' : 'Inactive'
                    ].join(','));
                });

                const blob = new Blob(['\ufeff' + csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `departments_${new Date().toISOString().split('T')[0]}.csv`;
                link.click();
                URL.revokeObjectURL(url);
                window.showToast?.('Data exported successfully', 'success');
            } catch (error) {
                console.error('Export error:', error);
                window.showToast?.('Failed to export data', 'error');
            }
        });

        document.addEventListener('hidden.tw.modal', () => {
            if (document.activeElement && typeof document.activeElement.blur === 'function') {
                document.activeElement.blur();
            }
            reloadTable();
        });
    };

    waitForDependencies();
}

function initializeProjectsPage() {
    const tableEl = document.getElementById('projects-table');

    if (!tableEl) {
        return;
    }

    const datatableUrl = tableEl.dataset.projectsDatatableUrl;
    const deleteUrlBase = tableEl.dataset.projectsDeleteUrlBase;

    const waitForDependencies = () => {
        if (typeof window.jQuery === 'undefined' || typeof window.erpCrud?.initDataTable !== 'function') {
            setTimeout(waitForDependencies, 100);
            return;
        }

        const $ = window.jQuery;
        const tableInstance = window.erpCrud.initDataTable({
            tableSelector: '#projects-table',
            ajaxUrl: datatableUrl,
            ajaxData: function (d) {
                d.company_id = $('#company-filter').val();
                d.department_id = $('#department-filter').val();
                d.status = $('#status-filter').val();
                return d;
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                { data: 'company_department', name: 'company_department', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap', orderable: false },
                { data: 'manager', name: 'manager', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap', orderable: false },
                { data: 'status', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                { data: 'priority', name: 'priority', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                { data: 'progress_percentage', name: 'progress_percentage', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false },
                { data: 'actions', name: 'actions', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']],
            pageLength: 25,
            dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>"
        });

        if (!tableInstance) {
            return;
        }

        $('#company-filter, #department-filter, #status-filter').on('change', function () {
            tableInstance.ajax.reload();
        });

        window.deleteProject = function (id, name) {
            if (typeof window.confirmDelete !== 'function') {
                return;
            }

            window.confirmDelete(name, function () {
                $.ajax({
                    url: `${deleteUrlBase}/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .done(function (response) {
                        tableInstance.ajax.reload();
                        if (response.success && typeof window.showSuccess === 'function') {
                            window.showSuccess(response.message || 'Project deleted successfully');
                        } else if (!response.success && typeof window.showError === 'function') {
                            window.showError(response.message || 'Failed to delete project');
                        }
                    })
                    .fail(function (xhr) {
                        const message = xhr.responseJSON?.message || 'Failed to delete project';
                        if (typeof window.showError === 'function') {
                            window.showError(message);
                        }
                    });
            });
        };

        window.openCreateModal = function () {
            const modal = document.getElementById('create-project-modal');
            if (!modal) {
                return;
            }
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        };

        window.closeCreateModal = function () {
            const modal = document.getElementById('create-project-modal');
            if (!modal) {
                return;
            }
            modal.classList.remove('show');
            document.body.style.overflow = '';
        };
    };

    waitForDependencies();
}