{{-- Bulk Attendance Entry Modal --}}
<x-modal.form id="bulk-modal" title="Bulk Attendance Entry" size="xl">
    <form id="bulk-form" method="POST">
        @csrf

        {{-- Selection Section --}}
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="filter" class="h-4 w-4 text-primary" />
                Selection Criteria
            </h4>
            <div class="grid grid-cols-12 gap-4">
                {{-- Date --}}
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="bulk_date">
                        Date <span class="text-danger">*</span>
                    </x-base.form-label>
                    <div class="relative">
                        <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500">
                            <x-base.lucide icon="calendar" class="w-4 h-4" />
                        </div>
                        <x-base.form-input 
                            type="date" 
                            id="bulk_date" 
                            name="bulk_date" 
                            class="pl-12 w-full" 
                            value="{{ now()->format('Y-m-d') }}"
                            required 
                        />
                    </div>
                </div>

                {{-- Department --}}
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="bulk_department">Department</x-base.form-label>
                    <x-base.form-select id="bulk_department" name="bulk_department" class="w-full">
                        <option value="">All Departments</option>
                        @foreach($departments ?? [] as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                {{-- Default Status --}}
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="bulk_status">Default Status</x-base.form-label>
                    <x-base.form-select id="bulk_status" name="bulk_status" class="w-full">
                        <option value="present">✓ Present</option>
                        <option value="absent">✗ Absent</option>
                        <option value="vacation">🏖️ Vacation</option>
                        <option value="holiday">🎉 Holiday</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mb-4 flex flex-wrap gap-2">
            <button type="button" id="btn-select-all" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="check-square" class="w-4 h-4 mr-1" />
                Select All
            </button>
            <button type="button" id="btn-deselect-all" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="square" class="w-4 h-4 mr-1" />
                Deselect All
            </button>
            <button type="button" id="btn-apply-status" class="btn-royal btn-royal--dark btn-royal--sm">
                <x-base.lucide icon="check" class="w-4 h-4 mr-1" />
                Apply Status to Selected
            </button>
        </div>

        {{-- Employees Table --}}
        <div class="mb-4">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="users" class="h-4 w-4 text-primary" />
                Employees
            </h4>
            <div class="overflow-x-auto max-h-[400px] border rounded-lg">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 sticky top-0">
                        <tr>
                            <th class="px-3 py-2 text-left w-10">
                                <input type="checkbox" id="bulk-check-all" class="form-check-input">
                            </th>
                            <th class="px-3 py-2 text-left">Employee</th>
                            <th class="px-3 py-2 text-left">Department</th>
                            <th class="px-3 py-2 text-center w-32">Status</th>
                            <th class="px-3 py-2 text-center w-24">Check In</th>
                            <th class="px-3 py-2 text-center w-24">Check Out</th>
                        </tr>
                    </thead>
                    <tbody id="bulk-employees-list">
                        @foreach($employees as $employee)
                        <tr class="border-b hover:bg-slate-50" data-employee-id="{{ $employee->id }}">
                            <td class="px-3 py-2">
                                <input type="checkbox" name="employees[]" value="{{ $employee->id }}" class="form-check-input bulk-employee-check">
                            </td>
                            <td class="px-3 py-2">
                                <div class="flex items-center gap-2">
                                    @if($employee->profile_picture_url)
                                        <img src="{{ $employee->profile_picture_url }}" class="w-8 h-8 rounded-full object-cover" alt="">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($employee->first_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold">{{ $employee->full_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $employee->position ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-2 text-slate-600">{{ $employee->department->name ?? 'N/A' }}</td>
                            <td class="px-3 py-2">
                                <select name="status_{{ $employee->id }}" class="form-select text-xs py-1 px-2 w-full bulk-status-select">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="vacation">Vacation</option>
                                    <option value="travel">Travel</option>
                                    <option value="half_day">Half Day</option>
                                    <option value="holiday">Holiday</option>
                                </select>
                            </td>
                            <td class="px-3 py-2">
                                <input type="time" name="check_in_{{ $employee->id }}" class="form-input text-xs py-1 px-2 w-full">
                            </td>
                            <td class="px-3 py-2">
                                <input type="time" name="check_out_{{ $employee->id }}" class="form-input text-xs py-1 px-2 w-full">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Summary --}}
        <div class="p-3 bg-slate-50 rounded-lg text-sm">
            <div class="flex items-center gap-4">
                <span class="text-slate-600">Selected:</span>
                <span id="bulk-selected-count" class="font-bold text-primary">0</span>
                <span class="text-slate-400">employees</span>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                Cancel
            </button>
            <button type="submit" form="bulk-form" id="btn-save-bulk" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save All
            </button>
        </div>
    @endslot
</x-modal.form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('bulk-check-all');
    const employeeChecks = document.querySelectorAll('.bulk-employee-check');
    const selectedCount = document.getElementById('bulk-selected-count');
    const bulkStatus = document.getElementById('bulk_status');
    const bulkDepartment = document.getElementById('bulk_department');

    // Update selected count
    function updateSelectedCount() {
        const checked = document.querySelectorAll('.bulk-employee-check:checked').length;
        selectedCount.textContent = checked;
    }

    // Check all
    checkAll.addEventListener('change', function() {
        const visibleRows = document.querySelectorAll('#bulk-employees-list tr:not(.hidden)');
        visibleRows.forEach(row => {
            const checkbox = row.querySelector('.bulk-employee-check');
            if (checkbox) checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    // Individual check
    employeeChecks.forEach(check => {
        check.addEventListener('change', updateSelectedCount);
    });

    // Select all button
    document.getElementById('btn-select-all').addEventListener('click', function() {
        const visibleRows = document.querySelectorAll('#bulk-employees-list tr:not(.hidden)');
        visibleRows.forEach(row => {
            const checkbox = row.querySelector('.bulk-employee-check');
            if (checkbox) checkbox.checked = true;
        });
        checkAll.checked = true;
        updateSelectedCount();
    });

    // Deselect all button
    document.getElementById('btn-deselect-all').addEventListener('click', function() {
        employeeChecks.forEach(check => check.checked = false);
        checkAll.checked = false;
        updateSelectedCount();
    });

    // Apply status to selected
    document.getElementById('btn-apply-status').addEventListener('click', function() {
        const status = bulkStatus.value;
        document.querySelectorAll('.bulk-employee-check:checked').forEach(check => {
            const row = check.closest('tr');
            const statusSelect = row.querySelector('.bulk-status-select');
            if (statusSelect) statusSelect.value = status;
        });
    });

    // Filter by department
    bulkDepartment.addEventListener('change', function() {
        const deptId = this.value;
        document.querySelectorAll('#bulk-employees-list tr').forEach(row => {
            if (!deptId || row.dataset.departmentId === deptId) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });

    // Form submit
    document.getElementById('bulk-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const btn = document.getElementById('btn-save-bulk');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin">⏳</span> Saving...';

        fetch('{{ route("hr.attendance.bulk-store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message || 'Attendance saved successfully');
                tailwind.Modal.getInstance(document.getElementById('bulk-modal')).hide();
                if (typeof loadAttendanceData === 'function') loadAttendanceData();
            } else {
                window.showError && showError(data.message || 'Failed to save attendance');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('An error occurred');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-4 h-4 mr-2"><use href="#icon-save"></use></svg> Save All';
        });
    });
});
</script>
@endpush
