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
let levelCounter = 0;
let table;

$(document).ready(function() {
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
    $('#template-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            id: $('#template-id').val(),
            name: $('#name').val(),
            type: $('#type').val(),
            description: $('#description').val(),
            is_active: $('#is_active').is(':checked'),
            levels: getLevelsData()
        };

        const url = formData.id 
            ? '{{ route("approval-system.templates.update", ":id") }}'.replace(':id', formData.id)
            : '{{ route("approval-system.templates.store") }}';
        
        const method = formData.id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success!', response.message, 'success');
                    table.ajax.reload();
                    $('[data-tw-dismiss="modal"]').click();
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
            }
        });
    });
});

function openCreateModal() {
    $('#modal-title').text('Create Template');
    $('#template-form')[0].reset();
    $('#template-id').val('');
    $('#levels-container').empty();
    levelCounter = 0;
    addLevel(); // Add first level
    tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
}

function editTemplate(id) {
    $.get('{{ route("approval-system.templates.show", ":id") }}'.replace(':id', id), function(data) {
        $('#modal-title').text('Edit Template');
        $('#template-id').val(data.id);
        $('#name').val(data.name);
        $('#type').val(data.type);
        $('#description').val(data.description);
        $('#is_active').prop('checked', data.is_active);
        
        $('#levels-container').empty();
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
}

function addLevel(levelData = null) {
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
    $('#levels-container').append(levelHtml);
}

function removeLevel(id) {
    $(`.level-item[data-level="${id}"]`).remove();
}

function getLevelsData() {
    const levels = [];
    let levelNum = 1;
    
    $('.level-item').each(function() {
        levels.push({
            level: levelNum++,
            name: $(this).find('.level-name').val(),
            approver_id: parseInt($(this).find('.level-approver').val()),
            can_reject: true,
            is_required: true
        });
    });
    
    return levels;
}

function deleteTemplate(id) {
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
            $.ajax({
                url: '{{ route("approval-system.templates.destroy", ":id") }}'.replace(':id', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
}
</script>
@endpush
