@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>General Dashboard - Smart ERP</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xl:col-span-8">
            <div class="intro-y flex items-center mt-6 mb-4">
                <h2 class="mr-5 text-lg font-medium">General Overview</h2>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Users" class="w-6 h-6 text-primary" />
                            <span class="ml-auto text-xs text-slate-500">Employees</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Total active employees</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Briefcase" class="w-6 h-6 text-success" />
                            <span class="ml-auto text-xs text-slate-500">Projects</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Open projects</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="DollarSign" class="w-6 h-6 text-warning" />
                            <span class="ml-auto text-xs text-slate-500">Accounting</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">This month revenue</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Activity" class="w-6 h-6 text-info" />
                            <span class="ml-auto text-xs text-slate-500">System</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Open tasks</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-4 mt-6 xl:mt-6">
            <div class="intro-y box p-5">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium">Quick Links</h2>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <a href="{{ route('hr.employees.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Users" class="w-4 h-4 mr-2" />
                        HR
                    </a>
                    <a href="{{ route('project-management.projects.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Folder" class="w-4 h-4 mr-2" />
                        Projects
                    </a>
                    <a href="{{ route('accounting.chart-of-accounts.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="FileText" class="w-4 h-4 mr-2" />
                        Accounting
                    </a>
                    <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="CheckSquare" class="w-4 h-4 mr-2" />
                        Tasks
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
