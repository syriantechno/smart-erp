// Payroll Modal JavaScript
export function initializePayrollModal() {
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

// Auto-initialize
window.initializePayrollModal = initializePayrollModal;
