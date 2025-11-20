import '../erp/crud';

const leavePage = () => {
    if (!window.leaveConfig || !window.erpCrud) {
        console.warn('Leave config or ERP CRUD helper not found.');
        return;
    }

    const {
        routes,
        selectors,
        meta,
    } = window.leaveConfig;

    const getEl = (selector) => document.querySelector(selector);

    const refs = {
        table: getEl(selectors.table),
        filterField: getEl(selectors.filterField),
        filterType: getEl(selectors.filterType),
        filterValue: getEl(selectors.filterValue),
        typeSelect: getEl(selectors.typeSelect),
        statusSelect: getEl(selectors.statusSelect),
        fromInput: getEl(selectors.fromInput),
        toInput: getEl(selectors.toInput),
        filterApply: getEl(selectors.filterApply),
        filterReset: getEl(selectors.filterReset),
        refreshButton: getEl(selectors.refreshButton),
        exportButton: getEl(selectors.exportButton),
        pdfButton: getEl(selectors.pdfButton),
        summaryButton: getEl(selectors.summaryButton),
        createForm: getEl(selectors.createForm),
        editForm: getEl(selectors.editForm),
        createEmployeeMeta: getEl(selectors.createEmployeeMeta),
        editEmployeeMeta: getEl(selectors.editEmployeeMeta),
        summaryEls: {
            total: document.querySelector('[data-leave-total]'),
            approved: document.querySelector('[data-leave-approved]'),
            pending: document.querySelector('[data-leave-pending]'),
            rejected: document.querySelector('[data-leave-rejected]'),
        },
        editModalTrigger: document.getElementById('open-edit-leave-modal'),
    };

    if (!refs.table) {
        return;
    }

    const updateEmployeeMeta = (selectElement, metaTarget) => {
        if (!selectElement || !metaTarget) return;
        const selected = selectElement.options[selectElement.selectedIndex];
        if (!selected) return;

        const position = selected.dataset.position || '—';
        const department = selected.dataset.department || '—';
        const company = selected.dataset.company || '—';

        metaTarget.textContent = `${position} • ${department} • ${company}`;
    };

    const attachEmployeeMetaListener = (selectElement, metaElement) => {
        if (!selectElement || !metaElement) return;
        selectElement.addEventListener('change', () => updateEmployeeMeta(selectElement, metaElement));
        updateEmployeeMeta(selectElement, metaElement);
    };

    attachEmployeeMetaListener(getEl('#create-leave-employee-id'), refs.createEmployeeMeta);
    attachEmployeeMetaListener(getEl('#edit-leave-employee-id'), refs.editEmployeeMeta);

    const attachDaysListener = (startSelector, endSelector, targetSelector) => {
        const start = getEl(startSelector);
        const end = getEl(endSelector);
        const target = getEl(targetSelector);

        if (!start || !end || !target) return;

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

    attachDaysListener('#create-leave-start-date', '#create-leave-end-date', '#create-leave-days');
    attachDaysListener('#edit-leave-start-date', '#edit-leave-end-date', '#edit-leave-days');

    const initSummary = () => {
        fetch(routes.summary, { headers: { Accept: 'application/json' } })
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
        fetch(routes.previewCode, { headers: { Accept: 'application/json' } })
            .then((response) => response.json())
            .then((payload) => {
                const codeInput = document.getElementById('create-leave-code');
                if (codeInput) codeInput.value = payload.code || '';
            })
            .catch(() => {});
    };

    const dataTable = window.erpCrud.initDataTable({
        tableSelector: selectors.table,
        ajaxUrl: routes.datatable,
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
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
        ],
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

    const placeholderExport = (type) => {
        if (typeof window.showToast === 'function') {
            window.showToast(`${type} export will be enabled soon`, 'info');
        } else {
            alert(`${type} export will be enabled soon.`);
        }
    };

    refs.exportButton?.addEventListener('click', () => placeholderExport('Excel'));
    refs.pdfButton?.addEventListener('click', () => placeholderExport('PDF'));
    refs.summaryButton?.addEventListener('click', () => placeholderExport('Summary'));

    window.leaveUI = window.leaveUI || {};

    window.leaveUI.edit = (id) => {
        if (!id || !refs.editForm) return;
        fetch(`${routes.base}/${id}`, { headers: { Accept: 'application/json' } })
            .then((response) => response.json())
            .then((payload) => {
                const data = payload.data;
                if (!data) return;

                refs.editForm.action = `${routes.base}/${data.id}`;
                refs.editForm.querySelector('[name="id"]').value = data.id;
                document.getElementById('edit-leave-code').value = data.code;
                document.getElementById('edit-leave-employee-id').value = data.employee_id;
                updateEmployeeMeta(getEl('#edit-leave-employee-id'), refs.editEmployeeMeta);
                document.getElementById('edit-leave-type').value = data.leave_type;
                document.getElementById('edit-leave-reason').value = data.reason_category || '';
                document.getElementById('edit-leave-start-date').value = data.start_date;
                document.getElementById('edit-leave-end-date').value = data.end_date;
                document.getElementById('edit-leave-days').value = data.days_count || '';
                document.getElementById('edit-leave-reason-details').value = data.reason_details || '';
                document.getElementById('edit-leave-notes').value = data.notes || '';
                document.getElementById('edit-leave-status').value = data.status;
                document.getElementById('edit-leave-paid').checked = Boolean(data.is_paid);

                refs.editModalTrigger?.click();
            })
            .catch(() => {
                if (typeof window.showToast === 'function') {
                    window.showToast('Failed to load leave request', 'error');
                }
            });
    };

    window.leaveUI.delete = (id, code) => {
        if (!id) return;
        const doDelete = () => {
            fetch(`${routes.base}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': meta.csrf,
                    Accept: 'application/json',
                },
            })
                .then((response) => response.json())
                .then((payload) => {
                    if (payload?.success) {
                        if (typeof window.showToast === 'function') {
                            window.showToast('Leave request deleted', 'success');
                        }
                        reloadTable();
                        initSummary();
                    } else if (typeof window.showToast === 'function') {
                        window.showToast(payload?.message || 'Failed to delete', 'error');
                    }
                })
                .catch(() => {
                    if (typeof window.showToast === 'function') {
                        window.showToast('Failed to delete leave request', 'error');
                    }
                });
        };

        if (typeof window.confirmDelete === 'function') {
            window.confirmDelete(code || 'leave request', doDelete);
        } else if (window.confirm('Delete this leave request?')) {
            doDelete();
        }
    };

    window.erpCrud.handleCreateForm({
        formSelector: selectors.createForm,
        modalSelector: '#create-leave-modal',
        onSuccess: () => {
            reloadTable();
            initSummary();
            fetchPreviewCode();
        },
    });

    window.erpCrud.handleEditForm({
        formSelector: selectors.editForm,
        modalSelector: '#edit-leave-modal',
        onSuccess: () => {
            reloadTable();
            initSummary();
        },
    });

    fetchPreviewCode();
    initSummary();
};

document.addEventListener('DOMContentLoaded', leavePage);
