@php
    $levels = $levels ?? [];
@endphp

<div class="flex items-center gap-2 justify-center">
    @forelse ($levels as $level)
        @php
            $isCompleted = $level['is_completed'] ?? false;
            $isCurrent = $level['is_current'] ?? false;
            $isRejected = $level['is_rejected'] ?? false;
            $title = ($level['name'] ?? __('Level')) . ' — ' . ($level['approver'] ?? __('Approver'));

            $dotClass = 'bg-slate-300';
            if ($isCompleted) {
                $dotClass = 'bg-emerald-500';
            } elseif ($isRejected) {
                $dotClass = 'bg-danger';
            } elseif ($isCurrent) {
                $dotClass = 'bg-amber-400 animate-pulse';
            }
        @endphp
        <div class="flex items-center gap-2">
            <div
                class="w-3 h-3 rounded-full {{ $dotClass }}"
                title="{{ $title }}"
            ></div>
            @unless ($loop->last)
                <div class="w-4 h-px bg-slate-200"></div>
            @endunless
        </div>
    @empty
        <span class="text-xs text-slate-400">—</span>
    @endforelse
</div>
