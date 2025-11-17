@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Accounting Dashboard - Smart ERP</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xl:col-span-9">
            <div class="intro-y flex items-center mt-6 mb-4">
                <h2 class="mr-5 text-lg font-medium">Accounting Overview</h2>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="DollarSign" class="w-6 h-6 text-primary" />
                            <span class="ml-auto text-xs text-slate-500">Revenue</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">This month</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="CreditCard" class="w-6 h-6 text-danger" />
                            <span class="ml-auto text-xs text-slate-500">Expenses</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">This month</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="BarChart2" class="w-6 h-6 text-success" />
                            <span class="ml-auto text-xs text-slate-500">Net Profit</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">This month</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="ClipboardList" class="w-6 h-6 text-warning" />
                            <span class="ml-auto text-xs text-slate-500">Journal Entries</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Last 30 days</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-3 mt-6 xl:mt-6">
            <div class="intro-y box p-5">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium">Accounting Shortcuts</h2>
                </div>
                <div class="space-y-2 text-sm">
                    <a href="{{ route('accounting.chart-of-accounts.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Layers" class="w-4 h-4 mr-2" />
                        Chart of Accounts
                    </a>
                    <a href="{{ route('accounting.journal-entries.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="FileText" class="w-4 h-4 mr-2" />
                        Journal Entries
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
