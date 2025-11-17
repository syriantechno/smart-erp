@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Projects Dashboard - Smart ERP</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xl:col-span-9">
            <div class="intro-y flex items-center mt-6 mb-4">
                <h2 class="mr-5 text-lg font-medium">Projects Overview</h2>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Folder" class="w-6 h-6 text-primary" />
                            <span class="ml-auto text-xs text-slate-500">Open Projects</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Currently active</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Users" class="w-6 h-6 text-success" />
                            <span class="ml-auto text-xs text-slate-500">Teams</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Project teams</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="Clock" class="w-6 h-6 text-warning" />
                            <span class="ml-auto text-xs text-slate-500">Deadlines</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Due this week</div>
                    </div>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                    <div class="box p-5">
                        <div class="flex items-center">
                            <x-base.lucide icon="CheckSquare" class="w-6 h-6 text-info" />
                            <span class="ml-auto text-xs text-slate-500">Completed</span>
                        </div>
                        <div class="mt-4 text-3xl font-semibold">--</div>
                        <div class="mt-1 text-xs text-slate-500">Closed projects</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 xl:col-span-3 mt-6 xl:mt-6">
            <div class="intro-y box p-5">
                <div class="flex items-center mb-3">
                    <h2 class="text-base font-medium">Project Shortcuts</h2>
                </div>
                <div class="space-y-2 text-sm">
                    <a href="{{ route('project-management.projects.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="Folder" class="w-4 h-4 mr-2" />
                        All Projects
                    </a>
                    <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 dark:bg-darkmode-600 dark:hover:bg-darkmode-500">
                        <x-base.lucide icon="ListChecks" class="w-4 h-4 mr-2" />
                        Tasks Board
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
