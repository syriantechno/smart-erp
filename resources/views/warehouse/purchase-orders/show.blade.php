@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Purchase Order Details - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Purchase Order Details</h2>
        <div class="flex gap-2">
            <a href="{{ route('warehouse.purchase-orders.edit', $purchaseOrder->id) }}" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="edit" class="w-4 h-4 mr-2" />
                Edit
            </a>
            <a href="{{ route('warehouse.purchase-orders.index') }}" class="btn-royal btn-royal--outline btn-royal--sm">
                <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" />
                Back to List
            </a>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-6">
                        <!-- Purchase Order Info -->
                        <div class="col-span-12 lg:col-span-8">
                            <h3 class="text-lg font-semibold mb-4">Purchase Order Information</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Code</label>
                                    <p class="text-slate-900 font-medium">{{ $purchaseOrder->code }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($purchaseOrder->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($purchaseOrder->status === 'approved') bg-green-100 text-green-800
                                        @elseif($purchaseOrder->status === 'shipped') bg-blue-100 text-blue-800
                                        @elseif($purchaseOrder->status === 'delivered') bg-emerald-100 text-emerald-800
                                        @elseif($purchaseOrder->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-slate-100 text-slate-800
                                        @endif">
                                        {{ ucfirst($purchaseOrder->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Title</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->title }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Order Date</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->order_date->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Supplier</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->supplier->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Total Amount</label>
                                    <p class="text-slate-900 font-semibold text-lg">${{ number_format($purchaseOrder->total_amount, 2) }}</p>
                                </div>
                            </div>

                            @if($purchaseOrder->description)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-slate-600 mb-1">Description</label>
                                <p class="text-slate-900">{{ $purchaseOrder->description }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Sidebar Info -->
                        <div class="col-span-12 lg:col-span-4">
                            <h3 class="text-lg font-semibold mb-4">Additional Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Created By</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->createdBy->name ?? 'N/A' }}</p>
                                </div>
                                
                                @if($purchaseOrder->approvedBy)
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Approved By</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->approvedBy->name }}</p>
                                </div>
                                @endif
                                
                                @if($purchaseOrder->expected_delivery_date)
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Expected Delivery</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->expected_delivery_date->format('Y-m-d') }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Created At</label>
                                    <p class="text-slate-900">{{ $purchaseOrder->created_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection
