<?php if (! $__env->hasRenderedOnce('18707767-a9f4-4bd6-ad92-7907ed4f4e84')): $__env->markAsRenderedOnce('18707767-a9f4-4bd6-ad92-7907ed4f4e84');
$__env->startPush('styles'); ?>
    <style>
        [data-erp-table-wrapper] {
            --dt-border-color: rgba(148, 163, 184, 0.25);
            --dt-border-color-strong: rgba(148, 163, 184, 0.45);
            --dt-bg-muted: #f8fafc;
            --dt-primary-rgb: var(--primary-rgb, 37, 99, 235);
            --dt-header-bg: rgba(var(--dt-primary-rgb), 1);
            --dt-text-color: #1f2933;
            --dt-muted: #64748b;
        }

        [data-erp-table-wrapper] {
            display: block;
            border-radius: 1rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            margin-top: 1.25rem;
            background-color: #ffffff;
        }

        table.dataTable,
        table[data-erp-table] {
            border-collapse: collapse;
            width: 100% !important;
            background-color: transparent;
            border-radius: inherit;
            overflow: hidden;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            font-family: 'Tajawal', 'Cairo', 'IBM Plex Sans Arabic', 'Noto Sans Arabic', 'Roboto', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-feature-settings: "kern";
        }

        table[data-erp-table] thead {
            background: linear-gradient(135deg,
                rgba(var(--dt-primary-rgb), 0.6),
                rgba(var(--dt-primary-rgb), 0.35)
            );
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.12);
        }

        table[data-erp-table] thead th {
            background-color: transparent;
            position: sticky;
            top: 0;
            z-index: 5;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            color: #f8fafc;
            border-bottom: 1px solid var(--dt-border-color);
            padding-top: 0.9rem !important;
            padding-bottom: 0.9rem !important;
        }

        table[data-erp-table] thead th:first-child {
            border-top-left-radius: 1rem;
        }

        table[data-erp-table] thead th:last-child {
            border-top-right-radius: 1rem;
        }

        table[data-erp-table] tbody tr {
            transition: background 180ms ease, transform 180ms ease;
        }

        table[data-erp-table] tbody tr:nth-child(even) {
            background-color: rgba(248, 250, 252, 0.65);
        }

        table[data-erp-table] tbody tr:hover {
            background-color: rgba(226, 232, 240, 0.65);
            transform: translateY(-1px);
        }

        table[data-erp-table] tbody td {
            border-bottom: 1px solid var(--dt-border-color);
            color: var(--dt-text-color);
            font-size: 1rem;
            line-height: 1.8;
            padding-top: 1.05rem;
            padding-bottom: 1.05rem;
        }

        table[data-erp-table] tbody td:first-child {
            border-left: 4px solid transparent;
        }

        table[data-erp-table] tbody tr:hover td:first-child {
            border-left-color: rgba(var(--dt-primary-rgb), 0.45);
        }

        [data-erp-table-wrapper] .datatable-footer {
            border-top: 1px solid var(--dt-border-color);
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            flex-wrap: wrap;
            background-color: #ffffff;
        }

        @media (min-width: 768px) {
            [data-erp-table-wrapper] .datatable-footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        [data-erp-table-wrapper] .datatable-info {
            color: #94a3b8;
            font-size: 0.95rem;
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
            flex: 1 1 auto;
            min-width: 220px;
            text-align: left;
            line-height: 1.5;
        }

        [data-erp-table-wrapper] .datatable-pagination {
            display: flex;
            justify-content: flex-end;
            width: auto;
            flex: 0 1 auto;
            align-self: flex-start;
        }

        @media (max-width: 767px) {
            [data-erp-table-wrapper] .datatable-pagination {
                width: 100%;
                justify-content: center;
            }
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.95rem;
            margin: 0;
            border-radius: 999px;
            background-color: #f4f6fb;
            border: 1px solid rgba(148, 163, 184, 0.3);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li {
            list-style: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 1.75rem;
            height: 1.75rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            color: #94a3b8;
            text-decoration: none;
            transition: color 140ms ease, background-color 140ms ease;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button a {
            color: #64748b;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button:not(.disabled):hover a {
            color: rgb(var(--dt-primary-rgb));
            background-color: rgba(var(--dt-primary-rgb), 0.08);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button:not(.previous):not(.next) a {
            width: 1.75rem;
            height: 1.75rem;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a {
            width: 2.1rem;
            height: 2.1rem;
            background-color: rgb(var(--dt-primary-rgb));
            color: #ffffff;
            box-shadow: 0 10px 20px rgba(var(--dt-primary-rgb), 0.25);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.disabled a {
            opacity: 0.35;
            pointer-events: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.ellipsis,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.ellipsis span {
            color: #c0cadb;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a {
            min-width: 1.9rem;
            height: 1.9rem;
            padding: 0;
            border-radius: 999px;
            background: transparent;
            border: 1px solid rgba(148, 163, 184, 0.3);
            color: transparent;
            font-size: 0;
            position: relative;
            box-shadow: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a::after,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a::after {
            content: '';
            width: 10px;
            height: 10px;
            border-top: 2px solid #94a3b8;
            border-right: 2px solid #94a3b8;
            transform: rotate(45deg);
            transition: border-color 140ms ease;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a::after {
            transform: rotate(-135deg);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a:hover,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a:hover {
            border-color: rgba(var(--dt-primary-rgb), 0.35);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a:hover::after,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a:hover::after {
            border-color: rgb(var(--dt-primary-rgb));
        }

        @media (max-width: 1024px) {
            table[data-erp-table] thead {
                position: sticky;
                top: 0;
            }
        }

        @media (max-width: 768px) {
            [data-erp-table-wrapper] .datatable-footer {
                padding: 1.25rem;
            }

            [data-erp-table-wrapper] .datatable-pagination {
                justify-content: flex-start;
            }

            [data-erp-table-wrapper] .datatable-pagination ul.pagination {
                flex-wrap: wrap;
                gap: 0.35rem;
            }
        }
    </style>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/datatable/theme.blade.php ENDPATH**/ ?>