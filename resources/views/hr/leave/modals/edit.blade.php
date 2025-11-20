@php
    $leaveTypes = $leaveTypes ?? [];
    $leaveReasons = $leaveReasons ?? [];
    $leaveStatuses = $leaveStatuses ?? [];
    $employees = $employees ?? collect();
@endphp

@push('modals')
    <x-modal.form id="edit-leave-modal" title="Edit Leave Request" class="hidden max-w-4xl">
        <form id="edit-leave-form" action="#" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" />
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-4">
                    <x-base.form-label for="edit-leave-code">Request Code</x-base.form-label>
                    <x-base.form-input id="edit-leave-code" type="text" class="w-full bg-slate-100" readonly />
                </div>
                <div class="col-span-12 md:col-span-8">
                    <x-base.form-label for="edit-leave-employee-id">Employee <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-leave-employee-id" name="employee_id" class="w-full" required>
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
                    <p id="edit-leave-employee-meta" class="mt-1 text-xs text-slate-500">Employee meta info will appear here.</p>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-type">Leave Type <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-leave-type" name="leave_type" class="w-full" required>
                        @foreach ($leaveTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-reason">Reason Category</x-base.form-label>
                    <x-base.form-select id="edit-leave-reason" name="reason_category" class="w-full">
                        <option value="">Select Reason</option>
                        @foreach ($leaveReasons as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-start-date">Start Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-leave-start-date" name="start_date" type="date" class="w-full" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-end-date">End Date <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-leave-end-date" name="end_date" type="date" class="w-full" required />
                </div>
                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-days">Total Days</x-base.form-label>
                    <x-base.form-input id="edit-leave-days" type="number" class="w-full bg-slate-100" readonly />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-leave-reason-details">Leave Reason</x-base.form-label>
                    <x-base.form-textarea id="edit-leave-reason-details" name="reason_details" rows="3" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-leave-notes">Internal Notes</x-base.form-label>
                    <x-base.form-textarea id="edit-leave-notes" name="notes" rows="3" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12 md:col-span-3">
                    <x-base.form-label for="edit-leave-status">Status</x-base.form-label>
                    <x-base.form-select id="edit-leave-status" name="status" class="w-full">
                        @foreach ($leaveStatuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12 md:col-span-3 flex items-end">
                    <label class="form-switch">
                        <input id="edit-leave-paid" name="is_paid" type="checkbox" class="form-check-input">
                        <span class="ml-2">Paid Leave</span>
                    </label>
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button type="button" class="btn-tonal btn-tonal--neutral group" data-tw-dismiss="modal">
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Close
                </button>
                <button type="submit" form="edit-leave-form" class="btn-tonal btn-tonal--success group">
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Update Request
                </button>
            </div>
        @endslot
    </x-modal.form>
@endpush
