@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Employee Evaluations - HR</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium flex items-center">
            <x-base.lucide icon="Star" class="w-5 h-5 mr-2 text-amber-400" />
            Employee Evaluations
        </h2>
        <x-base.button
            type="button"
            variant="primary"
            class="ml-3 flex items-center"
            data-tw-toggle="modal"
            data-tw-target="#evaluation-modal"
        >
            <x-base.lucide icon="Plus" class="w-4 h-4 mr-2" />
            Add Evaluation
        </x-base.button>
    </div>

    @include('components.global-notifications')

    <div class="intro-y box mt-5">
        <div class="flex items-center border-b border-slate-200/60 px-5 py-4 dark:border-darkmode-400">
            <div class="text-sm text-slate-600 dark:text-slate-300">
                Latest evaluations across all employees.
            </div>
        </div>
        <div class="p-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200/60 dark:border-darkmode-400">
                        <th class="px-3 py-2 text-left">Employee</th>
                        <th class="px-3 py-2 text-left">Department</th>
                        <th class="px-3 py-2 text-left">Overall Rating</th>
                        <th class="px-3 py-2 text-left">Evaluator</th>
                        <th class="px-3 py-2 text-left">Date</th>
                        <th class="px-3 py-2 text-left">Comments</th>
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
