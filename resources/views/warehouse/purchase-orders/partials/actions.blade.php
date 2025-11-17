<div class="flex items-center justify-center gap-2">
    <button 
        type="button"
        onclick="viewPurchaseOrder({{ $po->id }})"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors"
        title="View"
    >
        <i data-lucide="eye" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="editPurchaseOrder({{ $po->id }})"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-info text-white hover:bg-info/90 transition-colors"
        title="Edit"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="deletePurchaseOrder({{ $po->id }})"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-danger text-white hover:bg-danger/90 transition-colors"
        title="Delete"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
