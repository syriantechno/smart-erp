<?php if (! $__env->hasRenderedOnce('936fb543-45bd-4ffb-85eb-0fc77c001f4b')): $__env->markAsRenderedOnce('936fb543-45bd-4ffb-85eb-0fc77c001f4b');
$__env->startPush('styles'); ?>
    <!-- DataTables CSS is now loaded globally in base.blade.php -->
    <style>
        .datatable-default {
            border-collapse: separate;
            border-spacing: 0;
            width: 100% !important;
        }

        .datatable-default thead th,
        .datatable-default tbody td {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0;
        }

        table.dataTable {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .datatable-default thead th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
        }

        .datatable-default tbody td {
            white-space: normal;
            word-break: break-word;
        }

        .datatable-default tbody tr {
            transition: background-color 0.2s ease;
        }

        .datatable-default tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.7);
        }

        .datatable-default tbody tr:last-child td {
            border-bottom: none;
        }

        .datatable-cell-wrap {
            white-space: normal !important;
            word-break: break-word;
        }
    </style>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/components/datatable/styles.blade.php ENDPATH**/ ?>