@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>CRM Contacts - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <style>
        .crm-metric-card {
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.2));
            border: 1px solid rgba(148, 163, 184, 0.35);
            padding: 1.25rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .crm-metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 35px rgba(15, 23, 42, 0.08);
        }

        .crm-filter-pill {
            border-radius: 9999px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            padding: 0.35rem 0.85rem;
        }
    </style>
@endpush

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold leading-tight">CRM Contacts</h2>
                <p class="text-slate-500">Centralize people, link them to companies, and keep the relationship history.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" data-tw-toggle="modal" data-tw-target="#crm-contact-filters">
                    <x-base.lucide icon="filter" class="w-4 h-4" /> Filters
                </button>
                <button type="button" class="btn-royal btn-royal--gold btn-royal--sm" data-tw-toggle="modal" data-tw-target="#crm-contact-create">
                    <x-base.lucide icon="user-plus" class="w-4 h-4" /> New Contact
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-5">
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Total Contacts</span>
                        <x-base.lucide icon="Users" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold">{{ number_format($stats['total_contacts']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Active</span>
                        <x-base.lucide icon="Activity" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-emerald-600">{{ number_format($stats['active_contacts']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Linked to Leads</span>
                        <x-base.lucide icon="Target" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-blue-600">{{ number_format($stats['with_leads']) }}</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="crm-metric-card">
                    <div class="flex items-center justify-between text-slate-500">
                        <span>Contacted in 30 days</span>
                        <x-base.lucide icon="Clock3" class="w-4 h-4" />
                    </div>
                    <div class="mt-4 text-3xl font-semibold text-indigo-600">{{ number_format($stats['recently_contacted']) }}</div>
                </div>
            </div>
        </div>

        <div class="intro-y box p-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end">
                <div class="flex flex-col gap-2 lg:flex-row lg:items-center">
                    <label class="text-sm font-medium">Company</label>
                    <x-base.form-select id="crm-contact-company" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="flex flex-col gap-2 lg:flex-row lg:items-center">
                    <label class="text-sm font-medium">Status</label>
                    <x-base.form-select id="crm-contact-status" class="crm-filter-pill">
                        <option value="all">All</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}">{{ Str::headline($status) }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="flex gap-3">
                    <button type="button" id="crm-contact-apply" class="btn-royal btn-royal--dark btn-royal--sm">
                        <x-base.lucide icon="search" class="w-4 h-4" /> Apply
                    </button>
                    <button type="button" id="crm-contact-reset" class="btn-royal btn-royal--outline btn-royal--sm">
                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4" /> Reset
                    </button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table id="crm-contacts-table" class="datatable-default w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Company</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Phone</th>
                            <th class="px-5 py-3">Position</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @include('crm.contacts.partials.create-modal')
@endsection

@include('components.datatable.scripts')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const companyFilter = document.getElementById('crm-contact-company');
            const statusFilter = document.getElementById('crm-contact-status');
            const applyBtn = document.getElementById('crm-contact-apply');
            const resetBtn = document.getElementById('crm-contact-reset');

            const table = window.erpCrud.initDataTable({
                tableSelector: '#crm-contacts-table',
                ajaxUrl: '{{ route("crm.contacts.datatable") }}',
                ajaxData: function (d) {
                    d.company_id = companyFilter ? companyFilter.value : 'all';
                    d.status = statusFilter ? statusFilter.value : 'all';
                },
                pageLength: 25,
                columns: [
                    { data: 'name', name: 'name', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700' },
                    { data: 'company', name: 'company.name', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'email', name: 'email', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'phone', name: 'phone', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'position', name: 'position', className: 'px-5 py-3 border-b dark:border-darkmode-300' },
                    { data: 'status', name: 'status', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center' },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                        render: function (data, type, row) {
                            return `
                                <div class="flex items-center justify-center gap-2">
                                    <button class="btn-royal btn-royal--action btn-royal--primary" data-action="edit" data-id="${data}" title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn-royal btn-royal--action btn-royal--danger" data-action="delete" data-id="${data}" data-name="${row.name || ''}" title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                drawCallback: function () {
                    if (typeof window.lucide !== 'undefined') {
                        window.lucide.createIcons();
                    }
                }
            });

            if (!table) {
                console.error('Failed to initialize DataTable');
                return;
            }

            // Apply filters
            if (applyBtn) {
                applyBtn.addEventListener('click', function () {
                    table.ajax.reload();
                });
            }

            // Reset filters
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    if (companyFilter) companyFilter.value = 'all';
                    if (statusFilter) statusFilter.value = 'all';
                    table.ajax.reload();
                });
            }

            // Handle actions
            document.querySelector('#crm-contacts-table').addEventListener('click', function (e) {
                const editBtn = e.target.closest('[data-action="edit"]');
                const deleteBtn = e.target.closest('[data-action="delete"]');

                if (editBtn) {
                    const id = editBtn.dataset.id;
                    window.location.href = '{{ url("crm/contacts") }}/' + id + '/edit';
                }

                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;
                    const name = deleteBtn.dataset.name || 'this contact';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete "${name}". This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ url("crm/contacts") }}/' + id, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', data.message || 'Contact deleted successfully.', 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Error!', data.message || 'Failed to delete contact.', 'error');
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'An error occurred while deleting.', 'error');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
