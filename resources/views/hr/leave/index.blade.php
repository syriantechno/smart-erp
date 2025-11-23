@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@php
    $leaveTypes = $leaveTypes ?? [
        'annual' => 'Annual Leave',
        'sick' => 'Sick Leave',
        'unpaid' => 'Unpaid Leave',
        'emergency' => 'Emergency Leave',
        'maternity' => 'Maternity / Paternity',
    ];

    $leaveReasons = $leaveReasons ?? [
        'vacation' => 'Vacation & Travel',
        'medical' => 'Medical Appointment',
        'family' => 'Family Obligation',
        'remote' => 'Remote Work Request',
        'other' => 'Other Reason',
    ];

    $leaveStatuses = $leaveStatuses ?? [
        'pending' => 'Pending Review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    $employees = $employees ?? collect();
@endphp

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
<div
    id="leave-page"
    data-leave-datatable-url="{{ route('hr.leave.datatable') }}"
    data-leave-summary-url="{{ route('hr.leave.summary') }}"
    data-leave-preview-url="{{ route('hr.leave.preview-code') }}"
    data-leave-base-url="{{ route('hr.leave.index') }}"
>
<div class="mt-8 flex items-center">
    <h2 class="mr-auto text-lg font-medium">Leave Management</h2>
    <div class="ml-auto flex flex-wrap gap-2">
        <button type="button"
            class="btn-royal btn-royal--gold group"
            data-tw-toggle="modal"
            data-tw-target="#create-leave-modal">
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Log Leave Request
        </button>
        <button type="button" class="btn-royal btn-royal--outline group" id="leave-export-summary">
            <x-base.lucide icon="download" class="w-5 h-5 icon-hover-rise" />
            Export Summary
        </button>
    </div>
</div>
<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="flex flex-col gap-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-r from-royalDark to-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="calendar" class="w-8 h-8 text-royalYellow" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Total Requests</p>
                            <p class="text-royalYellow text-2xl font-bold" data-leave-total>0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="check-circle" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Approved</p>
                            <p class="text-white text-2xl font-bold" data-leave-approved>0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="clock" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Pending</p>
                            <p class="text-white text-2xl font-bold" data-leave-pending>0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="x-circle" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Rejected</p>
                            <p class="text-white text-2xl font-bold" data-leave-rejected>0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">Leave Ledger</h3>
                            <p class="text-sm text-slate-500">Filter, edit, and export leave requests.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="leave-refresh"
                                class="btn-royal btn-royal--outline btn-royal--icon group"
                                title="Refresh data">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button type="button" id="leave-export"
                                class="btn-royal btn-royal--outline btn-royal--icon group"
                                title="Export to Excel">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button type="button" id="leave-pdf"
                                class="btn-royal btn-royal--outline btn-royal--icon group"
                                title="Export PDF">
                                <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                        <form id="leave-filter-form" class="mt-6 grid grid-cols-12 gap-4 rounded-xl border border-slate-200/70 p-4">
                            <div class="col-span-12 lg:col-span-4 flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-600">Quick Search</label>
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <x-base.form-select id="leave-filter-field" class="w-full">
                                        <option value="all">All Fields</option>
                                        <option value="code">Request Code</option>
                                        <option value="employee">Employee Name</option>
                                        <option value="department">Department</option>
                                        <option value="type">Leave Type</option>
                                    </x-base.form-select>
                                    <x-base.form-select id="leave-filter-type" class="w-full">
                                        <option value="contains">Contains</option>
                                        <option value="equals">Equals</option>
                                        <option value="starts">Starts with</option>
                                    </x-base.form-select>
                                </div>
                                <x-base.form-input id="leave-filter-value" type="text" placeholder="Search term..." />
                            </div>

                            <div class="col-span-12 lg:col-span-4 grid grid-cols-12 gap-2">
                                <div class="col-span-12 sm:col-span-6">
                                    <label class="text-sm font-semibold text-slate-600">Leave Type</label>
                                    <x-base.form-select id="leave-filter-type-select" class="w-full">
                                        <option value="">All Types</option>
                                        @foreach ($leaveTypes as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 sm:col-span-6">
                                    <label class="text-sm font-semibold text-slate-600">Status</label>
                                    <x-base.form-select id="leave-filter-status" class="w-full">
                                        <option value="">All Statuses</option>
                                        @foreach ($leaveStatuses as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-6">
                                    <label class="text-sm font-semibold text-slate-600">From</label>
                                    <x-base.form-input id="leave-filter-from" type="date" />
                                </div>
                                <div class="col-span-6">
                                    <label class="text-sm font-semibold text-slate-600">To</label>
                                    <x-base.form-input id="leave-filter-to" type="date" />
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4 flex flex-col gap-2">
                                <label class="text-sm font-semibold text-slate-600">Actions</label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" id="leave-filter-apply" class="btn-royal btn-royal--gold group w-full sm:w-auto">
                                        <x-base.lucide icon="search" class="w-4 h-4" />
                                        Apply Filter
                                    </button>
                                    <button type="button" id="leave-filter-reset" class="btn-royal btn-royal--outline group w-full sm:w-auto">
                                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4" />
                                        Reset
                                    </button>
                                </div>
                                <p class="text-xs text-slate-500">Filters update the live dataset instantly.</p>
                            </div>
                        </form>

                        <div class="mt-6 overflow-x-auto" data-erp-table-wrapper>
                            <table id="leave-table" class="datatable-default w-full table-auto text-left text-sm" data-erp-table>
                                <thead class="bg-gradient-to-r from-royalDark to-gray-800 text-white">
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium whitespace-nowrap">Request</th>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium whitespace-nowrap">Employee</th>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium whitespace-nowrap">Period</th>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium whitespace-nowrap">Reason</th>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium text-center whitespace-nowrap">Status</th>
                                        <th class="px-5 py-3 border-b-2 dark:border-darkmode-300 font-medium text-center whitespace-nowrap">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="mt-4 rounded-lg bg-slate-50 p-4 text-sm text-slate-500">
                            <p class="font-semibold text-slate-700">Heads up!</p>
                            <p>The current data source is a curated sample to design the UX. Once the Leave API is ready, the same markup can be wired to the server-side datatable endpoint.</p>
                        </div>
                    </div>
                </x-base.preview-component>
            </div>
        </div>
    </div>

    @include('hr.leave.modals.create', compact('leaveTypes', 'leaveReasons', 'leaveStatuses', 'employees'))
    @include('hr.leave.modals.edit', compact('leaveTypes', 'leaveReasons', 'leaveStatuses', 'employees'))
    <button id="open-edit-leave-modal" data-tw-toggle="modal" data-tw-target="#edit-leave-modal" class="hidden"></button>
</div>
@endsection

@stack('modals')
@include('components.datatable.scripts')
