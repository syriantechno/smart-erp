@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Manufacturing - ERP System</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="grid grid-cols-12 gap-6">
        <!-- Page Header -->
        <div class="col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-slate-800 dark:text-slate-200">
                                Manufacturing Management
                            </h2>
                            <p class="text-slate-600 dark:text-slate-400 mt-1">
                                Manage production orders, stages, machines, and quality control
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('manufacturing.orders.create') }}" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                New Production Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="col-span-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Orders -->
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Orders</div>
                            <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $stats['total_orders'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- In Progress -->
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">In Progress</div>
                            <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $stats['in_progress'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">Completed</div>
                            <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $stats['completed'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Machines Active -->
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm text-slate-600 dark:text-slate-400">Active Machines</div>
                            <div class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ $stats['active_machines'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <h3 class="text-base font-medium text-slate-800 dark:text-slate-200 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('manufacturing.orders.index') }}" class="flex items-center p-4 bg-blue-50 dark:bg-darkmode-600 rounded-lg hover:bg-blue-100 dark:hover:bg-darkmode-500 transition-colors">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800 dark:text-slate-200">Production Orders</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Manage orders</div>
                            </div>
                        </a>

                        <a href="{{ route('manufacturing.stages.index') }}" class="flex items-center p-4 bg-green-50 dark:bg-darkmode-600 rounded-lg hover:bg-green-100 dark:hover:bg-darkmode-500 transition-colors">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800 dark:text-slate-200">Production Stages</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Configure stages</div>
                            </div>
                        </a>

                        <a href="{{ route('manufacturing.machines.index') }}" class="flex items-center p-4 bg-purple-50 dark:bg-darkmode-600 rounded-lg hover:bg-purple-100 dark:hover:bg-darkmode-500 transition-colors">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800 dark:text-slate-200">Machines</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Manage equipment</div>
                            </div>
                        </a>

                        <a href="{{ route('manufacturing.quality.index') }}" class="flex items-center p-4 bg-orange-50 dark:bg-darkmode-600 rounded-lg hover:bg-orange-100 dark:hover:bg-darkmode-500 transition-colors">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-slate-800 dark:text-slate-200">Quality Control</div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">Quality checks</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Production Orders -->
        <div class="col-span-12">
            <div class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-medium text-slate-800 dark:text-slate-200">Recent Production Orders</h3>
                        <a href="{{ route('manufacturing.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Order #</th>
                                    <th class="whitespace-nowrap">Product</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Start Date</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr class="intro-x">
                                    <td class="font-medium">{{ $order->order_number }}</td>
                                    <td>{{ $order->product_name }}</td>
                                    <td>
                                        <div class="flex items-center">
                                            @if($order->status === 'completed')
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                <span class="text-green-600">Completed</span>
                                            @elseif($order->status === 'in_progress')
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                                <span class="text-yellow-600">In Progress</span>
                                            @elseif($order->status === 'confirmed')
                                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                                <span class="text-blue-600">Confirmed</span>
                                            @else
                                                <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                                <span class="text-gray-600">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $order->start_date->format('M d, Y') }}</td>
                                    <td class="table-report__action">
                                        <div class="flex items-center">
                                            <a class="flex items-center mr-3 text-blue-600 hover:text-blue-700" href="{{ route('manufacturing.orders.show', $order) }}">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <p>No production orders found</p>
                                            <a href="{{ route('manufacturing.orders.create') }}" class="mt-2 text-blue-600 hover:text-blue-700">Create your first order</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('manufacturing.partials.scripts')
@endsection
