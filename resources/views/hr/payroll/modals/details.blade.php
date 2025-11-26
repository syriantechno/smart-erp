{{-- Payroll Details Modal --}}
<x-modal.form id="details-modal" title="Payroll Details" size="xl">
    <div class="space-y-6">
        {{-- Employee Info --}}
        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg">
            <div class="w-16 h-16 rounded-full bg-slate-600 flex items-center justify-center text-white text-xl font-bold">
                <span id="detail-avatar">E</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-800" id="detail-employee">-</h3>
                <p class="text-sm text-slate-500" id="detail-department">-</p>
                <p class="text-sm text-slate-500">Period: <span id="detail-period" class="font-medium">-</span></p>
            </div>
            <div class="ml-auto">
                <span id="detail-status" class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">-</span>
            </div>
        </div>

        {{-- Salary Breakdown --}}
        <div class="grid grid-cols-12 gap-4">
            {{-- Basic Salary --}}
            <div class="col-span-12 md:col-span-6">
                <div class="p-4 border rounded-lg">
                    <h4 class="font-medium text-slate-700 mb-3 flex items-center gap-2">
                        <x-base.lucide icon="wallet" class="w-4 h-4" />
                        Basic Salary
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Monthly Salary:</span>
                            <span class="font-medium" id="detail-basic">0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Hourly Rate:</span>
                            <span class="font-medium" id="detail-hourly-rate">0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Working Days:</span>
                            <span class="font-medium" id="detail-working-days">0 / 0</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Overtime --}}
            <div class="col-span-12 md:col-span-6">
                <div class="p-4 border rounded-lg border-green-200 bg-green-50">
                    <h4 class="font-medium text-green-700 mb-3 flex items-center gap-2">
                        <x-base.lucide icon="timer" class="w-4 h-4" />
                        Overtime
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">OT Hours:</span>
                            <span class="font-medium text-green-600" id="detail-overtime-hours">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">OT Amount:</span>
                            <span class="font-bold text-green-600" id="detail-overtime-amount">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deductions --}}
            <div class="col-span-12 md:col-span-6">
                <div class="p-4 border rounded-lg border-red-200 bg-red-50">
                    <h4 class="font-medium text-red-700 mb-3 flex items-center gap-2">
                        <x-base.lucide icon="minus-circle" class="w-4 h-4" />
                        Deductions
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Absent Days:</span>
                            <span class="font-medium text-red-600" id="detail-absent">0 days</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Other Deductions:</span>
                            <span class="font-medium text-red-600" id="detail-deductions">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bonuses --}}
            <div class="col-span-12 md:col-span-6">
                <div class="p-4 border rounded-lg border-blue-200 bg-blue-50">
                    <h4 class="font-medium text-blue-700 mb-3 flex items-center gap-2">
                        <x-base.lucide icon="gift" class="w-4 h-4" />
                        Bonuses
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Total Bonuses:</span>
                            <span class="font-bold text-blue-600" id="detail-bonuses">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Net Salary --}}
        <div class="p-4 bg-gradient-to-r from-slate-800 to-slate-700 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-slate-300">Net Salary</h4>
                    <p class="text-3xl font-bold" id="detail-net">0.00</p>
                </div>
                <x-base.lucide icon="banknote" class="w-12 h-12 text-slate-400" />
            </div>
        </div>
    </div>

    @slot('footer')
        <div class="flex justify-end gap-2 w-full">
            <button type="button" class="btn-royal btn-royal--outline" data-tw-dismiss="modal">
                <x-base.lucide icon="x" class="w-4 h-4 mr-2" />
                Close
            </button>
            <button type="button" class="btn-royal btn-royal--dark" onclick="window.print()">
                <x-base.lucide icon="printer" class="w-4 h-4 mr-2" />
                Print
            </button>
        </div>
    @endslot
</x-modal.form>
