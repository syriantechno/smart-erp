@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employee Rewards - HR</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium flex items-center">
            <x-base.lucide icon="Award" class="w-5 h-5 mr-2 text-emerald-500" />
            Employee Rewards
        </h2>
        <x-base.button
            type="button"
            variant="primary"
            class="ml-3 flex items-center"
            data-tw-toggle="modal"
            data-tw-target="#reward-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Reward
        </x-base.button>
    </div>

    @include('components.global-notifications')

    <div class="intro-y box mt-5">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-4 dark:border-darkmode-400">
            <div class="text-sm text-slate-600 dark:text-slate-300">
                Latest rewards and points granted to employees.
            </div>
        </div>
        <div class="p-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200/60 dark:border-darkmode-400">
                        <th class="px-3 py-2 text-left">Employee</th>
                        <th class="px-3 py-2 text-left">Department</th>
                        <th class="px-3 py-2 text-left">Type</th>
                        <th class="px-3 py-2 text-left">Points</th>
                        <th class="px-3 py-2 text-left">Amount</th>
                        <th class="px-3 py-2 text-left">Granted By</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Reason</th>
                    </tr>
                </thead>
                <tbody id="rewards-table-body">
                    @forelse($rewards as $reward)
                        @include('hr.rewards._row', ['reward' => $reward])
                    @empty
                        <tr>
                            <td colspan="8" class="px-3 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                No rewards recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                    <x-base.button type="button" variant="secondary" data-tw-dismiss="modal">
                        Close
                    </x-base.button>
                    <x-base.button type="submit" variant="primary">
                        Save Reward
                    </x-base.button>
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
        })();
    </script>
@endpush
