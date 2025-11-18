<?php if (! $__env->hasRenderedOnce('44033855-0b3a-4715-a4c0-e91eb725df9e')): $__env->markAsRenderedOnce('44033855-0b3a-4715-a4c0-e91eb725df9e');
$__env->startPush('styles'); ?>
    <style>
        [data-erp-table-wrapper] {
            --dt-border-color: rgba(148, 163, 184, 0.35);
            --dt-accent-color: rgb(var(--color-primary));
            --dt-text-color: #475569;
            --dt-muted: #64748b;
        }

        table[data-erp-table] {
            border-collapse: separate;
            border-spacing: 0;
            width: 100% !important;
            background-color: #ffffff;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        table[data-erp-table] thead th {
            background-color: #f1f5f9;
            font-weight: 500;
            color: #526280;
            font-size: 0.75rem;
            border-bottom: 1px solid var(--dt-border-color);
            letter-spacing: 0.015em;
        }

        table[data-erp-table] tbody td {
            border-bottom: 1px solid var(--dt-border-color);
            color: var(--dt-text-color);
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        table[data-erp-table] tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.85);
        }

        [data-erp-table-wrapper] .datatable-footer {
            border-top: 1px solid rgba(148, 163, 184, 0.25);
            padding-top: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        [data-erp-table-wrapper] .datatable-info {
            color: var(--dt-muted);
            font-size: 0.875rem;
        }

        [data-erp-table-wrapper] .datatable-pagination {
            display: flex;
            justify-content: flex-end;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
            padding: 0;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li {
            list-style: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 12px;
            border-radius: 0.375rem;
            border: 1px solid transparent;
            font-size: 0.95rem;
            font-weight: 500;
            color: #0f172a;
            background-color: transparent;
            text-decoration: none;
            transition: all 150ms ease;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a:hover {
            background-color: rgba(148, 163, 184, 0.08);
            border-color: rgba(148, 163, 184, 0.45);
            color: #020617;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a {
            background-color: #ffffff;
            border-color: rgba(148, 163, 184, 0.45);
            color: #020617;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.16);
            font-weight: 500;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.disabled a {
            opacity: 0.45;
            cursor: default;
            pointer-events: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.first a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.last a {
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 9999px;
            border-color: transparent;
            background-color: transparent;
            font-size: 1.6rem; /* larger arrows (~3-4x) */
            line-height: 1;
            text-indent: 0;
        }

        @media (max-width: 768px) {
            [data-erp-table-wrapper] .datatable-footer {
                align-items: flex-start;
            }

            [data-erp-table-wrapper] .datatable-pagination {
                justify-content: flex-start;
            }

            [data-erp-table-wrapper] .datatable-pagination ul.pagination {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }
    </style>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/datatable/theme.blade.php ENDPATH**/ ?>