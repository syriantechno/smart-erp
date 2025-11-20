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
            </div>
        </div>
    </div>
@endsection
