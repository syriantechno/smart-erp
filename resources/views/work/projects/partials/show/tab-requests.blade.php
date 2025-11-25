{{-- Material Requests Tab --}}
@php
    // Get purchase requests - will work when project_id is added to table
    try {
        $materialRequests = \App\Models\Warehouse\PurchaseRequest::latest()->take(10)->get();
    } catch (\Exception $e) {
        $materialRequests = collect();
    }
    $pendingCount = $materialRequests->where('status', 'pending')->count();
    $approvedCount = $materialRequests->where('status', 'approved')->count();
    $deliveredCount = $materialRequests->where('status', 'delivered')->count();
    $rejectedCount = $materialRequests->where('status', 'rejected')->count();
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-[#303030]">Material Requests</h2>
            <p class="text-sm text-slate-500 mt-1">Manage purchase requests for project materials</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('warehouse.material-requests.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-slate-600 border border-slate-300 hover:bg-white/80 transition-all">
                <x-base.lucide icon="external-link" class="w-4 h-4 mr-2" /> View All
            </a>
            <a href="{{ route('warehouse.material-requests.index') }}" class="h-10 rounded-full px-5 flex items-center justify-center text-xs font-semibold text-white bg-[#303030] hover:bg-[#404040] transition-all">
                <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> New Request
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-5 gap-4">
        <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="clipboard-list" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $materialRequests->count() }}</div>
                    <div class="text-xs text-slate-300 mt-1">Total Requests</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg" style="background: linear-gradient(135deg, #f7e08a 0%, #d49a24 100%);">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/30 flex items-center justify-center">
                    <x-base.lucide icon="clock" class="w-6 h-6 text-[#3a2a1a]" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#3a2a1a]">{{ $pendingCount }}</div>
                    <div class="text-xs text-[#5a4a2a] mt-1">Pending</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="check" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $approvedCount }}</div>
                    <div class="text-xs text-blue-100 mt-1">Approved</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-green-500 to-green-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="truck" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $deliveredCount }}</div>
                    <div class="text-xs text-green-100 mt-1">Delivered</div>
                </div>
            </div>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-5 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <x-base.lucide icon="x-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">{{ $rejectedCount }}</div>
                    <div class="text-xs text-red-100 mt-1">Rejected</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Requests Table --}}
    <div class="rounded-2xl bg-white shadow-lg overflow-hidden border border-slate-200/60">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Request #</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Priority</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-slate-600 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($materialRequests as $request)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono font-medium text-[#303030]">{{ $request->code }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-700">{{ $request->title ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $request->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($request->status === 'delivered') bg-green-100 text-green-700
                            @elseif($request->status === 'approved') bg-blue-100 text-blue-700
                            @elseif($request->status === 'pending') bg-amber-100 text-amber-700
                            @elseif($request->status === 'rejected') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold
                            @if($request->priority === 'urgent' || $request->priority === 'high') bg-red-100 text-red-700
                            @elseif($request->priority === 'medium') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($request->priority ?? 'normal') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-medium text-slate-700">${{ number_format($request->total_amount ?? 0, 2) }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('warehouse.material-requests.show', $request) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-full hover:bg-slate-100 text-slate-400 hover:text-[#303030] transition-all">
                            <x-base.lucide icon="chevron-right" class="w-5 h-5" />
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                            <x-base.lucide icon="clipboard-list" class="w-8 h-8 text-slate-400" />
                        </div>
                        <p class="text-slate-600 font-medium">No material requests yet</p>
                        <p class="text-sm text-slate-400 mt-1">Create a request to order materials</p>
                        <a href="{{ route('warehouse.material-requests.index') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-[#303030] text-white text-sm font-semibold hover:bg-[#404040] transition-all">
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" /> Create Request
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
