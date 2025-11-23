@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subcontent')
<div class="mt-8 flex items-center">
    <h2 class="mr-auto text-lg font-medium">Payroll Management</h2>
</div>

<div class="mt-5 grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="flex flex-col gap-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-r from-royalDark to-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="dollar-sign" class="w-8 h-8 text-royalYellow" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Total Payroll</p>
                            <p class="text-royalYellow text-2xl font-bold">$45,250</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="users" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Active Employees</p>
                            <p class="text-white text-2xl font-bold">127</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="clock" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Pending Payments</p>
                            <p class="text-white text-2xl font-bold">5</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-base.lucide icon="check-circle" class="w-8 h-8 text-white" />
                        </div>
                        <div class="ml-4">
                            <p class="text-white text-sm font-medium uppercase tracking-wider">Processed</p>
                            <p class="text-white text-2xl font-bold">122</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">Payroll Overview</h3>
                            <p class="text-sm text-slate-500">Manage employee salaries and payroll processing.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button"
                                class="btn-royal btn-royal--gold group">
                                <x-base.lucide icon="plus-circle" class="w-5 h-5 icon-hover-rise" />
                                Process Payroll
                            </button>
                            <button type="button"
                                class="btn-royal btn-royal--outline btn-royal--icon group"
                                title="Export payroll data">
                                <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 rounded-lg bg-slate-50 p-4 text-sm text-slate-500">
                        <p class="font-semibold text-slate-700">Payroll Management</p>
                        <p>This section will contain payroll tables, salary calculations, and payment processing features.</p>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
</div>
@endsection
