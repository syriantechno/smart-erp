<!-- Generate Payroll Modal -->
<x-base.dialog id="generate-payroll-modal" size="lg">
    <x-base.dialog.panel>
        <!-- Header -->
        <x-base.dialog.title>
            <x-base.lucide icon="Calculator" class="w-5 h-5 mr-2" />
            Generate Payroll
        </x-base.dialog.title>

        <form id="generate-payroll-form">
            <!-- Modal Body -->
            <div class="px-5 py-3">
                <div class="space-y-6">
                <!-- Payroll Generation Settings -->
                <div class="grid grid-cols-12 gap-4">
                    <!-- Month Selection -->
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Payroll Month
                        </label>
                        <x-base.form-input
                            id="generate-month"
                            type="month"
                            class="w-full"
                            :value="date('Y-m')"
                            required
                        />
                        <p class="mt-1 text-xs text-slate-500">Select the month for payroll generation</p>
                    </div>

                    <!-- Company Filter -->
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Company (Optional)
                        </label>
                        <x-base.form-select id="generate-company-filter" class="w-full">
                            <option value="">All Companies</option>
                            @foreach($companies ?? [] as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </x-base.form-select>
                        <p class="mt-1 text-xs text-slate-500">Leave empty to generate for all companies</p>
                    </div>

                    <!-- Department Filter -->
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Department (Optional)
                        </label>
                        <x-base.form-select id="generate-department-filter" class="w-full">
                            <option value="">All Departments</option>
                        </x-base.form-select>
                        <p class="mt-1 text-xs text-slate-500">Leave empty to generate for all departments</p>
                    </div>

                    <!-- Generation Options -->
                    <div class="col-span-12 md:col-span-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Generation Options
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="include-inactive" class="rounded border-slate-300 text-primary focus:ring-primary">
                                <span class="ml-2 text-sm text-slate-600">Include inactive employees</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="skip-zero-salary" class="rounded border-slate-300 text-primary focus:ring-primary" checked>
                                <span class="ml-2 text-sm text-slate-600">Skip employees with zero salary</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                            <x-base.lucide icon="Eye" class="w-5 h-5 mr-2 inline" />
                            Payroll Preview
                        </h3>
                        <x-base.button
                            type="button"
                            id="generate-preview-btn"
                            variant="outline-primary"
                            size="sm"
                        >
                            <x-base.lucide icon="RefreshCw" class="w-4 h-4 mr-1" />
                            Generate Preview
                        </x-base.button>
                    </div>

                    <!-- Preview Results -->
                    <div id="payroll-preview" class="hidden">
                        <div class="bg-slate-50 dark:bg-darkmode-600 rounded-lg p-4">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-blue-600" id="preview-employee-count">0</div>
                                    <div class="text-sm text-slate-500">Employees</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-green-600" id="preview-total-amount">$0.00</div>
                                    <div class="text-sm text-slate-500">Total Amount</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-purple-600" id="preview-avg-salary">$0.00</div>
                                    <div class="text-sm text-slate-500">Average Salary</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-orange-600" id="preview-month-display">-</div>
                                    <div class="text-sm text-slate-500">Month</div>
                                </div>
                            </div>
                        </div>

                        <!-- Payroll Details Table -->
                        <div class="mt-4">
                            <div class="overflow-x-auto max-h-64 border rounded-lg">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-darkmode-300">
                                    <thead class="bg-slate-50 dark:bg-darkmode-600">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Employee</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Position</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Base Salary</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payroll-details-table" class="bg-white dark:bg-darkmode-700 divide-y divide-slate-200 dark:divide-darkmode-300">
                                        <!-- Will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="payroll-empty-state" class="text-center py-8 text-slate-500">
                        <x-base.lucide icon="FileX" class="w-12 h-12 mx-auto mb-4 text-slate-300" />
                        <p>Click "Generate Preview" to see payroll details</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <x-base.dialog.footer>
            <x-base.button
                type="button"
                variant="secondary"
                x-on:click="$dispatch('close')"
            >
                Cancel
            </x-base.button>

            <x-base.button
                type="button"
                id="process-payroll-btn"
                variant="primary"
                class="hidden"
            >
                <x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-2" />
                Process Payroll
            </x-base.button>
        </x-base.dialog.footer>
    </form>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
// Payroll Generation Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const generatePreviewBtn = document.getElementById('generate-preview-btn');
    const processPayrollBtn = document.getElementById('process-payroll-btn');
    const payrollPreview = document.getElementById('payroll-preview');
    const payrollEmptyState = document.getElementById('payroll-empty-state');
    const payrollDetailsTable = document.getElementById('payroll-details-table');

    // Generate Preview
    if (generatePreviewBtn) {
        generatePreviewBtn.addEventListener('click', function() {
            generatePayrollPreview();
        });
    }

    // Process Payroll
    if (processPayrollBtn) {
        processPayrollBtn.addEventListener('click', function() {
            processPayroll();
        });
    }

    // Auto-load departments when company changes
    const companyFilter = document.getElementById('generate-company-filter');
    const departmentFilter = document.getElementById('generate-department-filter');

    if (companyFilter) {
        companyFilter.addEventListener('change', function() {
            loadDepartmentsForCompany(this.value, departmentFilter);
        });
    }

    function generatePayrollPreview() {
        const month = document.getElementById('generate-month').value;
        const companyId = companyFilter.value;
        const departmentId = departmentFilter.value;
        const includeInactive = document.getElementById('include-inactive').checked;

        if (!month) {
            showToast('Please select a payroll month', 'error');
            return;
        }

        // Show loading state
        generatePreviewBtn.disabled = true;
        generatePreviewBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-1 animate-spin"></x-base.lucide>Generating...';

        fetch('{{ route("hr.payroll.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                month: month,
                company_id: companyId || null,
                department_id: departmentId || null,
                include_inactive: includeInactive
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayPayrollPreview(data.data);
                processPayrollBtn.classList.remove('hidden');
            } else {
                showToast(data.message || 'Failed to generate payroll preview', 'error');
            }
        })
        .catch(error => {
            console.error('Error generating payroll preview:', error);
            showToast('An error occurred while generating payroll preview', 'error');
        })
        .finally(() => {
            generatePreviewBtn.disabled = false;
            generatePreviewBtn.innerHTML = '<x-base.lucide icon="RefreshCw" class="w-4 h-4 mr-1"></x-base.lucide>Generate Preview';
        });
    }

    function displayPayrollPreview(data) {
        // Hide empty state and show preview
        payrollEmptyState.classList.add('hidden');
        payrollPreview.classList.remove('hidden');

        // Update summary stats
        document.getElementById('preview-employee-count').textContent = data.total_employees;
        document.getElementById('preview-total-amount').textContent = '$' + parseFloat(data.total_amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('preview-avg-salary').textContent = '$' + (data.total_employees > 0 ? (data.total_amount / data.total_employees).toFixed(2) : '0.00');
        document.getElementById('preview-month-display').textContent = new Date(data.month + '-01').toLocaleDateString('en-US', { year: 'numeric', month: 'long' });

        // Clear and populate details table
        payrollDetailsTable.innerHTML = '';

        if (data.payroll_data && data.payroll_data.length > 0) {
            data.payroll_data.forEach(employee => {
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
                        $${parseFloat(employee.base_salary).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Ready
                        </span>
                    </td>
                `;
                payrollDetailsTable.appendChild(row);
            });
        } else {
            const emptyRow = document.createElement('tr');
            emptyRow.innerHTML = `
                <td colspan="4" class="px-4 py-8 text-center text-slate-500">
                    No employees found for the selected criteria
                </td>
            `;
            payrollDetailsTable.appendChild(emptyRow);
        }
    }

    function processPayroll() {
        const payrollData = Array.from(payrollDetailsTable.querySelectorAll('tr')).map(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 3) {
                const nameCode = cells[0].textContent.split('(');
                const employeeName = nameCode[0].trim();
                const employeeCode = nameCode[1] ? nameCode[1].replace(')', '').trim() : '';
                const baseSalary = cells[2].textContent.replace('$', '').replace(',', '');

                return {
                    employee_name: employeeName,
                    employee_code: employeeCode,
                    base_salary: baseSalary
                };
            }
            return null;
        }).filter(item => item);

        const month = document.getElementById('generate-month').value;

        if (!payrollData.length) {
            showToast('No payroll data to process', 'error');
            return;
        }

        // Show loading state
        processPayrollBtn.disabled = true;
        processPayrollBtn.innerHTML = '<x-base.lucide icon="Loader" class="w-4 h-4 mr-2 animate-spin"></x-base.lucide>Processing...';

        fetch('{{ route("hr.payroll.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                payroll_data: payrollData,
                month: month
            }),
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Payroll processed successfully', 'success');

                // Close modal and refresh table
                const modal = document.getElementById('generate-payroll-modal');
                if (modal) {
                    modal.__tippy?.hide();
                }

                // Reset form
                document.getElementById('generate-payroll-form').reset();
                payrollPreview.classList.add('hidden');
                payrollEmptyState.classList.remove('hidden');
                processPayrollBtn.classList.add('hidden');

                // Refresh main table
                if (window.payrollTable) {
                    window.payrollTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to process payroll', 'error');
            }
        })
        .catch(error => {
            console.error('Error processing payroll:', error);
            showToast('An error occurred while processing payroll', 'error');
        })
        .finally(() => {
            processPayrollBtn.disabled = false;
            processPayrollBtn.innerHTML = '<x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-2"></x-base.lucide>Process Payroll';
        });
    }

    function loadDepartmentsForCompany(companyId, departmentSelect) {
        if (!departmentSelect) return;

        departmentSelect.innerHTML = '<option value="">Loading departments...</option>';

        if (!companyId) {
            departmentSelect.innerHTML = '<option value="">All Departments</option>';
            return;
        }

        fetch(`/hr/departments/api/company/${companyId}`, {
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            departmentSelect.innerHTML = '<option value="">All Departments</option>';
            if (data && Array.isArray(data)) {
                data.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept.id;
                    option.textContent = dept.name;
                    departmentSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading departments:', error);
            departmentSelect.innerHTML = '<option value="">Error loading departments</option>';
        });
    }
});
</script>
