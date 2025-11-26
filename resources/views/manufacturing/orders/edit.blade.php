@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Edit {{ $order->order_number }} - Production Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('subcontent')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Edit Production Order</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $order->order_number }}</p>
        </div>
        <a href="{{ route('manufacturing.orders.show', $order) }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
            <x-base.lucide icon="arrow-left" class="w-4 h-4 mr-2" /> Back to Order
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('manufacturing.orders.update', $order) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="rounded-2xl bg-white shadow-lg border border-slate-200/60 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-[#303030]">Order Details</h3>
            </div>
            <div class="p-6 space-y-6">
                {{-- Product Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="product_name" value="{{ old('product_name', $order->product_name) }}" required
                        class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all @error('product_name') border-red-500 @enderror">
                    @error('product_name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">{{ old('description', $order->description) }}</textarea>
                </div>

                {{-- Quantity & Unit Cost --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', $order->quantity) }}" required min="1"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Unit Cost ($) <span class="text-red-500">*</span></label>
                        <input type="number" name="unit_cost" value="{{ old('unit_cost', $order->unit_cost) }}" required min="0" step="0.01"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all @error('unit_cost') border-red-500 @enderror">
                        @error('unit_cost')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Dates --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date', $order->start_date->format('Y-m-d')) }}" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $order->end_date?->format('Y-m-d')) }}"
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                    </div>
                </div>

                {{-- Status & Priority --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            @foreach(['draft', 'confirmed', 'in_progress', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ old('status', $order->status) === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Priority <span class="text-red-500">*</span></label>
                        <select name="priority" required
                            class="w-full h-11 px-4 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">
                            @foreach(['low', 'medium', 'high', 'urgent'] as $priority)
                            <option value="{{ $priority }}" {{ old('priority', $order->priority) === $priority ? 'selected' : '' }}>
                                {{ ucfirst($priority) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all">{{ old('notes', $order->notes) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between">
            <form id="delete-order-form" action="{{ route('manufacturing.orders.destroy', $order) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" onclick="deleteOrder()" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-red-600 border border-red-300 hover:bg-red-50 transition-all">
                    <x-base.lucide icon="trash-2" class="w-4 h-4 mr-2" /> Delete Order
                </button>
            </form>
            <div class="flex items-center gap-3">
                <a href="{{ route('manufacturing.orders.show', $order) }}" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                    Cancel
                </a>
                <button type="submit" class="h-11 rounded-full px-6 flex items-center justify-center text-sm font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                    <x-base.lucide icon="save" class="w-4 h-4 mr-2" /> Save
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function deleteOrder() {
    if (typeof window.confirmDelete === 'function') {
        window.confirmDelete('{{ $order->product_name }}', () => {
            document.getElementById('delete-order-form').submit();
        });
    } else {
        document.getElementById('delete-order-form').submit();
    }
}
</script>
@endpush
@endsection
