@php
    $canEdit = true; // Add permission check later
    $canDelete = true; // Add permission check later
@endphp

<div class="flex items-center justify-center gap-1">
    <!-- View Button -->
    <a href="#" onclick="viewShift({{ $shift->id }})"
       class="flex items-center px-2 py-1 text-xs font-medium text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200"
       title="View">
        <x-base.lucide icon="Eye" class="w-4 h-4" />
    </a>

    <!-- Edit Button (UI only for now, calls editShift handler) -->
    @if($canEdit)
        <button type="button"
                onclick="editShift({{ $shift->id }})"
                class="flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"
                title="Edit">
            <x-base.lucide icon="Edit" class="w-4 h-4" />
        </button>
    @endif

    <!-- Toggle Status Button -->
    <button onclick="toggleShiftStatus({{ $shift->id }})"
            class="flex items-center px-2 py-1 text-xs font-medium {{ $shift->is_active ? 'text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-200' : 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200' }}"
            title="{{ $shift->is_active ? 'Deactivate' : 'Activate' }}">
        <x-base.lucide icon="{{ $shift->is_active ? 'EyeOff' : 'Eye' }}" class="w-4 h-4" />
    </button>

    <!-- Delete Button -->
    @if($canDelete)
        <button onclick="deleteShift({{ $shift->id }}, '{{ addslashes($shift->name) }}')"
                class="flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200"
                title="Delete">
            <x-base.lucide icon="Trash2" class="w-4 h-4" />
        </button>
    @endif
</div>
