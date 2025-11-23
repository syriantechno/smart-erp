@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employee Evaluations - HR</title>
@endsection

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (Evaluations template follows Employees) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="star" class="w-7 h-7 text-amber-400" />
                <span>Employee Evaluations</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Inactive / pending evaluations (placeholder) --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="clock" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $evaluationsPending ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Pending
                    </div>
                </div>

                {{-- Completed evaluations --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $evaluationsCompleted ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Completed
                    </div>
                </div>

                {{-- Total evaluations --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="star" class="w-4 h-4" />
                        </div>
                        <div class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $evaluationsTotal ?? '—' }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Evaluations
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box bg-white/80 border border-slate-200/70 shadow-[0_18px_45px_rgba(15,23,42,0.10)]">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                        {{-- Filters row - same layout as Positions, adapted for evaluations --}}
                        <form id="evaluations-filter-form" class="w-full sm:mr-auto xl:flex">
                            <div class="items-center sm:mr-4 sm:flex">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Field
                                </label>
                                <x-base.form-select id="evaluations-filter-field" class="mt-2 w-full sm:mt-0 sm:w-auto 2xl:w-full">
                                    <option value="all">All Fields</option>
                                    <option value="employee">Employee</option>
                                    <option value="department">Department</option>
                                    <option value="evaluator">Evaluator</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Type
                                </label>
                                <x-base.form-select id="evaluations-filter-type" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="contains">Contains</option>
                                    <option value="equals">Equals</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Value
                                </label>
                                <x-base.form-input id="evaluations-filter-value" type="text" placeholder="Search..." class="mt-2 w-full sm:mt-0 sm:w-48 2xl:w-full" />
                            </div>
                            <div class="mt-2 items-center sm:mr-4 sm:flex xl:mt-0">
                                <label class="mr-2 w-16 flex-none xl:w-auto xl:flex-initial">
                                    Show
                                </label>
                                <x-base.form-select id="evaluations-filter-length" class="mt-2 w-full sm:mt-0 sm:w-auto">
                                    <option value="10">10</option>
                                    <option value="25" selected>25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </x-base.form-select>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 sm:items-center xl:mt-0">
                                <x-base.tippy content="Apply filters" placement="top">
                                    <button id="evaluations-filter-go" type="button" class="btn-royal btn-royal--dark btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="search" class="w-4 h-4 icon-hover-rise" />
                                        Go
                                    </button>
                                </x-base.tippy>
                                <x-base.tippy content="Reset filters" placement="top">
                                    <button id="evaluations-filter-reset" type="button" class="btn-royal btn-royal--outline btn-royal--sm w-full sm:w-24 group">
                                        <x-base.lucide icon="rotate-ccw" class="w-4 h-4 icon-hover-rise" />
                                        Reset
                                    </button>
                                </x-base.tippy>
                            </div>
                        </form>

                        {{-- Toolbar row - icons + Add button same as Positions layout --}}
                        <div class="mt-5 flex flex-wrap items-center gap-2 sm:mt-0 sm:flex-nowrap">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark" title="Print">
                                    <x-base.lucide icon="printer" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark" title="Export PDF">
                                    <x-base.lucide icon="file-text" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export to Excel" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark" title="Export to Excel">
                                    <x-base.lucide icon="file-spreadsheet" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button type="button" class="btn-royal btn-royal--outline btn-royal--sm btn-tonal--icon group text-royalDark" title="Refresh">
                                    <x-base.lucide icon="refresh-cw" class="w-5 h-5 icon-hover-rise" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Evaluation button at the right end of the toolbar --}}
                            <x-base.tippy content="Add new evaluation" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm sm:btn-royal--lg group"
                                    data-tw-toggle="modal"
                                    data-tw-target="#evaluation-modal"
                                >
                                    <x-base.lucide icon="plus" class="w-4 h-4 mr-2 icon-hover-rise" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table class="datatable-default w-full min-w-full table-auto text-left text-sm">
                            <thead>
                                <tr>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Employee</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Department</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Overall Rating</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Evaluator</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Date</th>
                                    <th class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-left">Comments</th>
                                </tr>
                            </thead>
                            <tbody id="evaluations-table-body">
                                @forelse($evaluations as $evaluation)
                                    @include('hr.evaluations._row', ['evaluation' => $evaluation])
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                            No evaluations recorded yet.
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

    <!-- Add/Edit Evaluation Modal (structure only, logic will be wired later) -->
    <x-base.dialog id="evaluation-modal">
        <x-base.dialog.panel class="p-0">
            <div class="flex items-center border-b border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium">Add Evaluation</h2>
                <button type="button" class="text-slate-400" data-tw-dismiss="modal">
                    <x-base.lucide icon="X" class="w-4 h-4" />
                </button>
            </div>
            <form method="POST" action="{{ route('hr.employee-evaluations.store') }}" id="evaluation-form">
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
                        @foreach($criteria as $criterion)
                            <div>
                                <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">
                                    {{ $criterion->name }}
                                </label>
                                <x-base.form-select name="scores[{{ $criterion->id }}]" class="w-full" required>
                                    <option value="">Select score (1-10)</option>
                                    @for($i = 10; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} / 10</option>
                                    @endfor
                                </x-base.form-select>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <label class="text-xs font-medium text-slate-600 dark:text-slate-300 mb-1 block">Comments (optional)</label>
                        <x-base.form-textarea
                            name="comments"
                            rows="3"
                            class="w-full"
                            placeholder="Write a short note about this evaluation"
                        ></x-base.form-textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-200/60 px-5 py-3 dark:border-darkmode-400">
                    <x-base.button type="button" variant="secondary" data-tw-dismiss="modal">
                        Close
                    </x-base.button>
                    <x-base.button type="submit" variant="primary">
                        Save Evaluation
                    </x-base.button>
                </div>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('evaluation-form');
            const tableBody = document.getElementById('evaluations-table-body');
            const modal = document.getElementById('evaluation-modal');

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
                        // إذا صار خطأ في الفاليديشن، نخلي السلوك الافتراضي (ريلود) كـ fallback
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

                    // نظف الفورم
                    form.reset();

                    // أغلق المودال (باستخدام data-tw-dismiss أو الكلاس الخاص بك)
                    if (modal) {
                        const closeBtn = modal.querySelector('[data-tw-dismiss="modal"]');
                        if (closeBtn) {
                            closeBtn.click();
                        }
                    }
                } catch (error) {
                    console.error('Failed to submit evaluation via AJAX', error);
                    window.location.reload();
                }
            });
        })();
    </script>
@endpush
