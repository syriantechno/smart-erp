@extends('layouts.main')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Recruitment Management
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="file-text" class="report-box__icon text-primary" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="12 new applications"> 12 <x-base.lucide icon="plus" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">45</div>
                                <div class="text-base text-slate-500 mt-1">Open Positions</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="users" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="8% Higher than last month"> 8% <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">156</div>
                                <div class="text-base text-slate-500 mt-1">Total Applications</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="calendar" class="report-box__icon text-warning" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer" title="5 interviews scheduled"> 5 <x-base.lucide icon="calendar" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">5</div>
                                <div class="text-base text-slate-500 mt-1">Interviews Today</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="user-check" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="3 offers extended"> 3 <x-base.lucide icon="check-circle" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">23</div>
                                <div class="text-base text-slate-500 mt-1">Hired This Month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->
        </div>
    </div>
</div>
@endsection
