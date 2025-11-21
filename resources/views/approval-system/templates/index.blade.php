@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@php
    use Illuminate\Support\Str;
@endphp

@section('subhead')
    <title>Approval Templates - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <style>
        #templates-table {
            font-size: 0.95rem;
            line-height: 1.4;
        }

        #templates-table tbody tr {
            height: 2.25rem;
        }

        #templates-table th {
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.5rem 1.25rem;
        }

        #templates-table td {
            padding: 0.375rem 1.25rem;
        }

        #templates-table thead th,
        #templates-table tbody td {
            text-align: center;
            font-size: 0.9rem;
        }

        #templates-table .datatable-cell-wrap {
            text-align: center;
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
        <h2 class="mr-auto text-lg font-medium">Approval Templates</h2>
        <button
            type="button"
            class="btn-tonal btn-tonal--info w-40 sm:w-auto sm:ml-4 group"
            onclick="openCreateModal()"
        >
            <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
            Add Template
        </button>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        <form id="templates-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="template-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All Types</option>
                                    <option value="material_request">Material Request</option>
                                    <option value="invoice">Invoice</option>
                                    <option value="purchase_order">Purchase Order</option>
                                    <option value="expense">Expense</option>
                                    <option value="leave_request">Leave Request</option>
                                    <option value="other">Other</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Status
                                </label>
                                <x-base.form-select id="template-filter-status" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Search
                                </label>
                                <x-base.form-input id="template-filter-search" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="template-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <button id="template-filter-go" type="button" class="btn-tonal btn-tonal--info w-full sm:w-24 group">
                                    <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                    Go
                                </button>
                                <button id="template-filter-reset" type="button" class="btn-tonal btn-tonal--amber w-full sm:w-24 group">
                                    <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                    Reset
                                </button>
                            </div>
                        </form>

                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <button type="button" class="btn-tonal btn-tonal--purple btn-tonal--icon group" id="template-export" title="Export">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                            <button type="button" class="btn-tonal btn-tonal--sky btn-tonal--icon group" id="template-refresh" title="Refresh">
                                <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-5 overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="templates-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Name</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Levels</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-modal.form id="template-modal" title="Create Template" size="xl">
        <form id="template-form">
            @csrf
            <input type="hidden" id="template-id" name="id">

            <div class="grid grid-cols-12 gap-4 gap-y-4">
                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="name">Template Name <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-input id="name" name="name" type="text" placeholder="Enter template name" class="w-full" required />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="type">Type <span class="text-danger">*</span></x-base.form-label>
                    <x-base.form-select id="type" name="type" class="w-full" required>
                        <option value="">Select Type</option>
                        <option value="material_request">Material Request</option>
                        <option value="invoice">Invoice</option>
                        <option value="purchase_order">Purchase Order</option>
                        <option value="expense">Expense</option>
                        <option value="leave_request">Leave Request</option>
                        <option value="other">Other</option>
                    </x-base.form-select>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="description">Description</x-base.form-label>
                    <x-base.form-textarea id="description" name="description" rows="3" placeholder="Describe this approval flow" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Approval Levels</p>
                            <p class="text-xs text-slate-500">Add approvers in the order they must approve.</p>
                        </div>
                        <button type="button" class="btn-tonal btn-tonal--info group" onclick="addLevel()">
                            <x-base.lucide icon="plus" class="w-4 h-4 icon-hover-rise" />
                            Add Level
                        </button>
                    </div>
                    <div id="levels-container" class="mt-4 space-y-3"></div>

                    <template id="approval-level-template">
                        <div class="level-item rounded-2xl border border-dashed border-slate-200 bg-white p-4 shadow-sm" data-level="__LEVEL__">
                            <div class="grid grid-cols-12 gap-4 gap-y-4">
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label class="uppercase tracking-wide text-xs font-semibold text-slate-500">Level Name</x-base.form-label>
                                    <x-base.form-input type="text" class="level-name mt-1 w-full" placeholder="e.g., Department Manager" />
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <x-base.form-label class="uppercase tracking-wide text-xs font-semibold text-slate-500">Approver</x-base.form-label>
                                    <x-base.form-select class="level-approver mt-1 w-full" required>
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                                <div class="col-span-12 flex justify-end">
                                    <button type="button" class="btn-tonal btn-tonal--danger group" data-remove-level>
                                        <x-base.lucide icon="trash-2" class="w-4 h-4 icon-hover-rise" />
                                        Remove Level
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="col-span-12 flex items-center">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" id="is_active" name="is_active" class="form-check-input" checked>
                        <span>Active template</span>
                    </label>
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
                    form="template-form"
                    class="btn-tonal btn-tonal--success group"
                >
                    <x-base.lucide icon="save" class="w-5 h-5 icon-hover-rise" />
                    Save
                </button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@push('scripts')
<script>
(function () {
    const jq = window.jQuery || window.$;
    if (!jq) {
        console.error('jQuery not available on approval templates page.');
        return;
    }

    window.templatesTable = null;
    let levelCounter = 0;

    const filterType = jq('#template-filter-type');
    const filterStatus = jq('#template-filter-status');
    const filterSearch = jq('#template-filter-search');
    const lengthSelect = jq('#template-filter-length');
    const filterGoBtn = jq('#template-filter-go');
    const filterResetBtn = jq('#template-filter-reset');
    const exportBtn = jq('#template-export');
    const refreshBtn = jq('#template-refresh');

    jq(function() {
        initializeTemplatesTable();
        bindTemplateFilters();
        bindTemplateForm();
    });

    function initializeTemplatesTable() {
        const initialLength = parseInt(lengthSelect.val(), 10) || 25;

        window.templatesTable = window.erpCrud.initDataTable({
            tableSelector: '#templates-table',
            ajaxUrl: '{{ route("approval-system.templates.datatable") }}',
            ajaxData: function (d) {
                d.type = filterType.val();
                d.filter_status = filterStatus.val();
                d.page_length = parseInt(lengthSelect.val(), 10) || initialLength;
                d.search_value = filterSearch.val();
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'levels_count', name: 'levels_count', orderable: false, searchable: false },
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (value) {
                        if (window.erpCrud && typeof window.erpCrud.renderStatusBadge === 'function') {
                            return window.erpCrud.renderStatusBadge(value, {
                                labels: { active: 'ACTIVE', inactive: 'INACTIVE' }
                            });
                        }
                        return value ? 'ACTIVE' : 'INACTIVE';
                    }
                },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            pageLength: initialLength,
            drawCallback: function(settings) {
                const info = templatesTable?.page?.info?.call(templatesTable) ?? null;
                if (info) {
                    document.getElementById('templates-count').textContent = info.recordsTotal;
                }
            }
        });

        lengthSelect.on('change', function () {
            const newLength = parseInt(jq(this).val(), 10) || initialLength;
            templatesTable?.page.len(newLength).draw();
        });
    }

    function bindTemplateFilters() {
        const applyFilters = () => {
            const searchTerm = filterSearch.val() || '';
            templatesTable?.search(searchTerm).draw();
            templatesTable?.ajax.reload(null, false);
        };

        filterGoBtn.on('click', applyFilters);

        filterSearch.on('keyup', function (e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        filterType.on('change', applyFilters);
        filterStatus.on('change', applyFilters);

        filterResetBtn.on('click', function () {
            filterType.val('');
            filterStatus.val('');
            filterSearch.val('');
            lengthSelect.val('25');
            templatesTable?.search('').draw();
            templatesTable?.ajax.reload();
        });

        exportBtn.on('click', function () {
            if (window.erpCrud && typeof window.erpCrud.exportDataTable === 'function') {
                window.erpCrud.exportDataTable(templatesTable, 'approval-templates');
            }
        });

        refreshBtn.on('click', function () {
            templatesTable?.ajax.reload();
        });
    }

    function bindTemplateForm() {
        jq('#template-form').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                id: jq('#template-id').val(),
                name: jq('#name').val(),
                type: jq('#type').val(),
                description: jq('#description').val(),
                is_active: jq('#is_active').is(':checked') ? 1 : 0,
                levels: getLevelsData()
            };

            const url = formData.id 
                ? '{{ route("approval-system.templates.update", ":id") }}'.replace(':id', formData.id)
                : '{{ route("approval-system.templates.store") }}';

            const method = formData.id ? 'PUT' : 'POST';

            jq.ajax({
                url: url,
                method: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Success!', response.message, 'success');
                        templatesTable?.ajax.reload();
                        jq('[data-tw-dismiss="modal"]').trigger('click');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        });
    }

    window.openCreateModal = function () {
        jq('#modal-title').text('Create Template');
        jq('#template-form')[0].reset();
        jq('#template-id').val('');
        jq('#levels-container').empty();
        levelCounter = 0;
        addLevel();
        tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
    };

    window.editTemplate = function (id) {
        jq.get('{{ route("approval-system.templates.show", ":id") }}'.replace(':id', id), function(data) {
            jq('#modal-title').text('Edit Template');
            jq('#template-id').val(data.id);
            jq('#name').val(data.name);
            jq('#type').val(data.type);
            jq('#description').val(data.description);
            jq('#is_active').prop('checked', data.is_active);

            jq('#levels-container').empty();
            levelCounter = 0;

            if (data.levels && data.levels.length > 0) {
                data.levels.forEach(level => addLevel(level));
            } else {
                addLevel();
            }

            tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
        });
    };

    window.addLevel = function (levelData = null) {
        const template = document.getElementById('approval-level-template');
        if (!template) {
            return;
        }

        levelCounter++;

        const fragment = template.content.cloneNode(true);
        const levelItem = fragment.querySelector('.level-item');
        levelItem.dataset.level = levelCounter;

        const nameInput = fragment.querySelector('.level-name');
        if (nameInput) {
            nameInput.value = levelData?.name || `Level ${levelCounter}`;
        }

        const approverSelect = fragment.querySelector('.level-approver');
        if (approverSelect) {
            approverSelect.value = levelData?.approver_id || '';
        }

        const removeBtn = fragment.querySelector('[data-remove-level]');
        if (removeBtn) {
            removeBtn.setAttribute('onclick', `removeLevel(${levelCounter})`);
        }

        document.getElementById('levels-container').appendChild(fragment);
    };

    window.removeLevel = function (id) {
        jq(`.level-item[data-level="${id}"]`).remove();
    };

    function getLevelsData() {
        const levels = [];
        let levelNum = 1;

        jq('.level-item').each(function() {
            levels.push({
                level: levelNum++,
                name: jq(this).find('.level-name').val(),
                approver_id: parseInt(jq(this).find('.level-approver').val()),
                can_reject: true,
                is_required: true
            });
        });

        return levels;
    }

    window.deleteTemplate = function (id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                jq.ajax({
                    url: '{{ route("approval-system.templates.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            templatesTable?.ajax.reload();
                        }
                    }
                });
            }
        });
    };
})();
</script>
@endpush
