@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employee Rewards - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    @include('components.global-notifications')

    @php
        $totalRewards = $rewards->count();
        $totalPoints = $rewards->sum('points');
        $totalAmount = $rewards->sum('amount');
        $thisMonth = $rewards->filter(fn($r) => ($r->granted_at ?? $r->created_at)?->isCurrentMonth())->count();
    @endphp

    {{-- Heading + top stats strip on the same row (Same as Departments) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="gift" class="w-7 h-7" />
                <span>Employee Rewards</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- This Month --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="calendar" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $thisMonth }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        This Month
                    </div>
                </div>

                {{-- Total Points --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="star" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ number_format($totalPoints) }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Points
                    </div>
                </div>

                {{-- Total Rewards --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="gift" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $totalRewards }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Rewards
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    {{-- Filters & Actions in One Row --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="rewards-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Type Filter --}}
                        <x-base.form-select id="type-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Types</option>
                            <option value="bonus">Bonus</option>
                            <option value="gift">Gift</option>
                            <option value="achievement">Achievement</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="rewards-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="rewards-print" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="rewards-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" onclick="location.reload()">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Reward Button --}}
                            <x-base.tippy content="Add reward" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#reward-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="rewards-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Type</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Points</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Amount</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Granted By</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Date</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="rewards-table-body">
                                @forelse($rewards as $index => $reward)
                                    <tr>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap text-center font-medium">{{ $index + 1 }}</td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap">
                                            <a href="{{ route('hr.employees.show', $reward->employee_id) }}" class="text-primary hover:underline">
                                                {{ $reward->employee->full_name ?? 'Unknown' }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap">
                                            {{ $reward->employee->department->name ?? '-' }}
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap">
                                            @if($reward->type)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ ucfirst($reward->type) }}
                                                </span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 text-center whitespace-nowrap font-medium">
                                            <span class="text-green-600 dark:text-green-400">+{{ $reward->points }}</span>
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 text-center whitespace-nowrap">
                                            @if($reward->amount)
                                                <span class="font-medium text-amber-600 dark:text-amber-400">{{ number_format($reward->amount, 2) }}</span>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap">
                                            {{ $reward->granter->name ?? '-' }}
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap">
                                            {{ optional($reward->granted_at ?? $reward->created_at)->format('M d, Y') }}
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 text-center">
                                            <div class="flex items-center justify-center gap-1 min-w-[80px]">
                                                <x-erp.action-button
                                                    icon="Eye"
                                                    variant="primary"
                                                    title="View Details"
                                                    onclick="viewRewardDetails({{ $reward->id }})"
                                                />
                                                <x-erp.action-button
                                                    icon="Trash2"
                                                    variant="danger"
                                                    title="Delete Reward"
                                                    onclick="deleteReward({{ $reward->id }}, '{{ addslashes($reward->employee->full_name ?? 'N/A') }}')"
                                                />
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">
                                            <div class="flex flex-col items-center">
                                                <x-base.lucide icon="gift" class="w-12 h-12 text-slate-300 mb-2" />
                                                <span>No rewards recorded yet.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
    <x-base.dialog id="reward-modal">
        <x-base.dialog.panel class="p-0">
            <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium">Add Reward</h2>
                <button type="button" class="text-slate-400" data-tw-dismiss="modal">
                    <x-base.lucide icon="X" class="w-4 h-4" />
                </button>
            </div>
            <form method="POST" action="{{ route('hr.employee-rewards.store') }}" id="reward-form">
                @csrf
                <div class="px-5 py-4 space-y-4">
                    <div>
                        <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Employee</label>
                        <x-base.form-select name="employee_id" required class="w-full">
                            <option value="">Select employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">
                                    {{ $emp->full_name ?? ($emp->first_name . ' ' . $emp->last_name) }}
                                    @if($emp->department)
                                        - {{ $emp->department->name }}
                                    @endif
                                </option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div>
                            <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Points</label>
                            <x-base.form-input
                                type="number"
                                name="points"
                                min="1"
                                step="1"
                                required
                                class="w-full"
                                placeholder="Enter points"
                            />
                        </div>
                        <div>
                            <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Amount (optional)</label>
                            <x-base.form-input
                                type="number"
                                name="amount"
                                min="0"
                                step="0.01"
                                class="w-full"
                                placeholder="0.00"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div>
                            <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Type (optional)</label>
                            <x-base.form-input
                                type="text"
                                name="type"
                                class="w-full"
                                placeholder="Bonus, Gift, Penalty, ..."
                                maxlength="100"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Reason (optional)</label>
                        <x-base.form-textarea
                            name="reason"
                            rows="3"
                            class="w-full"
                            placeholder="Write a short note about this reward"
                        ></x-base.form-textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <button type="button" class="btn-royal btn-royal--outline btn-royal--sm" data-tw-dismiss="modal">
                        <x-base.lucide icon="x" class="w-4 h-4 mr-1" />
                        Cancel
                    </button>
                    <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">
                        <x-base.lucide icon="check" class="w-4 h-4 mr-1" />
                        Save Reward
                    </button>
                </div>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('reward-form');
            const tableBody = document.getElementById('rewards-table-body');
            const modal = document.getElementById('reward-modal');

            if (!form || !tableBody) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        window.location.reload();
                        return;
                    }

                    const data = await response.json();

                    if (data.row) {
                        const temp = document.createElement('tbody');
                        temp.innerHTML = data.row.trim();
                        const newRow = temp.firstElementChild;
                        if (newRow) {
                            tableBody.insertBefore(newRow, tableBody.firstChild);
                        }
                    }

                    form.reset();

                    if (modal) {
                        const closeBtn = modal.querySelector('[data-tw-dismiss="modal"]');
                        if (closeBtn) {
                            closeBtn.click();
                        }
                    }
                } catch (error) {
                    console.error('Failed to submit reward via AJAX', error);
                    window.location.reload();
                }
            });

            // Delete reward function
            window.deleteReward = function(id, name) {
                if (window.erpDeleteRecord) {
                    window.erpDeleteRecord(id, name);
                } else if (confirm('Are you sure you want to delete this reward for ' + name + '?')) {
                    fetch('/hr/employee-rewards/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    }).then(() => location.reload());
                }
            };

            // View reward details function
            window.viewRewardDetails = function(id) {
                window.location.href = '/hr/employee-rewards/' + id;
            };
        })();
    </script>
@endpush

@include('components.datatable.scripts')
