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
                <button type="button" class="btn-tonal btn-tonal--info" data-tw-toggle="modal" data-tw-target="#crm-contact-filters">
                    <x-base.lucide icon="Filter" class="w-4 h-4 mr-2" /> Filters
                </button>
                <button type="button" class="btn-tonal btn-tonal--success" data-tw-toggle="modal" data-tw-target="#crm-contact-create">
                    <x-base.lucide icon="UserPlus" class="w-4 h-4 mr-2" /> New Contact
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
                    <button type="button" id="crm-contact-apply" class="btn-tonal btn-tonal--info">
                        <x-base.lucide icon="Search" class="w-4 h-4 mr-2" /> Apply
                    </button>
                    <button type="button" id="crm-contact-reset" class="btn-tonal btn-tonal--warning">
                        <x-base.lucide icon="RotateCcw" class="w-4 h-4 mr-2" /> Reset
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = $('#crm-contacts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('crm.contacts.datatable') }}',
                    data: function (params) {
                        params.company_id = document.getElementById('crm-contact-company').value;
                        params.status = document.getElementById('crm-contact-status').value;
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'company', name: 'company.name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'position', name: 'position' },
                    { data: 'status', name: 'status' },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: (id) => `
                            <div class="flex items-center justify-center gap-2">
                                <button class="text-primary" data-action="edit" data-id="${id}">
                                    <x-base.lucide icon="Edit" class="w-4 h-4" />
                                </button>
                                <button class="text-danger" data-action="delete" data-id="${id}">
                                    <x-base.lucide icon="Trash" class="w-4 h-4" />
                                </button>
                            </div>
                        `
                    }
                ]
            });

            document.getElementById('crm-contact-apply').addEventListener('click', () => table.ajax.reload());
            document.getElementById('crm-contact-reset').addEventListener('click', () => {
                document.getElementById('crm-contact-company').value = 'all';
                document.getElementById('crm-contact-status').value = 'all';
                table.ajax.reload();
            });
        });
    </script>
@endpush
