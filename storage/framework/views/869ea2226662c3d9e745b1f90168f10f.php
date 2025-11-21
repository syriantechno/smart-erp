<?php
    $isActive = $isActive ?? false;
?>

<span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold <?php echo e($isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600'); ?>">
    <i data-lucide="<?php echo e($isActive ? 'check-circle' : 'pause-circle'); ?>" class="w-3.5 h-3.5"></i>
    <?php echo e($isActive ? 'Active' : 'Inactive'); ?>

</span>
<?php /**PATH D:\laravel\smart-erp\resources\views/approval-system/templates/partials/status.blade.php ENDPATH**/ ?>