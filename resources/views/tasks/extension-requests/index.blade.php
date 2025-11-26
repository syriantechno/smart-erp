@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>{{ __('tasks.extension_requests') }} - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    @include('components.global-notifications')
    <div class="intro-y mt-8">
        <!-- Header -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ __('tasks.tasks') }}</p>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">{{ __('tasks.extension_requests') }}</h1>
            </div>
            <a href="{{ route('tasks.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
                {{ __('tasks.back_to_tasks') }}
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="box p-5 rounded-xl border border-slate-200/70 dark:border-darkmode-400">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <x-base.lucide icon="clock" class="w-6 h-6 text-yellow-600" />
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">{{ __('tasks.pending') }}</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
            <div class="box p-5 rounded-xl border border-slate-200/70 dark:border-darkmode-400">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <x-base.lucide icon="check-circle" class="w-6 h-6 text-green-600" />
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">{{ __('tasks.approved') }}</p>
                        <p class="text-2xl font-bold text-green-600">{{ $approvedCount }}</p>
                    </div>
                </div>
            </div>
            <div class="box p-5 rounded-xl border border-slate-200/70 dark:border-darkmode-400">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <x-base.lucide icon="x-circle" class="w-6 h-6 text-red-600" />
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">{{ __('tasks.rejected') }}</p>
                        <p class="text-2xl font-bold text-red-600">{{ $rejectedCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs & Table -->
        <div class="box p-5 rounded-xl border border-slate-200/70 dark:border-darkmode-400">
            <div class="flex flex-wrap gap-2 mb-6">
                <button type="button" class="status-filter-btn btn-royal btn-royal--sm active" data-status="all">
                    {{ __('tasks.all') }}
                </button>
                <button type="button" class="status-filter-btn btn-royal btn-royal--sm btn-royal--outline" data-status="pending">
                    <x-base.lucide icon="clock" class="w-4 h-4 mr-1" />
                    {{ __('tasks.pending') }}
                </button>
                <button type="button" class="status-filter-btn btn-royal btn-royal--sm btn-royal--outline" data-status="approved">
                    <x-base.lucide icon="check-circle" class="w-4 h-4 mr-1" />
                    {{ __('tasks.approved') }}
                </button>
                <button type="button" class="status-filter-btn btn-royal btn-royal--sm btn-royal--outline" data-status="rejected">
                    <x-base.lucide icon="x-circle" class="w-4 h-4 mr-1" />
                    {{ __('tasks.rejected') }}
                </button>
            </div>

            <!-- DataTable -->
            <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                <table id="extension-requests-table" data-tw-merge data-erp-table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                    <thead>
                        <tr>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.code') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.task') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.requester') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.current_due_date') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.requested_due_date') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('tasks.extension_days') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">{{ __('tasks.status') }}</th>
                            <th data-tw-merge class="font-medium px-4 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">{{ __('tasks.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <x-base.dialog id="view-details-modal" size="lg">
        <x-base.dialog.panel>
            <x-base.dialog.title class="bg-gradient-to-r from-primary to-primary/70 text-white">
                <h2 class="text-lg font-semibold">{{ __('tasks.request_details') }}</h2>
                <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                    <x-base.lucide icon="x" class="w-5 h-5" />
                </button>
            </x-base.dialog.title>
            <x-base.dialog.description class="p-6">
                <div id="view-details-content" class="space-y-4"></div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                    {{ __('tasks.close') }}
                </button>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>

    <!-- Approve Modal -->
    <x-base.dialog id="approve-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                <h2 class="text-lg font-semibold">{{ __('tasks.approve_extension') }}</h2>
                <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                    <x-base.lucide icon="x" class="w-5 h-5" />
                </button>
            </x-base.dialog.title>
            <form id="approve-form">
                <x-base.dialog.description class="p-6">
                    <input type="hidden" id="approve-request-id" name="request_id">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                            <x-base.lucide icon="check-circle" class="w-8 h-8 text-green-600" />
                        </div>
                        <p class="text-slate-600">{{ __('tasks.confirm_approve') }}</p>
                        <p class="text-sm text-slate-500 mt-2">{{ __('tasks.due_date_will_update') }}</p>
                    </div>
                    <div>
                        <x-base.form-label for="approve-notes">{{ __('tasks.notes') }} ({{ __('tasks.optional') }})</x-base.form-label>
                        <x-base.form-textarea id="approve-notes" name="review_notes" rows="3" placeholder="{{ __('tasks.add_notes_placeholder') }}" class="w-full"></x-base.form-textarea>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                    <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                        {{ __('tasks.cancel') }}
                    </button>
                    <button type="submit" class="btn-royal btn-royal--gold">
                        <x-base.lucide icon="check" class="w-4 h-4 mr-2" />
                        {{ __('tasks.approve') }}
                    </button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>

    <!-- Reject Modal -->
    <x-base.dialog id="reject-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title class="bg-gradient-to-r from-red-600 to-red-500 text-white">
                <h2 class="text-lg font-semibold">{{ __('tasks.reject_extension') }}</h2>
                <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                    <x-base.lucide icon="x" class="w-5 h-5" />
                </button>
            </x-base.dialog.title>
            <form id="reject-form">
                <x-base.dialog.description class="p-6">
                    <input type="hidden" id="reject-request-id" name="request_id">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                            <x-base.lucide icon="x-circle" class="w-8 h-8 text-red-600" />
                        </div>
                        <p class="text-slate-600">{{ __('tasks.confirm_reject') }}</p>
                    </div>
                    <div>
                        <x-base.form-label for="reject-notes">{{ __('tasks.rejection_reason') }} <span class="text-red-500">*</span></x-base.form-label>
                        <x-base.form-textarea id="reject-notes" name="review_notes" rows="3" placeholder="{{ __('tasks.enter_rejection_reason') }}" class="w-full" required></x-base.form-textarea>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                    <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                        {{ __('tasks.cancel') }}
                    </button>
                    <button type="submit" class="btn-royal" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white;">
                        <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                        {{ __('tasks.reject') }}
                    </button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
@endsection

@include('components.datatable.scripts')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let currentStatus = 'all';

    // Initialize DataTable
    const table = window.erpCrud.initDataTable({
        tableSelector: '#extension-requests-table',
        ajaxUrl: '{{ route("tasks.extension-requests.datatable") }}',
        ajaxData: function(d) {
            d.status = currentStatus;
        },
        columns: [
            { data: 'code', name: 'code', className: 'px-4 py-3 border-b dark:border-darkmode-300 font-medium' },
            { data: 'task_info', name: 'task_info', orderable: false, className: 'px-4 py-3 border-b dark:border-darkmode-300' },
            { data: 'requester_name', name: 'requester_name', orderable: false, className: 'px-4 py-3 border-b dark:border-darkmode-300' },
            { data: 'current_due_date_formatted', name: 'current_due_date', className: 'px-4 py-3 border-b dark:border-darkmode-300' },
            { data: 'requested_due_date_formatted', name: 'requested_due_date', className: 'px-4 py-3 border-b dark:border-darkmode-300' },
            { data: 'extension_days', name: 'extension_days', className: 'px-4 py-3 border-b dark:border-darkmode-300 text-center' },
            { data: 'status_badge', name: 'status', orderable: false, className: 'px-4 py-3 border-b dark:border-darkmode-300' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'px-4 py-3 border-b dark:border-darkmode-300 text-center' }
        ],
        order: [[0, 'desc']],
        pageLength: 10
    });

    // Status filter buttons
    document.querySelectorAll('.status-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.status-filter-btn').forEach(b => {
                b.classList.remove('active');
                b.classList.add('btn-royal--outline');
            });
            this.classList.add('active');
            this.classList.remove('btn-royal--outline');
            currentStatus = this.dataset.status;
            table.ajax.reload();
        });
    });

    // View details button handler
    document.addEventListener('click', function(e) {
        const viewBtn = e.target.closest('.view-btn');
        if (viewBtn) {
            e.preventDefault();
            const id = viewBtn.getAttribute('data-id');
            
            fetch(`{{ url('tasks/extension-requests') }}/${id}`, {
                headers: { 
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const req = data.data.extension_request;
                    document.getElementById('view-details-content').innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.task') }}</p>
                                <p class="font-semibold">${req.task.code} - ${req.task.title}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.requester') }}</p>
                                <p class="font-semibold">${req.requester}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.request_date') }}</p>
                                <p class="font-semibold">${req.created_at}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.current_due_date') }}</p>
                                <p class="font-semibold">${req.current_due_date}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.requested_due_date') }}</p>
                                <p class="font-semibold">${req.requested_due_date}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.extension_days') }}</p>
                                <p class="font-semibold">${req.extension_days} {{ __('tasks.days') }}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.status') }}</p>
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ${req.status_badge_class}">${req.status_label}</span>
                            </div>
                            <div class="col-span-2 p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.reason') }}</p>
                                <p class="font-medium">${req.reason}</p>
                            </div>
                            ${req.review_notes ? `
                            <div class="col-span-2 p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.review_notes') }}</p>
                                <p class="font-medium">${req.review_notes}</p>
                            </div>
                            ` : ''}
                            ${req.reviewer ? `
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.reviewer') }}</p>
                                <p class="font-semibold">${req.reviewer}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-lg">
                                <p class="text-xs text-slate-500 mb-1">{{ __('tasks.reviewed_at') }}</p>
                                <p class="font-semibold">${req.reviewed_at || '-'}</p>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('view-details-modal'));
                    modal.show();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showError && showError('Failed to load details');
            });
        }
    });

    // Approve button handler
    document.addEventListener('click', function(e) {
        const approveBtn = e.target.closest('.approve-btn');
        if (approveBtn) {
            e.preventDefault();
            const id = approveBtn.getAttribute('data-id');
            document.getElementById('approve-request-id').value = id;
            document.getElementById('approve-notes').value = '';
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('approve-modal'));
            modal.show();
        }
    });

    // Approve form submit
    document.getElementById('approve-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('approve-request-id').value;
        const notes = document.getElementById('approve-notes').value;

        fetch(`{{ url('tasks/extension-requests') }}/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ review_notes: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getOrCreateInstance(document.getElementById('approve-modal')).hide();
                table.ajax.reload();
                // Reload page to update stats
                setTimeout(() => location.reload(), 1000);
            } else {
                window.showError && showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to approve request');
        });
    });

    // Reject button handler
    document.addEventListener('click', function(e) {
        const rejectBtn = e.target.closest('.reject-btn');
        if (rejectBtn) {
            e.preventDefault();
            const id = rejectBtn.getAttribute('data-id');
            document.getElementById('reject-request-id').value = id;
            document.getElementById('reject-notes').value = '';
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('reject-modal'));
            modal.show();
        }
    });

    // Reject form submit
    document.getElementById('reject-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('reject-request-id').value;
        const notes = document.getElementById('reject-notes').value;

        if (!notes || notes.length < 5) {
            window.showWarning && showWarning('{{ __("tasks.rejection_reason_required") }}');
            return;
        }

        fetch(`{{ url('tasks/extension-requests') }}/${id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ review_notes: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getOrCreateInstance(document.getElementById('reject-modal')).hide();
                table.ajax.reload();
                // Reload page to update stats
                setTimeout(() => location.reload(), 1000);
            } else {
                window.showError && showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to reject request');
        });
    });
});
</script>
@endpush
