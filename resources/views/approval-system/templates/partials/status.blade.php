@php
    $isActive = $isActive ?? false;
@endphp

<span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold {{ $isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
    <i data-lucide="{{ $isActive ? 'check-circle' : 'pause-circle' }}" class="w-3.5 h-3.5"></i>
    {{ $isActive ? 'Active' : 'Inactive' }}
</span>
