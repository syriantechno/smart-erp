<?php
    $levels = $levels ?? [];
?>

<div class="flex items-center gap-2 justify-center">
    <?php $__empty_1 = true; $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
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
        ?>
        <div class="flex items-center gap-2">
            <div
                class="w-3 h-3 rounded-full <?php echo e($dotClass); ?>"
                title="<?php echo e($title); ?>"
            ></div>
            <?php if (! ($loop->last)): ?>
                <div class="w-4 h-px bg-slate-200"></div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <span class="text-xs text-slate-400">—</span>
    <?php endif; ?>
</div>
<?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/material-requests/partials/approval-progress.blade.php ENDPATH**/ ?>