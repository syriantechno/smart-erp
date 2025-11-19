<div class="flex items-center justify-center gap-2">
    <button 
        type="button"
        onclick="viewPurchaseOrder({{ $po->id }})"
        class="btn-tonal btn-tonal--info btn-tonal--icon"
        title="View"
    >
        <i data-lucide="eye" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="editPurchaseOrder({{ $po->id }})"
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        title="Edit"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="deletePurchaseOrder({{ $po->id }})"
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        title="Delete"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
