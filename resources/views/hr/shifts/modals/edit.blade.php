<!-- Edit Shift Modal -->
<x-modal.form id="edit-shift-modal" title="Edit Shift" size="xl">
    <form id="edit-shift-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-shift-id" name="id" value="">

        <!-- Basic Information -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="info" class="h-5 w-5"></x-base.lucide>
                Basic Information
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <!-- Code -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-shift-code">Code</x-base.form-label>
                    <x-base.form-input id="edit-shift-code" type="text" class="w-full bg-slate-100" readonly />
                </div>

                <!-- Name -->
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-shift-name">Shift Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-shift-name" name="name" type="text" class="w-full" required />
                </div>

                <!-- Description -->
                <div class="col-span-12">
                    <x-base.form-label for="edit-shift-description">Description</x-base.form-label>
                    <x-base.form-textarea id="edit-shift-description" name="description" rows="3" class="w-full"></x-base.form-textarea>
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="clock" class="h-5 w-5"></x-base.lucide>
                Working Hours
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-start-time">Start Time <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-start-time" name="start_time" type="time" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-end-time">End Time <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-end-time" name="end_time" type="time" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-working-hours">Working Hours</x-base.form-label>
                    <x-base.form-input id="edit-working-hours" name="working_hours" type="number" step="0.5" class="w-full" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-shift-color">Shift Color <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-shift-color" name="color" type="color" class="w-16 h-10 border rounded" required />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label>Status</x-base.form-label>
                    <div class="flex items-center">
                        <input type="checkbox" id="edit-is-active" name="is_active" value="1" class="form-check-input">
                        <label for="edit-is-active" class="ml-2">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Break Time -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="coffee" class="h-5 w-5"></x-base.lucide>
                Break Time
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-break-start">Break Start</x-base.form-label>
                    <x-base.form-input id="edit-break-start" name="break_start" type="time" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-break-end">Break End</x-base.form-label>
                    <x-base.form-input id="edit-break-end" name="break_end" type="time" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-break-hours">Break Hours</x-base.form-label>
                    <x-base.form-input id="edit-break-hours" name="break_hours" type="number" step="0.5" class="w-full" />
                </div>
            </div>
        </div>

        <!-- Work Days -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="calendar" class="h-5 w-5"></x-base.lucide>
                Work Days
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                    <label class="flex items-center">
                        <input type="checkbox" name="work_days[]" value="{{ $day }}" class="form-check-input edit-work-day">
                        <span class="ml-2">{{ ucfirst($day) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Applicability -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <x-base.lucide icon="target" class="h-5 w-5"></x-base.lucide>
                Apply Shift To
            </h4>
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-applicable-to">Apply To <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-applicable-to" name="applicable_to" class="w-full" required>
                        <option value="company">Entire Company</option>
                        <option value="department">Specific Department</option>
                        <option value="employee">Specific Employee</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4" id="edit-company-selection">
                    <x-base.form-label for="edit-company-id">Company</x-base.form-label>
                    <x-base.form-select id="edit-company-id" name="company_id" class="w-full">
                        <option value="">Select Company</option>
                        @foreach(\App\Models\Setting\Company::active()->get() as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4" id="edit-department-selection" style="display: none;">
                    <x-base.form-label for="edit-department-id">Department</x-base.form-label>
                    <x-base.form-select id="edit-department-id" name="department_id" class="w-full">
                        <option value="">Select Department</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-4" id="edit-employee-selection" style="display: none;">
                    <x-base.form-label for="edit-employee-id">Employee</x-base.form-label>
                    <x-base.form-select id="edit-employee-id" name="employee_id" class="w-full">
                        <option value="">Select Employee</option>
                    </x-base.form-select>
                </div>
            </div>
        </div>
    </form>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                Cancel
            </button>
            <button type="button" id="update-shift-btn" class="btn-royal btn-royal--gold group" onclick="submitEditShiftForm()">
                <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                Update
            </button>
        </div>
    @endslot
</x-modal.form>

<!-- View Shift Modal -->
<x-modal.form id="view-shift-modal" title="Shift Details" size="lg">
    <div id="view-shift-content">
        <div class="text-center py-8">
            <x-base.lucide icon="loader-2" class="w-8 h-8 mx-auto animate-spin text-slate-400" />
            <p class="mt-2 text-slate-500">Loading...</p>
        </div>
    </div>

    @slot('footer')
        <div class="flex w-full flex-wrap justify-end gap-2">
            <button type="button" class="btn-royal btn-royal--outline group" data-tw-dismiss="modal">
                <x-base.lucide icon="x-circle" class="w-5 h-5" />
                Close
            </button>
        </div>
    @endslot
</x-modal.form>
