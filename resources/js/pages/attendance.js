// Attendance Page JavaScript
export function initializeAttendancePage() {
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

// Auto-initialize
window.initializeAttendancePage = initializeAttendancePage;
