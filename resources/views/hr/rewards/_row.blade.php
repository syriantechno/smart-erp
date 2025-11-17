@php /** @var \App\Models\HR\EmployeeReward $reward */ @endphp
<tr class="border-b border-slate-100 dark:border-darkmode-500/40 hover:bg-slate-50 dark:hover:bg-darkmode-600/60 transition-colors">
    <td class="px-3 py-2">
        <a href="{{ route('hr.employees.show', $reward->employee_id) }}" class="font-medium text-slate-800 dark:text-slate-100 hover:text-primary">
            {{ $reward->employee->full_name ?? 'Unknown' }}
        </a>
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400">
        {{ $reward->employee->department->name ?? '-' }}
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400 capitalize">
        {{ $reward->type }}
    </td>
    <td class="px-3 py-2 text-emerald-600 dark:text-emerald-400 font-semibold">
        +{{ $reward->points }} pts
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400">
        @if($reward->amount)
            {{ format_currency($reward->amount, 2) }}
        @else
            -
        @endif
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400">
        {{ $reward->granter->name ?? '-' }}
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400">
        {{ optional($reward->granted_at ?? $reward->created_at)->format('Y-m-d') }}
    </td>
    <td class="px-3 py-2 text-slate-600 dark:text-slate-400 max-w-xs">
        <span class="line-clamp-2">{{ $reward->reason }}</span>
    </td>
</tr>
