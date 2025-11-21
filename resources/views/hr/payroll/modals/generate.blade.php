<!-- Generate Payroll Modal -->
<x-base.dialog
    id="generate-payroll-modal"
    size="lg"
    data-payroll-generate-url="{{ route('hr.payroll.generate') }}"
    data-payroll-process-url="{{ route('hr.payroll.process') }}"
    data-payroll-departments-url="{{ url('/hr/departments/api/company') }}"
>
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
                        <x-base.form-select id="generate-company-filter" class="w-full" data-payroll-company-select>
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
                        <x-base.form-select id="generate-department-filter" class="w-full" data-payroll-department-select>
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
