@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Estimates Management - {{ config('app.name') }}</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium">Estimates Management</h2>
                        <button
                            class="btn-tonal btn-tonal--success"
                            onclick="alert('Create Estimate functionality coming soon!')"
                        >
                            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
                            Add New Estimate
                        </button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-12 gap-6 mb-6">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-info p-5 text-center">
                                <div class="text-3xl font-bold mb-2">0</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="calculator" class="w-4 h-4" />
                                    Total Estimates
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-warning p-5 text-center">
                                <div class="text-3xl font-bold mb-2">0</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="clock" class="w-4 h-4" />
                                    Pending
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-success p-5 text-center">
                                <div class="text-3xl font-bold mb-2">0</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="check-circle" class="w-4 h-4" />
                                    Approved
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                            <div class="stats-card-danger p-5 text-center">
                                <div class="text-3xl font-bold mb-2">0</div>
                                <div class="flex items-center justify-center gap-2 text-sm opacity-80">
                                    <x-base.lucide icon="x-circle" class="w-4 h-4" />
                                    Rejected
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estimates Table -->
                    <div class="overflow-x-auto">
                        <table id="estimates-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">#</th>
                                    <th class="whitespace-nowrap">Code</th>
                                    <th class="whitespace-nowrap">Title</th>
                                    <th class="whitespace-nowrap">Client</th>
                                    <th class="whitespace-nowrap">Amount</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Date</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-slate-500">
                                        <x-base.lucide icon="calculator" class="w-12 h-12 mx-auto mb-3 opacity-50" />
                                        <p>No estimates found. Create your first estimate!</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection
