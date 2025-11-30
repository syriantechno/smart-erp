@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employee Evaluations - HR</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    @include('components.global-notifications')

    {{-- Heading + top stats strip on the same row (same as Departments) --}}
    <div class="intro-y mt-6 mb-2 flex flex-col gap-1 text-[#3a2a1a]">
        <div class="flex items-baseline justify-between gap-6">
            <h2 class="flex items-center gap-2 text-2xl md:text-3xl font-semibold text-royalDark tracking-wide">
                <x-base.lucide icon="star" class="w-7 h-7" />
                <span>Employee Evaluations</span>
            </h2>

            <div class="flex flex-row items-end gap-8 md:gap-12 justify-end">
                {{-- Needs Improvement --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="alert-triangle" class="w-4 h-4" />
                        </div>
                        <div id="stats-low" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $allEvaluations->low ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Low
                    </div>
                </div>

                {{-- Good evaluations --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="check-circle-2" class="w-4 h-4" />
                        </div>
                        <div id="stats-good" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $allEvaluations->good ?? 0 }}
                        </div>
                    </div>
                    <div class="self-start pl-2 text-xs uppercase tracking-[0.25em] text-slate-600">
                        Good
                    </div>
                </div>

                {{-- Total evaluations --}}
                <div class="flex flex-col items-center gap-1">
                    <div class="flex items-baseline gap-2">
                        <div class="inline-flex items-center justify-center rounded-full bg-white/40 px-1.5 py-1">
                            <x-base.lucide icon="star" class="w-4 h-4" />
                        </div>
                        <div id="stats-total" class="text-6xl md:text-7xl font-semibold tracking-tight">
                            {{ $allEvaluations->total ?? 0 }}
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
                    {{-- Filters & Actions in One Row (same as Departments) --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        {{-- Search Input --}}
                        <div class="relative min-w-[180px]">
                            <x-base.lucide icon="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <x-base.form-input 
                                id="evaluations-filter-value" 
                                type="text" 
                                placeholder="Search..." 
                                class="pl-9 w-full text-sm py-1.5"
                            />
                        </div>

                        {{-- Rating Filter --}}
                        <x-base.form-select id="rating-filter" class="w-auto text-sm py-1.5">
                            <option value="">All Ratings</option>
                            <option value="excellent">Excellent (8-10)</option>
                            <option value="good">Good (5-7)</option>
                            <option value="low">Needs Improvement (1-4)</option>
                        </x-base.form-select>

                        {{-- Page Length --}}
                        <x-base.form-select id="evaluations-filter-length" class="w-auto text-sm py-1.5">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-base.form-select>

                        {{-- Reset Button --}}
                        <x-base.tippy as="button" id="evaluations-filter-reset" type="button" content="Reset filters" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                            <x-base.lucide icon="x" class="w-4 h-4" />
                        </x-base.tippy>

                        {{-- Spacer --}}
                        <div class="flex-1"></div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1">
                            <x-base.tippy content="Print" placement="bottom">
                                <button type="button" id="evaluations-print" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="printer" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export PDF" placement="bottom">
                                <button type="button" id="evaluations-export-pdf" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-text" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Export Excel" placement="bottom">
                                <button id="evaluations-export" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2">
                                    <x-base.lucide icon="file-spreadsheet" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>
                            <x-base.tippy content="Refresh" placement="bottom">
                                <button id="evaluations-refresh" type="button" class="btn-royal btn-royal--outline btn-royal--sm px-2" onclick="location.reload()">
                                    <x-base.lucide icon="refresh-cw" class="w-4 h-4" />
                                </button>
                            </x-base.tippy>

                            {{-- Add Evaluation Button --}}
                            <x-base.tippy content="Add evaluation" placement="bottom">
                                <button
                                    type="button"
                                    class="btn-royal btn-royal--gold btn-royal--sm"
                                    data-tw-toggle="modal"
                                    data-tw-target="#evaluation-modal"
                                >
                                    <x-base.lucide icon="plus-circle" class="w-4 h-4 mr-2" />
                                    <span class="hidden sm:inline">Add</span>
                                </button>
                            </x-base.tippy>
                        </div>
                    </div>

                    <div class="overflow-x-auto sm:overflow-visible" data-erp-table-wrapper>
                        <table
                            id="evaluations-table"
                            data-tw-merge
                            data-erp-table
                            class="datatable-default w-full min-w-full table-auto text-left text-sm"
                        >
                            <thead>
                                <tr>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Employee</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Department</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Rating</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Evaluator</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Date</th>
                                    <th data-tw-merge class="font-semibold px-5 py-2 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="evaluations-table-body">
                                @forelse($evaluations as $index => $evaluation)
                                    <tr class="intro-x">
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap text-center font-medium">{{ $index + 1 }}</td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 font-medium text-slate-700 datatable-cell-wrap">
                                            <a href="{{ route('hr.employees.show', $evaluation->employee_id) }}" class="font-medium text-primary hover:underline">
                                                {{ $evaluation->employee->full_name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap">{{ $evaluation->employee->department->name ?? '-' }}</td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <x-base.lucide icon="star" class="w-3 h-3 {{ $i <= $evaluation->overall_rating ? 'text-amber-400 fill-amber-300' : 'text-slate-300' }}" />
                                                @endfor
                                                <span class="ml-2 font-semibold {{ $evaluation->overall_rating >= 8 ? 'text-green-600' : ($evaluation->overall_rating >= 5 ? 'text-amber-600' : 'text-red-600') }}">
                                                    {{ $evaluation->overall_rating }}/10
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 datatable-cell-wrap">{{ $evaluation->evaluator->name ?? 'System' }}</td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 whitespace-nowrap">{{ $evaluation->evaluated_at ? $evaluation->evaluated_at->format('M d, Y') : '-' }}</td>
                                        <td class="px-5 py-1.5 border-b dark:border-darkmode-300 text-center">
                                            <div class="flex items-center justify-center gap-1 min-w-[80px]">
                                                <a href="{{ route('hr.employee-evaluations.show', $evaluation) }}">
                                                    <x-erp.action-button
                                                        icon="Eye"
                                                        variant="primary"
                                                        title="View Details"
                                                    />
                                                </a>
                                                <x-erp.action-button
                                                    icon="Trash2"
                                                    variant="danger"
                                                    title="Delete Evaluation"
                                                    onclick="deleteEvaluation({{ $evaluation->id }}, '{{ addslashes($evaluation->employee->full_name ?? 'N/A') }}')"
                                                />
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-10 text-center text-slate-500 dark:text-slate-400">
                                            <x-base.lucide icon="inbox" class="w-12 h-12 mx-auto mb-3 text-slate-300" />
                                            <p class="text-sm">No evaluations recorded yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                        <div class="text-sm text-slate-500">
                            @if($evaluations->total() > 0)
                                Showing {{ $evaluations->firstItem() }} to {{ $evaluations->lastItem() }} of {{ $evaluations->total() }} entries
                            @else
                                No entries found
                            @endif
                        </div>
                        @if($evaluations->hasPages())
                            <div>
                                {{ $evaluations->links() }}
                            </div>
                        @endif
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
                    @if(isset($criteria) && $criteria->count() > 0)
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                            @foreach($criteria as $criterion)
                                <div class="p-3 rounded-lg bg-slate-50 dark:bg-darkmode-600/50">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                            {{ $criterion->name }}
                                        </label>
                                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 criterion-display" data-criterion="{{ $criterion->id }}">0 / 10</span>
                                    </div>
                                    <div class="flex items-center gap-1 criterion-stars" data-criterion="{{ $criterion->id }}">
                                        @for($i = 1; $i <= 10; $i++)
                                            <button type="button" class="star-btn p-0.5 transition-transform hover:scale-110" data-rating="{{ $i }}" data-criterion="{{ $criterion->id }}">
                                                <x-base.lucide icon="star" class="w-5 h-5 text-slate-300 dark:text-slate-600 star-icon" />
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="scores[{{ $criterion->id }}]" class="criterion-input" data-criterion="{{ $criterion->id }}" value="" />
                                </div>
                            @endforeach
                        </div>
                        <!-- Overall Rating Display -->
                        <div class="mt-4 p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-amber-800 dark:text-amber-300">Overall Rating (Auto-calculated)</span>
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center gap-0.5" id="overall-stars-display">
                                        @for($i = 1; $i <= 10; $i++)
                                            <x-base.lucide icon="star" class="w-4 h-4 text-slate-300 dark:text-slate-600 overall-star" />
                                        @endfor
                                    </div>
                                    <span class="text-lg font-bold text-amber-600 dark:text-amber-400" id="overall-rating-display">0 / 10</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- No criteria - show message -->
                        <div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800">
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                <x-base.lucide icon="alert-triangle" class="w-4 h-4 inline mr-1" />
                                No evaluation criteria found. Please run the seeder or add criteria manually.
                            </p>
                        </div>
                    @endif
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

            // Multi-Criteria Star Rating System
            const criterionContainers = document.querySelectorAll('.criterion-stars');
            const criterionRatings = {}; // Store ratings for each criterion

            function updateCriterionStars(criterionId, rating, isHover = false) {
                const container = document.querySelector(`.criterion-stars[data-criterion="${criterionId}"]`);
                const display = document.querySelector(`.criterion-display[data-criterion="${criterionId}"]`);
                const input = document.querySelector(`.criterion-input[data-criterion="${criterionId}"]`);
                
                if (!container) return;

                const stars = container.querySelectorAll('.star-btn');
                stars.forEach((btn, index) => {
                    const starIcon = btn.querySelector('.star-icon');
                    if (index < rating) {
                        starIcon.classList.remove('text-slate-300', 'dark:text-slate-600');
                        starIcon.classList.add('text-amber-400', 'fill-amber-300/80');
                    } else {
                        starIcon.classList.remove('text-amber-400', 'fill-amber-300/80');
                        starIcon.classList.add('text-slate-300', 'dark:text-slate-600');
                    }
                });

                if (!isHover) {
                    criterionRatings[criterionId] = rating;
                    if (input) input.value = rating;
                    if (display) display.textContent = rating + ' / 10';
                    updateOverallRating();
                }
            }

            function updateOverallRating() {
                const ratings = Object.values(criterionRatings).filter(r => r > 0);
                const overall = ratings.length > 0 ? Math.round(ratings.reduce((a, b) => a + b, 0) / ratings.length) : 0;
                
                const overallDisplay = document.getElementById('overall-rating-display');
                const overallStars = document.querySelectorAll('.overall-star');
                
                if (overallDisplay) {
                    overallDisplay.textContent = overall + ' / 10';
                }
                
                overallStars.forEach((star, index) => {
                    if (index < overall) {
                        star.classList.remove('text-slate-300', 'dark:text-slate-600');
                        star.classList.add('text-amber-400', 'fill-amber-300/80');
                    } else {
                        star.classList.remove('text-amber-400', 'fill-amber-300/80');
                        star.classList.add('text-slate-300', 'dark:text-slate-600');
                    }
                });
            }

            // Initialize star click handlers
            criterionContainers.forEach(container => {
                const criterionId = container.dataset.criterion;
                criterionRatings[criterionId] = 0;
                
                const stars = container.querySelectorAll('.star-btn');
                stars.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const rating = parseInt(this.dataset.rating);
                        updateCriterionStars(criterionId, rating, false);
                    });

                    btn.addEventListener('mouseenter', function() {
                        const rating = parseInt(this.dataset.rating);
                        updateCriterionStars(criterionId, rating, true);
                    });

                    btn.addEventListener('mouseleave', function() {
                        updateCriterionStars(criterionId, criterionRatings[criterionId] || 0, true);
                    });
                });
            });

            if (!form || !tableBody) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Validate all criteria are rated
                const inputs = form.querySelectorAll('.criterion-input');
                let allRated = true;
                inputs.forEach(input => {
                    if (!input.value || input.value === '' || input.value === '0') {
                        allRated = false;
                        const criterionId = input.dataset.criterion;
                        const container = document.querySelector(`.criterion-stars[data-criterion="${criterionId}"]`);
                        if (container) {
                            container.closest('.p-3').classList.add('ring-2', 'ring-red-400');
                            setTimeout(() => {
                                container.closest('.p-3').classList.remove('ring-2', 'ring-red-400');
                            }, 2000);
                        }
                    }
                });

                if (!allRated) {
                    alert('Please rate all criteria before saving.');
                    return;
                }

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

                    // نظف الفورم والنجوم
                    form.reset();
                    resetAllStars();

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

            // Reset all stars function
            function resetAllStars() {
                Object.keys(criterionRatings).forEach(criterionId => {
                    criterionRatings[criterionId] = 0;
                    updateCriterionStars(criterionId, 0, false);
                });
                updateOverallRating();
            }

            // Reset stars when modal is closed
            if (modal) {
                modal.addEventListener('hidden.tw.modal', resetAllStars);
            }
            // Delete evaluation function
            window.deleteEvaluation = function(id, name) {
                if (window.erpDeleteRecord) {
                    window.erpDeleteRecord(id, name);
                } else if (confirm('Are you sure you want to delete this evaluation for ' + name + '?')) {
                    // Fallback delete
                    fetch('/hr/employee-evaluations/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    }).then(() => location.reload());
                }
            };

            // View evaluation details function
            window.viewEvaluationDetails = function(id) {
                // TODO: Implement view details modal
                console.log('View evaluation:', id);
            };
        })();
    </script>
@endpush

@include('components.datatable.scripts')
