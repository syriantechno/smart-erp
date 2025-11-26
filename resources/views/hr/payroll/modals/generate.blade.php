{{-- Generate Payroll Modal --}}
<x-modal.form id="generate-modal" title="Generate Payroll" size="lg">
    <form id="generate-form" method="POST">
        @csrf

        <div class="mb-6">
            <div class="p-4 bg-blue-50 rounded-lg mb-4">
                <div class="flex items-start gap-3">
                    <x-base.lucide icon="info" class="w-5 h-5 text-blue-600 mt-0.5" />
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Payroll Generation</p>
                        <p>This will calculate salaries based on attendance data, overtime hours, and configured settings.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4">
            {{-- Month --}}
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="generate-month">
                    Month <span class="text-danger">*</span>
                </x-base.form-label>
                <x-base.form-select id="generate-month" name="month" class="w-full" required>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </x-base.form-select>
            </div>

            {{-- Year --}}
            <div class="col-span-12 md:col-span-6">
                <x-base.form-label for="generate-year">
                    Year <span class="text-danger">*</span>
                </x-base.form-label>
                <x-base.form-select id="generate-year" name="year" class="w-full" required>
                    @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </x-base.form-select>
            </div>

            {{-- Employee Selection --}}
            <div class="col-span-12">
                <x-base.form-label>Employees</x-base.form-label>
                <div class="flex items-center gap-4 mb-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="employee_selection" value="all" checked class="form-check-input mr-2">
                        <span>All Active Employees</span>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="employee_selection" value="selected" class="form-check-input mr-2">
                        <span>Select Specific Employees</span>
                    </label>
                </div>
                
                <div id="employee-select-wrapper" class="hidden">
                    <x-base.form-select id="generate-employees" name="employee_ids[]" class="w-full" multiple style="height: 150px;">
                        @foreach($employees ?? [] as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->full_name }} - {{ $emp->department->name ?? 'N/A' }}</option>
                        @endforeach
                    </x-base.form-select>
                    <div class="text-xs text-slate-500 mt-1">Hold Ctrl/Cmd to select multiple employees</div>
                </div>
            </div>
        </div>

        {{-- Calculation Preview --}}
        <div class="mt-6 p-4 bg-slate-50 rounded-lg">
            <h4 class="font-medium text-slate-700 mb-3 flex items-center gap-2">
                <x-base.lucide icon="calculator" class="w-4 h-4" />
                Calculation Settings (from Settings)
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-slate-500">Working Days/Month:</span>
                    <span class="font-medium ml-1">{{ \App\Models\Setting\Setting::get('attendance.working_days_per_month', 22) }}</span>
                </div>
                <div>
                    <span class="text-slate-500">Hours/Day:</span>
                    <span class="font-medium ml-1">{{ \App\Models\Setting\Setting::get('attendance.working_hours_per_day', 8) }}</span>
                </div>
                <div>
                    <span class="text-slate-500">OT Multiplier:</span>
                    <span class="font-medium ml-1">{{ \App\Models\Setting\Setting::get('attendance.overtime_multiplier', 1.5) }}x</span>
                </div>
                <div>
                    <span class="text-slate-500">Weekend OT:</span>
                    <span class="font-medium ml-1">{{ \App\Models\Setting\Setting::get('attendance.weekend_overtime_multiplier', 2) }}x</span>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                Cancel
            </button>
            <button type="submit" form="generate-form" id="btn-submit-generate" class="btn-royal btn-royal--gold">
                <x-base.lucide icon="calculator" class="w-4 h-4 mr-2" />
                Generate
            </button>
        </div>
    @endslot
</x-modal.form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectionRadios = document.querySelectorAll('input[name="employee_selection"]');
    const employeeWrapper = document.getElementById('employee-select-wrapper');

    selectionRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'selected') {
                employeeWrapper.classList.remove('hidden');
            } else {
                employeeWrapper.classList.add('hidden');
            }
        });
    });
});
</script>
@endpush
