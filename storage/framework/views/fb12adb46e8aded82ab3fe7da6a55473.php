<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background-color: #f3f4f6; font-weight: 600; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>Customers Report</h1>
    <p>Exported at: <?php echo e($exportedAt); ?></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
                <th>Email</th>
                <th>Phone</th>
                <th class="text-right">Credit Limit</th>
                <th>Status</th>
                <th>Account</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td><?php echo e($customer->code); ?></td>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e(ucfirst($customer->customer_type)); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td><?php echo e($customer->phone); ?></td>
                    <td class="text-right"><?php echo e(number_format($customer->credit_limit ?? 0, 2)); ?></td>
                    <td><?php echo e(ucfirst($customer->status)); ?></td>
                    <td>
                        <?php if($customer->account): ?>
                            <?php echo e($customer->account->code); ?> - <?php echo e($customer->account->name); ?>

                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\laravel\smart-erp\resources\views/customers/export_pdf.blade.php ENDPATH**/ ?>