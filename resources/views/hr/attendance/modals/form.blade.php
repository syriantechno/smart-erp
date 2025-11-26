{{-- Add/Edit Attendance Modal --}}
<x-modal.form id="attendance-modal" title="Add Attendance" size="lg">
    <form id="attendance-form" method="POST">
        @csrf
        <input type="hidden" name="id" value="">

        {{-- Entry Type Section --}}
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="settings-2" class="h-4 w-4 text-primary" />
                Entry Type
            </h4>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <div class="flex gap-6">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="entry_type" value="individual" checked class="form-check-input">
                            <span class="ml-3 text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">
                                Individual Employee
                            </span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="entry_type" value="department" class="form-check-input">
                            <span class="ml-3 text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">
                                Entire Department
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Selection Section --}}
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="users" class="h-4 w-4 text-primary" />
                Selection
            </h4>
            <div class="grid grid-cols-12 gap-4">
                {{-- Employee Selection --}}
                <div class="col-span-12" id="employee-selection-wrapper">
                    <x-base.form-label for="employee_id">
                        Employee <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-select id="employee_id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->full_name }} - {{ $employee->position ?? 'N/A' }}
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                {{-- Department Selection --}}
                <div class="col-span-12 hidden" id="department-selection-wrapper">
                    <x-base.form-label for="department_id">
                        Department <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-select id="department_id" name="department_id" class="w-full">
                        <option value="">Select Department</option>
                        @foreach($departments ?? [] as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
            </div>
        </div>

        {{-- Attendance Details Section --}}
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="calendar-check" class="h-4 w-4 text-primary" />
                Attendance Details
            </h4>
            <div class="grid grid-cols-12 gap-4">
                {{-- Date --}}
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="attendance_date">
                        Date <span class="text-danger">*</span>
                    </x-base.form-label>
                    <div class="relative">
                        <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700 z-10">
                            <x-base.lucide icon="calendar" class="w-4 h-4" />
                        </div>
                        <x-base.litepicker
                            id="attendance_date"
                            name="attendance_date"
                            class="pl-12 w-full"
                            data-single-mode="true"
                            data-format="YYYY-MM-DD"
                            value="{{ now()->format('Y-m-d') }}"
                            required
                        />
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="status">
                        Status <span class="text-danger">*</span>
                    </x-base.form-label>
                    <x-base.form-select id="status" name="status" class="w-full" required>
                        <option value="present">✓ Present</option>
                        <option value="absent">✗ Absent</option>
                        <option value="vacation">🏖️ Vacation</option>
                        <option value="travel">✈️ Travel</option>
                        <option value="half_day">½ Half Day</option>
                        <option value="holiday">🎉 Holiday</option>
                    </x-base.form-select>
                </div>

                {{-- Check In --}}
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="check_in">Check In Time</x-base.form-label>
                    <div class="relative">
                        <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700">
                            <x-base.lucide icon="log-in" class="w-4 h-4" />
                        </div>
                        <x-base.form-input type="time" id="check_in" name="check_in" class="pl-12 w-full" />
                    </div>
                </div>

                {{-- Check Out --}}
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="check_out">Check Out Time</x-base.form-label>
                    <div class="relative">
                        <div class="absolute flex h-full w-10 items-center justify-center rounded-l border bg-slate-100 text-slate-500 dark:border-darkmode-800 dark:bg-darkmode-700">
                            <x-base.lucide icon="log-out" class="w-4 h-4" />
                        </div>
                        <x-base.form-input type="time" id="check_out" name="check_out" class="pl-12 w-full" />
                    </div>
                </div>

                {{-- Shift --}}
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="shift_id">Shift</x-base.form-label>
                    <x-base.form-select id="shift_id" name="shift_id" class="w-full">
                        <option value="" data-hours="8">Auto Detect (8 hrs)</option>
                        @foreach($shifts ?? [] as $shift)
                            <option value="{{ $shift->id }}" data-hours="{{ $shift->working_hours ?? 8 }}">
                                {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }}) - {{ $shift->working_hours ?? 8 }}h
                            </option>
                        @endforeach
                    </x-base.form-select>
                </div>

                {{-- Working Hours (calculated) --}}
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label>Working Hours</x-base.form-label>
                    <div class="flex items-center h-[38px] px-3 bg-slate-50 rounded-md border border-slate-200">
                        <x-base.lucide icon="clock" class="w-4 h-4 text-slate-400 mr-2" />
                        <span id="working-hours-display" class="text-slate-600 font-medium">0.00 hrs</span>
                    </div>
                </div>
                
                {{-- Overtime Hours (calculated) --}}
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label>Overtime</x-base.form-label>
                    <div class="flex items-center h-[38px] px-3 bg-amber-50 rounded-md border border-amber-200">
                        <x-base.lucide icon="timer" class="w-4 h-4 text-amber-500 mr-2" />
                        <span id="overtime-hours-display" class="text-amber-600 font-medium">0.00 hrs</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes Section --}}
        <div class="mb-4">
            <h4 class="text-sm font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2 uppercase tracking-wide">
                <x-base.lucide icon="file-text" class="h-4 w-4 text-primary" />
                Notes
            </h4>
            <x-base.form-textarea 
                id="notes" 
                name="notes" 
                rows="2" 
                placeholder="Add any additional notes..." 
                class="w-full"
            ></x-base.form-textarea>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                Cancel
            </button>
            <button type="submit" form="attendance-form" id="btn-save-attendance" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save Attendance
            </button>
        </div>
    @endslot
</x-modal.form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle between individual and department selection
    const entryTypeRadios = document.querySelectorAll('input[name="entry_type"]');
    const employeeWrapper = document.getElementById('employee-selection-wrapper');
    const departmentWrapper = document.getElementById('department-selection-wrapper');

    entryTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'individual') {
                employeeWrapper.classList.remove('hidden');
                departmentWrapper.classList.add('hidden');
                document.getElementById('employee_id').required = true;
                document.getElementById('department_id').required = false;
            } else {
                employeeWrapper.classList.add('hidden');
                departmentWrapper.classList.remove('hidden');
                document.getElementById('employee_id').required = false;
                document.getElementById('department_id').required = true;
            }
        });
    });

    // Calculate working hours and auto-detect status
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const workingHoursDisplay = document.getElementById('working-hours-display');
    const overtimeHoursDisplay = document.getElementById('overtime-hours-display');
    const statusSelect = document.getElementById('status');
    const shiftSelect = document.getElementById('shift_id');
    
    // Get default shift working hours
    const defaultShiftHours = {{ $shifts->first()->working_hours ?? 8 }};

    function getRequiredHours() {
        const selectedShift = shiftSelect.options[shiftSelect.selectedIndex];
        if (selectedShift && selectedShift.dataset.hours) {
            return parseFloat(selectedShift.dataset.hours);
        }
        return defaultShiftHours;
    }

    function calculateWorkingHours() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        if (checkIn && checkOut) {
            const [inHours, inMinutes] = checkIn.split(':').map(Number);
            const [outHours, outMinutes] = checkOut.split(':').map(Number);

            let inTotalMinutes = inHours * 60 + inMinutes;
            let outTotalMinutes = outHours * 60 + outMinutes;

            // Handle overnight shifts
            if (outTotalMinutes <= inTotalMinutes) {
                outTotalMinutes += 24 * 60;
            }

            const diffMinutes = outTotalMinutes - inTotalMinutes;
            const workedHours = diffMinutes / 60;
            const requiredHours = getRequiredHours();
            
            // Calculate overtime
            const overtime = Math.max(0, workedHours - requiredHours);
            
            // Display working hours
            workingHoursDisplay.textContent = workedHours.toFixed(2) + ' hrs';
            
            // Display overtime
            if (overtime > 0) {
                overtimeHoursDisplay.textContent = '+' + overtime.toFixed(2) + ' hrs';
                overtimeHoursDisplay.parentElement.classList.remove('bg-amber-50', 'border-amber-200');
                overtimeHoursDisplay.parentElement.classList.add('bg-green-50', 'border-green-200');
                overtimeHoursDisplay.classList.remove('text-amber-600');
                overtimeHoursDisplay.classList.add('text-green-600');
            } else {
                overtimeHoursDisplay.textContent = '0.00 hrs';
                overtimeHoursDisplay.parentElement.classList.add('bg-amber-50', 'border-amber-200');
                overtimeHoursDisplay.parentElement.classList.remove('bg-green-50', 'border-green-200');
                overtimeHoursDisplay.classList.add('text-amber-600');
                overtimeHoursDisplay.classList.remove('text-green-600');
            }
            
            // Auto-detect status based on working hours
            autoDetectStatus(workedHours, requiredHours);
        } else {
            workingHoursDisplay.textContent = '0.00 hrs';
            overtimeHoursDisplay.textContent = '0.00 hrs';
        }
    }
    
    function autoDetectStatus(workedHours, requiredHours) {
        const halfDayThreshold = requiredHours / 2;
        
        if (workedHours <= 0) {
            // No hours worked
            statusSelect.value = 'absent';
        } else if (workedHours < halfDayThreshold + 1) {
            // Less than half day + 1 hour buffer = half day
            statusSelect.value = 'half_day';
        } else {
            // Full day or more
            statusSelect.value = 'present';
        }
    }

    checkInInput.addEventListener('change', calculateWorkingHours);
    checkOutInput.addEventListener('change', calculateWorkingHours);
    shiftSelect.addEventListener('change', function() {
        // Recalculate when shift changes
        if (checkInInput.value && checkOutInput.value) {
            calculateWorkingHours();
        }
    });
});
</script>
@endpush
