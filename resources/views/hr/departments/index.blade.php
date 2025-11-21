@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Departments Management - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Departments Management</h2>
        <button
            type="button"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            data-tw-toggle="modal"
            data-tw-target="#create-department-modal"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Department
        </button>
    </div>

    <div class="intro-y mt-6">
        <div class="box border-primary/10 bg-primary/5 p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">معاينة النمط الموحد للأزرار</h3>
                    <p class="text-sm text-slate-500">الأزرار التالية توضح درجات الألوان المتاحة؛ نعدّل الألوان أو الظلال حسب رغبتك قبل التعميم.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--info group">
                        <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 1
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--success group">
                        <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                        زر 2
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--warning">زر 3</button>
                    <button type="button" class="btn-tonal btn-tonal--danger group">
                        <x-base.lucide icon="trash-2" class="w-5 h-5 icon-hover-rise" />
                        زر 4
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--neutral group">
                        <x-base.lucide icon="x-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 5
                    </button>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--teal group">
                        <x-base.lucide icon="check-circle" class="w-5 h-5 icon-hover-rise" />
                        زر 6
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--purple group">
                        <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                        زر 7
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--rose group">
                        <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                        زر 8
                    </button>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button type="button" class="btn-tonal btn-tonal--sky group">
                        <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                        زر 9
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--amber group">
                        <x-base.lucide icon="sun" class="w-5 h-5 icon-hover-rise" />
                        زر 10
                    </button>
                    <button type="button" class="btn-tonal btn-tonal--lime group">
                        <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                        زر 11
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    @if (session('success'))
                        <x-base.alert class="mb-4" variant="success">
                            <div class="flex items-center">
                                <x-base.lucide icon="CheckCircle" class="w-5 h-5 mr-2" />
                                {{ session('success') }}
                            </div>
                        </x-base.alert>
                    @endif

                    @if (session('error'))
                        <x-base.alert class="mb-4" variant="danger">
                            <div class="flex items-center">
                                <x-base.lucide icon="AlertTriangle" class="w-5 h-5 mr-2" />
                                {{ session('error') }}
                            </div>
                        </x-base.alert>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="departments-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="departments-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="name">Name</option>
                                    <option value="company">Company</option>
                                    <option value="manager">Manager</option>
                                    <option value="employees_count">Employees</option>
                                    <option value="status">Status</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="departments-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="departments-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="departments-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="departments-filter-go" type="button" class="btn-tonal btn-tonal--info w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="departments-filter-reset" type="button" class="btn-tonal btn-tonal--amber w-full sm:w-24 group">
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
                            <button id="departments-export" type="button" class="btn-tonal btn-tonal--lime btn-tonal--icon group" title="Export to Excel">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button id="departments-refresh" type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="departments-table"
                            data-tw-merge
                            data-erp-table
                            data-departments-datatable-url="{{ route('hr.departments.datatable') }}"
                            data-departments-delete-url-base="{{ url('hr/departments') }}"
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Company</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Manager</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Employees</th>
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

    @include('hr.departments.modals.create')
    @include('hr.departments.modals.edit')
    <button id="edit-department-trigger" data-tw-toggle="modal" data-tw-target="#edit-department-modal" class="hidden"></button>
@endsection
@stack('modals')
@include('components.datatable.scripts')

