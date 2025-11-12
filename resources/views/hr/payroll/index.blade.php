@extends('layouts.main')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-12">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Payroll Management
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="dollar-sign" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="15% Higher than last month"> 15% <x-base.lucide icon="chevron-up" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">$45,250</div>
                                <div class="text-base text-slate-500 mt-1">Total Payroll This Month</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="users" class="report-box__icon text-primary" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="Stable"> 0% <x-base.lucide icon="minus" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">127</div>
                                <div class="text-base text-slate-500 mt-1">Active Employees</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="clock" class="report-box__icon text-warning" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer" title="Pending salaries"> 5 <x-base.lucide icon="alert-circle" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">5</div>
                                <div class="text-base text-slate-500 mt-1">Pending Payments</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <x-base.lucide icon="check-circle" class="report-box__icon text-success" />
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="122 completed this month"> 122 <x-base.lucide icon="check" class="w-4 h-4 ml-0.5" /></div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">122</div>
                                <div class="text-base text-slate-500 mt-1">Processed This Month</div>
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
