@extends('layouts.main')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Leave Management
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="calendar" class="report-box__icon text-primary" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="33% Higher than last month"> 33% <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">4,509</div>
                                <div class="text-base text-slate-500 mt-1">Total Leave Requests</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="check-circle" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="2% Higher than last month"> 2% <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">3,897</div>
                                <div class="text-base text-slate-500 mt-1">Approved Leaves</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="clock" class="report-box__icon text-warning" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer" title="12% Lower than last month"> 12% <x-base.lucide icon="chevron-down" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">612</div>
                                <div class="text-base text-slate-500 mt-1">Pending Leaves</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="x-circle" class="report-box__icon text-danger" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="22% Lower than last month"> 22% <x-base.lucide icon="chevron-down" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Rejected Leaves</div>
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
