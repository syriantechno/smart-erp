<div class="flex items-center justify-center gap-2">
    <button
        class="btn-tonal btn-tonal--warning btn-tonal--icon"
        onclick="editMaterial(<?php echo e($material->id); ?>)"
        title="Edit Material"
    >
        <i data-lucide="edit" class="w-4 h-4"></i>
    </button>
    <button
        class="btn-tonal btn-tonal--danger btn-tonal--icon"
        onclick="deleteMaterial(<?php echo e($material->id); ?>, '<?php echo e(addslashes($material->name)); ?>')"
        title="Delete Material"
    >
        <i data-lucide="trash-2" class="w-4 h-4"></i>
    </button>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/materials/partials/actions.blade.php ENDPATH**/ ?>