@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Positions Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* Make table more compact with better readability */
        #positions-table {
            font-size: 0.95rem; /* 15px - slightly larger */
            line-height: 1.4;
        }

        #positions-table tbody tr {
            height: 2.25rem; /* 36px - more compact */
        }

        #positions-table th {
            font-size: 0.8rem; /* 13px - slightly larger headers */
            font-weight: 700;
            padding: 0.5rem 1.25rem; /* py-2 px-5 */
        }

        #positions-table td {
            padding: 0.375rem 1.25rem; /* py-1.5 px-5 - even more compact */
        }

        /* Status badges - compact and readable */
        #positions-table .inline-flex {
            padding: 0.125rem 0.5rem; /* 2px 8px */
            font-weight: 600;
        }

        /* Actions column - keep compact */
        #positions-table .px-5.py-1\.5 {
            padding: 0.375rem 1.25rem;
        }

        #positions-table thead th,
        #positions-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #positions-table .datatable-cell-wrap {
            text-align: center;
        }

        #positions-table [class^="stats-card-"],
        #positions-table [class*=" stats-card-"] {
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .icon-hover-rise {
            transition: transform 200ms ease;
        }

        .group:hover .icon-hover-rise {
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="briefcase" class="w-7 h-7" />
                <span>Positions Management</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive positions --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="pause-circle" class="w-4 h-4" />
                        </div>
                        <div id="stats-inactive" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $positionsInactive ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Inactive
                    </div>
                </div>

                {{-- Active positions --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div id="stats-active" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $positionsActive ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Active
                    </div>
                </div>

                {{-- Total positions --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="briefcase" class="w-4 h-4" />
                        </div>
                        <div id="stats-total" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $positionsTotal ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Positions
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-modal-trigger" data-tw-toggle="modal" data-tw-target="#edit-position-modal" class="hidden"></button>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="positions-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Department Filter --}}
                        <x-base.form-select id="department-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Depts</option>
                            @foreach($departments ?? [] as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </x-base.form-select>

                        {{-- Status Filter --}}
                        <x-base.form-select id="status-filter" class="w-auto text-sm py-1.5">
                            <option value="">Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="positions-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="positions-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button id="positions-print" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button id="positions-export-pdf" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="positions-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="positions-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Position Button --}}
                            <x-base.tippy content="Add position" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#create-position-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="positions-table"
                            data-tw-merge
                            data-erp-table
                            data-positions-datatable-url="{{ route('hr.positions.datatable') }}"
                            data-positions-delete-url-base="{{ url('hr/positions') }}"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Salary Range</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    @include('hr.positions.modals.create')
    @stack('modals')

    <form id="positions-export-pdf-form" action="{{ route('hr.positions.export-pdf') }}" method="POST" target="_blank" class="hidden">
        @csrf
    </form>
    <form id="positions-export-excel-form" action="{{ route('hr.positions.export-excel') }}" method="GET" target="_blank" class="hidden"></form>

    <!-- Single Edit Modal -->
    <x-modal.form id="edit-position-modal" title="Edit Position">
        <form
            id="edit-position-form"
            action=""
            method="POST"
            data-update-url-base="{{ url('hr/positions') }}"
        >
            @csrf
            @method('PUT')
            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-position-code">Position Code</x-base.form-label>
                    <x-base.form-input id="edit-position-code" type="text" class="w-full" readonly />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-title">Position Title <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="edit-title" name="title" type="text" placeholder="Enter position title" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-department_id">Department <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="edit-department_id" name="department_id" class="w-full" required>
                        <option value="">Select Department</option>
                        @foreach(\App\Models\HR\Department::active()->get() as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-salary_range_min">Minimum Salary</x-base.form-label>
                    <x-base.form-input
                        id="edit-salary_range_min"
                        name="salary_range_min"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full"
                        lang="en"
                        dir="ltr"
                        inputmode="decimal"
                    />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-salary_range_max">Maximum Salary</x-base.form-label>
                    <x-base.form-input
                        id="edit-salary_range_max"
                        name="salary_range_max"
                        type="number"
                        step="0.01"
                        min="0"
                        class="w-full"
                        lang="en"
                        dir="ltr"
                        inputmode="decimal"
                    />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-description">Description</x-base.form-label>
                    <x-base.form-textarea id="edit-description" name="description" rows="3" placeholder="Enter position description" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-requirements">Requirements</x-base.form-label>
                    <x-base.form-textarea id="edit-requirements" name="requirements" rows="3" placeholder="Enter requirements" class="w-full"></x-base.form-textarea>
                </div>

            </div>
        </form>

        @slot('footer')
            <div class="flex w-full flex-wrap justify-end gap-3">
                <button
                    type="button"
                    class="btn-royal btn-royal--outline btn-royal--sm group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="edit-position-form"
                    class="btn-royal btn-royal--gold btn-royal--sm group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Update
                </button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@include('components.datatable.scripts')
