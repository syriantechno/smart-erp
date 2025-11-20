@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Material Request {{ $purchaseRequest->code }} - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <div class="flex items-center justify-between mb-6">
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

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 lg:col-span-8 space-y-6">
                @if ($approvalRequest)
                    <div class="box p-6">
                        <h2 class="text-sm font-semibold text-slate-600 mb-4">Approval Workflow</h2>
                        <div class="flex flex-wrap items-center gap-4">
                            @foreach (($approvalRequest->approval_levels ?? []) as $level)
                                @php
                                    $levelNumber = $level['level'] ?? $loop->iteration;
                                    $isCompleted = $approvalRequest->current_level > $levelNumber || $approvalRequest->status === 'approved';
                                    $isCurrent = $approvalRequest->current_level === $levelNumber && $approvalRequest->status === 'pending';
                                    $isRejected = $approvalRequest->status === 'rejected' && $approvalRequest->current_level === $levelNumber;
                                    $approverName = $approverNames->get($level['approver_id'] ?? null)?->name ?? 'Approver';
                                @endphp
                                <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
                                    <div class="flex flex-col items-center text-center">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2
                                            {{ $isCompleted ? 'border-success bg-success/10 text-success' : '' }}
                                            {{ $isCurrent ? 'border-warning bg-warning/10 text-warning' : '' }}
                                            {{ $isRejected ? 'border-danger bg-danger/10 text-danger' : '' }}
                                            {{ (!$isCompleted && !$isCurrent && !$isRejected) ? 'border-slate-200 bg-slate-50 text-slate-400' : '' }}">
                                            @if ($isCompleted)
                                                <x-base.lucide icon="CheckCircle" class="w-5 h-5" />
                                            @elseif ($isCurrent)
                                                <x-base.lucide icon="Clock" class="w-5 h-5" />
                                            @elseif ($isRejected)
                                                <x-base.lucide icon="XCircle" class="w-5 h-5" />
                                            @else
                                                <x-base.lucide icon="Circle" class="w-5 h-5" />
                                            @endif
                                        </div>
                                        <p class="mt-2 text-sm font-medium text-slate-700">{{ $level['name'] ?? "Level {$levelNumber}" }}</p>
                                        <p class="text-xs text-slate-500">{{ $approverName }}</p>
                                    </div>
                                    @unless($loop->last)
                                        <div class="flex-1 h-0.5 mx-4 {{ $isCompleted ? 'bg-success' : 'bg-slate-200' }}"></div>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-slate-500">Company</p>
                            <p class="font-medium">{{ $purchaseRequest->company?->name ?? '—' }}</p>
                        </div>
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
