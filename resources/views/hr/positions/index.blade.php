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
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Positions Management</h2>
        <button
            type="button"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#create-position-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Position
        </button>
    </div>

    <!-- Hidden button to trigger edit modal -->
    <button id="edit-modal-trigger" data-tw-toggle="modal" data-tw-target="#edit-position-modal" class="hidden"></button>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="positions-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="positions-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="title">Title</option>
                                    <option value="code">Code</option>
                                    <option value="department">Department</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="positions-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="positions-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="positions-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="positions-filter-go" type="button" class="btn-tonal btn-tonal--info w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="positions-filter-reset" type="button" class="btn-tonal btn-tonal--amber w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <button type="button" class="btn-tonal btn-tonal--purple btn-tonal--icon group" title="Print">
                                <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button type="button" class="btn-tonal btn-tonal--rose btn-tonal--icon group" title="Export PDF">
                                <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="positions-export" type="button" class="btn-tonal btn-tonal--lime btn-tonal--icon group" title="Export to Excel">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="positions-refresh" type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
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
            <div class="flex w-full flex-wrap justify-end gap-2">
                <button
                    type="button"
                    class="btn-tonal btn-tonal--neutral group"
                    data-tw-dismiss="modal"
                >
                    <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                    Cancel
                </button>
                <button
                    type="submit"
                    form="edit-position-form"
                    class="btn-tonal btn-tonal--success group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Update
                </button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@include('components.datatable.scripts')
