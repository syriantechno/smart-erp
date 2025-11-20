@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Approval Templates - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Approval Templates</h2>
        <button
            type="button"
            class="btn btn-primary"
            onclick="openCreateModal()"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            New Template
        </button>
    </div>

    @include('components.global-notifications')

    <div class="intro-y box mt-5">
        <div class="p-5">
            <table id="templates-table" class="display table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Levels</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <x-base.dialog id="template-modal" size="xl">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 id="modal-title" class="text-lg font-medium">Create Template</h2>
                <button type="button" class="text-slate-400" data-tw-dismiss="modal">
                    <x-base.lucide icon="X" class="w-4 h-4" />
                </button>
            </x-base.dialog.title>

            <x-base.dialog.description class="p-5">
                <form id="template-form">
                    @csrf
                    <input type="hidden" id="template-id" name="id">

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="form-label">Template Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="form-label">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="material_request">Material Request</option>
                                <option value="invoice">Invoice</option>
                                <option value="purchase_order">Purchase Order</option>
                                <option value="expense">Expense</option>
                                <option value="leave_request">Leave Request</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Levels -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="form-label mb-0">Approval Levels</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addLevel()">
                                    <x-base.lucide icon="Plus" class="w-3 h-3 mr-1" />
                                    Add Level
                                </button>
                            </div>
                            <div id="levels-container" class="space-y-3">
                                <!-- Levels will be added here -->
                            </div>
                        </div>

                        <!-- Active -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input" checked>
                            <label for="is_active" class="form-check-label ml-2">Active</label>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end gap-2">
                        <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </form>
            </x-base.dialog.description>
        </x-base.dialog.panel>
    </x-base.dialog>
@endsection

@push('scripts')
<script>
(function () {
    const jq = window.jQuery || window.$;
    if (!jq) {
        console.error('jQuery not available on approval templates page.');
        return;
    }

    let levelCounter = 0;
    let table;

    jq(function() {
        // Initialize DataTable
        table = window.erpCrud.initDataTable({
            tableSelector: '#templates-table',
            ajaxUrl: '{{ route("approval-system.templates.datatable") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'levels_count', name: 'levels_count', orderable: false },
                { data: 'status', name: 'is_active' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Form submit
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
                        table.ajax.reload();
                        jq('[data-tw-dismiss="modal"]').click();
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        });
    });

    window.openCreateModal = function () {
        jq('#modal-title').text('Create Template');
        jq('#template-form')[0].reset();
        jq('#template-id').val('');
        jq('#levels-container').empty();
        levelCounter = 0;
        addLevel(); // Add first level
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
                data.levels.forEach(level => {
                    addLevel(level);
                });
            } else {
                addLevel();
            }

            tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
        });
    };

    window.addLevel = function (levelData = null) {
        levelCounter++;
        const levelHtml = `
            <div class="level-item border rounded p-3" data-level="${levelCounter}">
                <div class="flex items-start gap-3">
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm">Level Name</label>
                            <input type="text" class="form-control level-name" placeholder="e.g., Department Manager" 
                                   value="${levelData?.name || 'Level ' + levelCounter}">
                        </div>
                        <div>
                            <label class="text-sm">Approver</label>
                            <select class="form-control level-approver" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" ${levelData?.approver_id == {{ $user->id }} ? 'selected' : ''}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger mt-6" onclick="removeLevel(${levelCounter})">
                        <x-base.lucide icon="Trash2" class="w-3 h-3" />
                    </button>
                </div>
            </div>
        `;
        jq('#levels-container').append(levelHtml);
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
                            table.ajax.reload();
                        }
                    }
                });
            }
        });
    };
})();
</script>
@endpush
