<div class="flex items-center justify-center gap-2">
    <a
        href="{{ route('warehouse.material-requests.show', $pr) }}"
        class="text-primary hover:text-primary/80"
        title="View details"
    >
        <x-base.lucide icon="Eye" class="w-4 h-4" />
    </a>
    <button type="button" class="text-danger hover:text-danger/80" title="Delete" disabled>
        <x-base.lucide icon="Trash2" class="w-4 h-4" />
    </button>
</div>
