<div class="flex items-center justify-center gap-1 min-w-[80px]">
    @if(auth()->user() && method_exists(auth()->user(), 'hasAnyRole') && auth()->user()->hasAnyRole(['admin', 'warehouse_manager']))
        <x-erp.action-button
            icon="Edit"
            variant="primary"
            title="Adjust Inventory"
            onclick="editInventory({{ $inventory->id }})"
        />
    @else
        <span class="text-slate-300 text-xs">—</span>
    @endif
</div>
