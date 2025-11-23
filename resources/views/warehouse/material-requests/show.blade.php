@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Material Request {{ $purchaseRequest->code }} - {{ config('app.name') }}</title>
@endsection

@php
    $company = $purchaseRequest->company;
    $companyName = $company->name ?? 'Smart ERP';
    $companyAddress = $company->address ?? '—';
    $companyEmail = $company->email ?? '—';
    $companyPhone = $company->phone ?? '—';
    $companyLogo = $company?->logo ? \Illuminate\Support\Facades\Storage::url($company->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($companyName) . '&background=1D4ED8&color=fff';

    $effectiveStatus = $approvalRequest->status ?? $purchaseRequest->status;
    $showApprovedStamp = $effectiveStatus === 'approved';
    $showRejectedStamp = $effectiveStatus === 'rejected';
    $stampLabel = strtoupper($showApprovedStamp ? 'Approved' : 'Rejected');
    $stampColor = $showApprovedStamp ? '#10b981' : '#dc2626';
    $stampBgColor = $showApprovedStamp ? '#ecfdf5' : '#fee2e2';
@endphp

@push('styles')
    <style>
        .mr-approval-stamp {
            letter-spacing: 0.35em;
            text-indent: 0.35em;
            font-size: 15px;
            font-weight: 900;
            text-transform: uppercase;
            background-image: radial-gradient(circle at center, transparent 60%, rgba(0, 0, 0, 0.08));
        }

        @media print {
            .mr-approval-stamp {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
@endpush

@section('subcontent')
    <div class="intro-y mt-8 space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Material Request</p>
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">
                    {{ $purchaseRequest->code }} — {{ $purchaseRequest->title }}
                </h1>
            </div>
            <a href="{{ route('warehouse.material-requests.index') }}" class="btn btn-outline-secondary">
                Back to list
            </a>
        </div>

        <x-base.preview-component class="box">
            <div class="space-y-6 p-5">
                <div class="flex flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50/60 p-4 dark:border-darkmode-400 dark:bg-darkmode-600/30">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="h-14 w-14 overflow-hidden rounded-2xl border border-white/60 bg-white shadow-sm flex items-center justify-center">
                            <img src="{{ $companyLogo }}" alt="{{ $companyName }} Logo" class="h-full w-full object-cover">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Company</p>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">
                                {{ $companyName }}
                            </h3>
                            <p class="text-sm text-slate-500">
                                {{ $companyAddress }}
                            </p>
                        </div>
                        <div class="text-sm text-slate-500 space-y-1">
                            <p class="flex items-center gap-1">
                                <x-base.lucide icon="Mail" class="h-4 w-4" />
                                <span>{{ $companyEmail }}</span>
                            </p>
                            <p class="flex items-center gap-1">
                                <x-base.lucide icon="Phone" class="h-4 w-4" />
                                <span>{{ $companyPhone }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-8 space-y-6">
                        @if ($approvalRequest)
                            <div class="box p-6">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Approval Workflow</h2>
                                <div class="flex flex-wrap items-center gap-4">
                                    @foreach (($approvalRequest->approval_levels ?? []) as $level)
                                        @php
                                            $levelNumber = $level['level'] ?? $loop->iteration;
                                            $approverName = $approverNames->get($level['approver_id'] ?? null)?->name ?? 'Approver';

                                            $state = 'pending';
                                            if ($approvalRequest->status === 'approved' || ($approvalRequest->current_level ?? 1) > $levelNumber) {
                                                $state = 'approved';
                                            } elseif ($approvalRequest->status === 'rejected' && ($approvalRequest->current_level ?? 1) === $levelNumber) {
                                                $state = 'rejected';
                                            } elseif ($approvalRequest->status === 'pending' && ($approvalRequest->current_level ?? 1) === $levelNumber) {
                                                $state = 'in_progress';
                                            }

                                            $stateMeta = [
                                                'approved' => [
                                                    'wrapper' => 'border-emerald-500 bg-emerald-50 text-emerald-600',
                                                    'icon' => 'CheckCircle',
                                                    'connector' => 'bg-emerald-500'
                                                ],
                                                'rejected' => [
                                                    'wrapper' => 'border-rose-500 bg-rose-50 text-rose-600',
                                                    'icon' => 'XCircle',
                                                    'connector' => 'bg-rose-500'
                                                ],
                                                'in_progress' => [
                                                    'wrapper' => 'border-sky-500 bg-sky-50 text-sky-600',
                                                    'icon' => 'RefreshCw',
                                                    'connector' => 'bg-sky-500'
                                                ],
                                                'pending' => [
                                                    'wrapper' => 'border-amber-400 bg-amber-50 text-amber-600',
                                                    'icon' => 'Clock',
                                                    'connector' => 'bg-amber-300'
                                                ],
                                            ];

                                            $styles = $stateMeta[$state];
                                            $iconClasses = 'w-5 h-5';
                                            if ($state === 'in_progress') {
                                                $iconClasses .= ' animate-spin';
                                            }
                                        @endphp
                                        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 {{ $styles['wrapper'] }}">
                                                    <x-base.lucide icon="{{ $styles['icon'] }}" class="{{ $iconClasses }}" />
                                                </div>
                                                <p class="mt-2 text-sm font-medium text-slate-700">{{ $level['name'] ?? "Level {$levelNumber}" }}</p>
                                                <p class="text-xs text-slate-500">{{ $approverName }}</p>
                                            </div>
                                            @unless($loop->last)
                                                <div class="flex-1 h-0.5 mx-4 {{ $styles['connector'] }}"></div>
                                            @endunless
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <div>
                                            <p class="text-xs text-slate-500">Current Status</p>
                                            <p class="font-semibold capitalize">{{ $approvalRequest->status }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Current Approver</p>
                                            <p class="font-semibold">{{ $approvalRequest->currentApprover?->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    @if ($approvalRequest->status === 'rejected' && $approvalRequest->rejection_reason)
                                        <div class="rounded-lg border border-danger bg-danger/10 p-4 text-sm text-danger">
                                            <p class="font-semibold mb-1">Rejected</p>
                                            <p>{{ $approvalRequest->rejection_reason }}</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($approvalRequest->status === 'pending' && $approvalRequest->current_approver_id === auth()->id())
                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <x-base.button variant="danger" onclick="rejectMaterialRequest({{ $approvalRequest->id }})">
                                            <x-base.lucide icon="XCircle" class="w-4 h-4 mr-2" /> Reject
                                        </x-base.button>
                                        <x-base.button variant="success" onclick="approveMaterialRequest({{ $approvalRequest->id }})">
                                            <x-base.lucide icon="CheckCircle" class="w-4 h-4 mr-2" /> Approve
                                        </x-base.button>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">General Information</h2>
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                <div class="grid flex-1 grid-cols-1 gap-4 text-sm md:grid-cols-2">
                                    <div>
                                        <p class="text-xs text-slate-500">Warehouse</p>
                                        <p class="font-medium">{{ $purchaseRequest->warehouse?->name ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Request Date</p>
                                        <p class="font-medium">{{ optional($purchaseRequest->request_date)->format('Y-m-d') ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Priority</p>
                                        <p class="font-medium capitalize">{{ $purchaseRequest->priority ?? 'normal' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Requested By</p>
                                        <p class="font-medium">{{ $purchaseRequest->requestedBy?->name ?? '—' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Approved By</p>
                                        <p class="font-medium">{{ $purchaseRequest->approvedBy?->name ?? '—' }}</p>
                                    </div>
                                </div>

                                @if ($showApprovedStamp || $showRejectedStamp)
                                    <div class="flex justify-center lg:justify-end">
                                        <div
                                            class="mr-approval-stamp inline-flex h-36 w-36 items-center justify-center rounded-full border-[6px]"
                                            style="transform: rotate(-8deg); border-color: {{ $stampColor }}; color: {{ $stampColor }}; background-color: {{ $stampBgColor }};"
                                        >
                                            {{ $stampLabel }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Items</h2>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-xs uppercase tracking-wide text-slate-500">
                                            <th class="py-2">Material</th>
                                            <th class="py-2">Unit</th>
                                            <th class="py-2">Qty</th>
                                            <th class="py-2">Unit Price</th>
                                            <th class="py-2 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($purchaseRequest->items as $item)
                                            <tr>
                                                <td class="py-3">
                                                    <p class="font-medium">{{ $item->material->name ?? '—' }}</p>
                                                    <p class="text-xs text-slate-500">{{ $item->material->code ?? '' }}</p>
                                                </td>
                                                <td>{{ $item->material->unit->name ?? $item->material->unit->symbol ?? '—' }}</td>
                                                <td>{{ number_format($item->quantity, 2) }}</td>
                                                <td>{{ $currencySymbol }}{{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-right">{{ $currencySymbol }}{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4 space-y-6">
                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Summary</h2>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt>Status</dt>
                                    <dd class="font-semibold capitalize">{{ $purchaseRequest->status }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt>Total Amount</dt>
                                    <dd class="font-semibold">{{ $currencySymbol }}{{ number_format($purchaseRequest->total_amount, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-slate-500 mb-1">Notes</dt>
                                    <dd class="text-slate-600">{{ $purchaseRequest->description ?? 'No additional notes provided.' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="box p-6">
                            <h2 class="text-sm font-semibold text-slate-600 mb-4">Company</h2>
                            <p class="font-medium">{{ $purchaseRequest->company?->name ?? '—' }}</p>
                            <p class="text-xs text-slate-500">{{ $purchaseRequest->company?->address ?? '—' }}</p>
                        </div>

                        @if ($approvalRequest && $approvalRequest->logs->isNotEmpty())
                            <div class="box p-6">
                                <h2 class="text-sm font-semibold text-slate-600 mb-4">Approval Activity</h2>
                                <div class="space-y-4">
                                    @foreach ($approvalRequest->logs->sortByDesc('created_at') as $log)
                                        <div class="flex items-start gap-3">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold {{ $log->action_badge_class }}">
                                                {{ strtoupper(substr($log->action, 0, 1)) }}
                                            </span>
                                            <div class="text-sm">
                                                <p class="font-semibold capitalize">{{ $log->action_label }}</p>
                                                <p class="text-xs text-slate-500">{{ $log->user?->name ?? 'System' }} • {{ $log->formatted_date }}</p>
                                                @if ($log->comments)
                                                    <p class="mt-1 text-slate-600 text-sm">{{ $log->comments }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-base.preview-component>
    </div>

    @push('scripts')
        <script>
            function approveMaterialRequest(approvalRequestId) {
                Swal.fire({
                    title: 'Approve Material Request',
                    input: 'textarea',
                    inputLabel: 'Comments (optional)',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    confirmButtonColor: '#10b981'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.jQuery.post('{{ route("approval-system.approve", ':id') }}'.replace(':id', approvalRequestId), {
                            comments: result.value,
                            _token: '{{ csrf_token() }}'
                        })
                        .done(() => {
                            window.location.reload();
                        })
                        .fail((xhr) => {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Failed to approve request.', 'error');
                        });
                    }
                });
            }

            function rejectMaterialRequest(approvalRequestId) {
                Swal.fire({
                    title: 'Reject Material Request',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Reason is required';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    confirmButtonColor: '#ef4444'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.jQuery.post('{{ route("approval-system.reject", ':id') }}'.replace(':id', approvalRequestId), {
                            reason: result.value,
                            _token: '{{ csrf_token() }}'
                        })
                        .done(() => {
                            window.location.reload();
                        })
                        .fail((xhr) => {
                            Swal.fire('Error', xhr.responseJSON?.message || 'Failed to reject request.', 'error');
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
