@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Positions Management - {{ config('app.name') }}</title>
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
        <h2 class="mr-auto text-lg font-medium">Positions Management</h2>
        <x-base.button
            variant="primary"
            class="w-40 sm:w-auto sm:ml-4"
            data-tw-toggle="modal"
            data-tw-target="#create-position-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Position
        </x-base.button>
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
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 xl:mt-0">
                                <x-base.button id="positions-filter-go" type="button" variant="primary" class="w-full sm:w-16">
                                    Go
                                </x-base.button>
                                <x-base.button id="positions-filter-reset" type="button" variant="secondary" class="mt-2 w-full sm:ml-1 sm:mt-0 sm:w-16">
                                    Reset
                                </x-base.button>
                            </div>
                        </form>

                        <div class="mt-5 flex sm:mt-0">
                            <x-base.button id="positions-export" variant="outline-secondary" class="mr-2 w-1/2 sm:w-auto">
                                <x-base.lucide icon="Download" class="mr-2 h-4 w-4" /> Export
                            </x-base.button>
                            <x-base.button id="positions-refresh" variant="outline-secondary" class="w-1/2 sm:w-auto">
                                <x-base.lucide icon="RefreshCcw" class="mr-2 h-4 w-4" /> Refresh
                            </x-base.button>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table id="positions-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Code</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Title</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Salary Range</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Status</th>
                                    <th data-tw-merge class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
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
        <form id="edit-position-form" action="" method="POST">
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
                        @foreach(\App\Models\Department::active()->get() as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-salary_range_min">Minimum Salary</x-base.form-label>
                    <x-base.form-input id="edit-salary_range_min" name="salary_range_min" type="number" step="0.01" min="0" class="w-full" />
                </div>

                <div class="col-span-12 md:col-span-6">
                    <x-base.form-label for="edit-salary_range_max">Maximum Salary</x-base.form-label>
                    <x-base.form-input id="edit-salary_range_max" name="salary_range_max" type="number" step="0.01" min="0" class="w-full" />
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-description">Description</x-base.form-label>
                    <x-base.form-textarea id="edit-description" name="description" rows="3" placeholder="Enter position description" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-label for="edit-requirements">Requirements</x-base.form-label>
                    <x-base.form-textarea id="edit-requirements" name="requirements" rows="3" placeholder="Enter requirements" class="w-full"></x-base.form-textarea>
                </div>

                <div class="col-span-12">
                    <x-base.form-check
                        id="edit-position_is_active"
                        name="is_active"
                        label="Active"
                        type="checkbox"
                    />
                </div>
            </div>
        </form>

        @slot('footer')
            <div class="flex justify-end gap-2 w-full">
                <x-base.button
                    class="w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="submit"
                    form="edit-position-form"
                    variant="primary"
                >
                    <x-base.lucide icon="Save" class="w-4 h-4 mr-2" />
                    Update
                </x-base.button>
            </div>
        @endslot
    </x-modal.form>
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterField = document.getElementById('positions-filter-field');
        const filterType = document.getElementById('positions-filter-type');
        const filterValue = document.getElementById('positions-filter-value');
        const lengthSelect = document.getElementById('positions-filter-length');
        const filterGoBtn = document.getElementById('positions-filter-go');
        const filterResetBtn = document.getElementById('positions-filter-reset');
        const exportBtn = document.getElementById('positions-export');
        const refreshBtn = document.getElementById('positions-refresh');
        const codeInput = document.getElementById('position-code');

        const initialLength = lengthSelect ? parseInt(lengthSelect.value, 10) || 10 : 10;

        const table = window.initDataTable('#positions-table', {
            ajax: {
                url: @json(route('hr.positions.datatable')),
                type: 'GET',
                data: function (d) {
                    if (filterField) {
                        d.filter_field = filterField.value || 'all';
                    }
                    if (filterType) {
                        d.filter_type = filterType.value || 'contains';
                    }
                    if (filterValue) {
                        d.filter_value = filterValue.value || '';
                    }
                    d.page_length = lengthSelect ? parseInt(lengthSelect.value, 10) || initialLength : initialLength;
                },
                error: function (xhr, textStatus, error) {
                    console.error('DataTables AJAX error:', textStatus, error, xhr.responseText);
                }
            },
            pageLength: initialLength,
            lengthChange: false,
            searching: false,
            dom:
                "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium' },
                { data: 'code', name: 'code', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'title', name: 'title', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap' },
                {
                    data: 'department',
                    name: 'department.name',
                    render: function (data) {
                        return data && data.name ? data.name : '-';
                    },
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap'
                },
                { data: 'salary_range', name: 'salary_range', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                {
                    data: 'is_active',
                    name: 'is_active',
                    className: 'text-center',
                    render: function (value) {
                        const status = Boolean(value);
                        const badgeClass = status
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700';
                        const label = status ? 'Active' : 'Inactive';
                        return `<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function () {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
                }

                // Re-initialize modals after DataTable redraw
                if (typeof window.Tw !== 'undefined' && window.Tw.createModals) {
                    window.Tw.createModals();
                }
            }
        });

        if (!table) {
            return;
        }

        if (lengthSelect) {
            lengthSelect.addEventListener('change', function () {
                const newLength = parseInt(this.value, 10) || initialLength;
                table.page.len(newLength).draw();
            });
        }

        const reloadTable = function () {
            table.ajax.reload(null, false);
        };

        const refreshPositionCode = function () {
            if (!codeInput) {
                return;
            }

            fetch(@json(route('hr.positions.preview-code')))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to preview position code');
                    }

                    return response.json();
                })
                .then(data => {
                    codeInput.value = data.code || '';
                })
                .catch(error => {
                    console.error(error);
                    codeInput.value = '';
                });
        };

        refreshPositionCode();

        const closeModal = function (modalEl) {
            if (!modalEl) {
                return;
            }

            const dismissTrigger = modalEl.querySelector('[data-tw-dismiss="modal"]');
            if (dismissTrigger) {
                dismissTrigger.click();
            }
        };

        const createForm = document.getElementById('create-position-form');
        const createModal = document.getElementById('create-position-modal');

        if (createForm) {
            createForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(createForm);

                fetch(createForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                    .then(async (response) => {
                        if (response.ok) {
                            return response.json();
                        }

                        if (response.status === 422) {
                            const data = await response.json();
                            const errors = data.errors || {};
                            const firstError = Object.values(errors)[0];
                            if (firstError) {
                                showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                            } else {
                                showToast(data.message || 'Validation error', 'error');
                            }
                            throw new Error('validation');
                        }

                        throw new Error('request');
                    })
                    .then((data) => {
                        if (data.success) {
                            showToast(data.message || 'Position created successfully', 'success');
                            createForm.reset();
                            refreshPositionCode();
                            closeModal(createModal);
                            reloadTable();
                        } else {
                            showToast(data.message || 'Failed to create position', 'error');
                        }
                    })
                    .catch((error) => {
                        if (error.message === 'validation') {
                            return;
                        }
                        console.error('Position create error:', error);
                        showToast('An error occurred while saving the position', 'error');
                    });
            });
        }

        if (filterGoBtn) {
            filterGoBtn.addEventListener('click', reloadTable);
        }

        if (filterValue) {
            filterValue.addEventListener('keyup', function (event) {
                if (event.key === 'Enter') {
                    reloadTable();
                }
            });
        }

        if (filterResetBtn) {
            filterResetBtn.addEventListener('click', function () {
                if (filterField) {
                    filterField.value = 'all';
                }
                if (filterType) {
                    filterType.value = 'contains';
                }
                if (filterValue) {
                    filterValue.value = '';
                }
                if (lengthSelect) {
                    lengthSelect.value = String(initialLength);
                    table.page.len(initialLength).draw();
                }
                reloadTable();
            });
        }

        if (refreshBtn) {
            refreshBtn.addEventListener('click', reloadTable);
        }

        if (codeInput) {
            document.addEventListener('show.tw.modal', function (event) {
                if (event.target && event.target.id === 'create-position-modal') {
                    refreshPositionCode();
                }
            });
        }

        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                try {
                    const rows = table.rows({ search: 'applied' }).data().toArray();
                    if (!rows.length) {
                        showToast('No data available for export.', 'error');
                        return;
                    }

                    const headers = ['#', 'Code', 'Title', 'Department', 'Salary Range', 'Status'];
                    const csvRows = [headers.join(',')];

                    rows.forEach(function (row) {
                        const csvRow = [
                            row.DT_RowIndex,
                            '"' + (row.code || '').replace(/"/g, '""') + '"',
                            '"' + (row.title || '').replace(/"/g, '""') + '"',
                            '"' + ((row.department && row.department.name) ? row.department.name : '').replace(/"/g, '""') + '"',
                            '"' + (row.salary_range || '').replace(/"/g, '""') + '"',
                            row.is_active ? 'Active' : 'Inactive'
                        ];
                        csvRows.push(csvRow.join(','));
                    });

                    const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'positions.csv';
                    link.click();
                    URL.revokeObjectURL(url);
                    showToast('Export completed successfully.', 'success');
                } catch (error) {
                    console.error('Export error:', error);
                    showToast('Failed to export data.', 'error');
                }
            });
        }

        document.addEventListener('hidden.tw.modal', function () {
            if (document.activeElement && typeof document.activeElement.blur === 'function') {
                document.activeElement.blur();
            }
            table.ajax.reload(null, false);
        });

        window.openEditModal = function(id, title, code, departmentId, minSalary, maxSalary, description, requirements, isActive) {
            console.log('Opening edit modal for position:', id, title);

            // Populate form fields
            document.getElementById('edit-position-code').value = code || '';
            document.getElementById('edit-title').value = title || '';
            document.getElementById('edit-department_id').value = departmentId || '';
            document.getElementById('edit-salary_range_min').value = minSalary || '';
            document.getElementById('edit-salary_range_max').value = maxSalary || '';
            document.getElementById('edit-description').value = description || '';
            document.getElementById('edit-requirements').value = requirements || '';
            document.getElementById('edit-position_is_active').checked = isActive;

            // Update form action
            const form = document.getElementById('edit-position-form');
            form.action = `/hr/positions/${id}`;

            // Show modal using the hidden trigger button
            const modalTrigger = document.getElementById('edit-modal-trigger');
            if (modalTrigger) {
                modalTrigger.click();
            } else {
                console.error('Edit modal trigger not found');
            }
        };

        const editForm = document.getElementById('edit-position-form');
        const editModal = document.getElementById('edit-position-modal');

        if (editForm) {
            editForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(editForm);

                fetch(editForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData,
                })
                    .then(async (response) => {
                        if (response.ok) {
                            return response.json();
                        }

                        if (response.status === 422) {
                            const data = await response.json();
                            const errors = data.errors || {};
                            const firstError = Object.values(errors)[0];
                            if (firstError) {
                                showToast(Array.isArray(firstError) ? firstError[0] : firstError, 'error');
                            } else {
                                showToast(data.message || 'Validation error', 'error');
                            }
                            throw new Error('validation');
                        }

                        throw new Error('request');
                    })
                    .then((data) => {
                        if (data.success) {
                            showToast(data.message || 'Position updated successfully', 'success');
                            closeModal(editModal);
                            reloadTable();
                        } else {
                            showToast(data.message || 'Failed to update position', 'error');
                        }
                    })
                    .catch((error) => {
                        if (error.message === 'validation') {
                            return;
                        }
                        console.error('Position update error:', error);
                        showToast('An error occurred while updating the position', 'error');
                    });
            });
        }

        window.deletePosition = function (id, title) {
            Swal.fire({
                title: 'Delete Position?',
                html: `Are you sure you want to delete <strong>"${title}"</strong>?<br>This action cannot be undone.`,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl shadow-2xl',
                    confirmButton: 'px-6 py-2 rounded-lg font-semibold',
                    cancelButton: 'px-6 py-2 rounded-lg font-semibold'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('hr.positions.destroy', '') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                reloadTable();
                                showToast(data.message || 'Position deleted successfully', 'success');
                            } else {
                                showToast(data.message || 'Failed to delete position', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('An error occurred while deleting the position', 'error');
                        });
                }
            });
        };
    });
    </script>
