<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories Export</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; }
        th { background: #f3f4f6; font-weight: bold; }
    </style>
</head>
<body>
<h2>Categories</h2>
<p>Exported at: <?php echo e($exportedAt); ?></p>
<table>
    <thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Parent</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($category->code); ?></td>
            <td><?php echo e($category->name); ?></td>
            <td><?php echo e($category->parent?->name ?? 'Root'); ?></td>
            <td><?php echo e($category->description); ?></td>
            <td><?php echo e($category->is_active ? 'Active' : 'Inactive'); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</body>
</html>
<?php /**PATH D:\laravel\smart-erp\resources\views/warehouse/categories/export_pdf.blade.php ENDPATH**/ ?>