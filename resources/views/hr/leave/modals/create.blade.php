@php
    $leaveTypes = $leaveTypes ?? [];
    $leaveReasons = $leaveReasons ?? [];
    $leaveStatuses = $leaveStatuses ?? [];
    $employees = $employees ?? collect();
@endphp

@push('modals')
    <x-modal.form id="create-leave-modal" title="Log Leave Request" class="hidden max-w-4xl">
        <form id="create-leave-form" action="{{ route('hr.leave.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="create-leave-code">Request Code</x-base.form-label>
                    <x-base.form-input id="create-leave-code" type="text" class="w-full bg-slate-100" readonly />
                </div>
                <div class="col-span-12 md:col-span-8">
                    <x-base.form-label for="create-leave-employee-id">Employee <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="create-leave-employee-id" name="employee_id" class="w-full" required>
                        <option value="">Select employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                data-position="{{ $employee->position ?? '' }}"
                                data-department="{{ $employee->department->name ?? '' }}"
                                data-company="{{ $employee->company->name ?? '' }}"
                                data-avatar="{{ $employee->profile_picture_url }}"
                            >
                                {{ $employee->full_name }} ({{ $employee->code }})
                            </option>
                        @endforeach
                    </x-base.form-select>
                    <p id="create-leave-employee-meta" class="mt-1 text-xs text-slate-500">Select an employee to view details.</p>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-type">Leave Type <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="create-leave-type" name="leave_type" class="w-full" required>
                        <option value="">Select Type</option>
                        @foreach ($leaveTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-reason">Reason Category</x-base.form-label>
                    <x-base.form-select id="create-leave-reason" name="reason_category" class="w-full">
                        <option value="">Select Reason</option>
                        @foreach ($leaveReasons as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-start-date">Start Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="create-leave-start-date" name="start_date" type="date" class="w-full" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-end-date">End Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="create-leave-end-date" name="end_date" type="date" class="w-full" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-days">Total Days</x-base.form-label>
                    <x-base.form-input id="create-leave-days" type="number" class="w-full bg-slate-100" readonly />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="create-leave-reason-details">Leave Reason</x-base.form-label>
                    <x-base.form-textarea id="create-leave-reason-details" name="reason_details" rows="3" placeholder="Describe why the employee is requesting this leave." class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="create-leave-notes">Internal Notes</x-base.form-label>
                    <x-base.form-textarea id="create-leave-notes" name="notes" rows="3" placeholder="Optional notes for approvers." class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="create-leave-status">Status</x-base.form-label>
                    <x-base.form-select id="create-leave-status" name="status" class="w-full">
                        @foreach ($leaveStatuses as $key => $label)
                            <option value="{{ $key }}" @selected($key === 'pending')>{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-3 flex items-end">
                    <label class="form-switch">
                        <input id="create-leave-paid" name="is_paid" type="checkbox" class="form-check-input" checked>
                        <span class="ml-2">Paid Leave</span>
                    </label>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button type="button" class="btn-tonal btn-tonal--neutral group" data-tw-dismiss="modal">
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button type="submit" form="create-leave-form" class="btn-tonal btn-tonal--success group">
                    <x-base.lucide icon="check-circle" class="w-5 h-5 icon-hover-rise" />
                    Save Request
                </button>
            </div>
        @endslot
    </x-modal.form>
@endpush
