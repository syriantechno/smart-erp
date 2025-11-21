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
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Leave Overview -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <div>
                        <h2 class="text-lg font-medium leading-tight">
                            Leave Management
                        </h2>
                        <p class="text-slate-500 text-sm">Track requests, decisions, and balances in one view.</p>
                    </div>
                    <div class="ml-auto flex flex-wrap gap-2">
                        <button type="button"
                            class="btn-tonal btn-tonal--success group"
                            data-tw-toggle="modal"
                            data-tw-target="#create-leave-modal">
                            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                            Log Leave Request
                        </button>
                        <button type="button" class="btn-tonal btn-tonal--info group" id="leave-export-summary">
                            <x-base.lucide icon="download" class="w-5 h-5 icon-hover-rise" />
                            Export Summary
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="calendar" class="report-box__icon text-primary" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer"
                                            title="Tracked requests this quarter">
                                            +8%
                                            <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6" data-leave-total>0</div>
                                <div class="text-base text-slate-500 mt-1">Total Leave Requests</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="check-circle" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer"
                                            title="Compared to last month">
                                            +2%
                                            <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6" data-leave-approved>0</div>
                                <div class="text-base text-slate-500 mt-1">Approved Leaves</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="clock" class="report-box__icon text-warning" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer"
                                            title="In manager review">
                                            3 cases
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6" data-leave-pending>0</div>
                                <div class="text-base text-slate-500 mt-1">Pending Decisions</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="x-circle" class="report-box__icon text-danger" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-danger tooltip cursor-pointer"
                                            title="Declined requests">
                                            Stable
                                        </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6" data-leave-rejected>0</div>
                                <div class="text-base text-slate-500 mt-1">Rejected Leaves</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Leave Overview -->

            <div class="col-span-12">
                <x-base.preview-component class="intro-y box">
                    <div class="p-5">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-slate-800">Leave Ledger</h3>
                                <p class="text-sm text-slate-500">Filter, edit, and export leave requests.</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" id="leave-refresh"
                                    class="btn-tonal btn-tonal--sky btn-tonal--icon group"
                                    title="Refresh data">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                                <button type="button" id="leave-export"
                                    class="btn-tonal btn-tonal--lime btn-tonal--icon group"
                                    title="Export to Excel">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                                <button type="button" id="leave-pdf"
                                    class="btn-tonal btn-tonal--rose btn-tonal--icon group"
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
                                    <button type="button" id="leave-filter-apply" class="btn-tonal btn-tonal--info group w-full sm:w-auto">
                                        <x-base.lucide icon="search" class="w-4 h-4" />
                                        Apply Filter
                                    </button>
                                    <button type="button" id="leave-filter-reset" class="btn-tonal btn-tonal--amber group w-full sm:w-auto">
                                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4" />
                                        Reset
                                    </button>
                                </div>
                                <p class="text-xs text-slate-500">Filters update the live dataset instantly.</p>
                            </div>
                        </form>

                        <div class="mt-6 overflow-x-auto" data-erp-table-wrapper>
                            <table id="leave-table" class="datatable-default w-full table-auto text-left text-sm" data-erp-table>
                                <thead>
                                    <tr>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap">Request</th>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap">Employee</th>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap">Period</th>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap">Reason</th>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap text-center">Status</th>
                                        <th class="px-5 py-2 border-b font-semibold whitespace-nowrap text-center">Actions</th>
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
</div>
@endsection

@stack('modals')
@include('components.datatable.scripts')
