<div class="flex items-center justify-center gap-2">
    <button 
        type="button"
        onclick="viewPurchaseOrder(<?php echo e($po->id); ?>)"
        class="btn-tonal btn-tonal--info btn-tonal--icon"
        title="View"
    >
        <i data-lucide="eye" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="editPurchaseOrder(<?php echo e($po->id); ?>)"
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        title="Edit"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    
    <button 
        type="button"
        onclick="deletePurchaseOrder(<?php echo e($po->id); ?>)"
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        title="Delete"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/purchase-orders/partials/actions.blade.php ENDPATH**/ ?>