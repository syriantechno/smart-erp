@php /** @var \App\Models\HR\EmployeeEvaluation $evaluation */ @endphp
<tr>
    <td class="px-5 py-2">
        <a href="{{ route('hr.employees.show', $evaluation->employee_id) }}" class="font-medium text-slate-800 dark:text-slate-100 hover:text-primary">
            {{ $evaluation->employee->full_name ?? 'Unknown' }}
        </a>
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        {{ $evaluation->employee->department->name ?? '-' }}
    </td>
    <td class="px-5 py-2">
        <div class="flex items-center">
            @for ($i = 1; $i <= 10; $i++)
                <x-base.lucide
                    icon="Star"
                    class="w-4 h-4 mr-0.5 {{ $evaluation->overall_rating >= $i ? 'text-amber-400 fill-amber-300/80' : 'text-slate-300 dark:text-slate-600' }}"
                />
            @endfor
            <span class="ml-2 text-xs text-slate-500 dark:text-slate-400">{{ $evaluation->overall_rating }} / 10</span>
        </div>
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        {{ $evaluation->evaluator->name ?? '-' }}
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400">
        {{ optional($evaluation->evaluated_at ?? $evaluation->created_at)->format('Y-m-d') }}
    </td>
    <td class="px-5 py-2 text-slate-600 dark:text-slate-400 max-w-xs">
        <span class="line-clamp-2">{{ $evaluation->comments }}</span>
    </td>
</tr>
