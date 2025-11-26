<?php if (! $__env->hasRenderedOnce('a81d8f06-3588-453f-bbac-611653687670')): $__env->markAsRenderedOnce('a81d8f06-3588-453f-bbac-611653687670');
$__env->startPush('styles'); ?>
    <style>
        [data-erp-table-wrapper] {
            --dt-border-color: rgba(148, 163, 184, 0.25);
            --dt-border-color-strong: rgba(148, 163, 184, 0.45);
            --dt-bg-muted: #f8fafc;
            --dt-primary-color: var(--color-primary, var(--primary-color, #2563eb));
            --dt-primary-rgb: var(--color-primary-rgb, var(--primary-rgb, 37 99 235));
            --dt-header-bg: rgb(var(--dt-primary-rgb));
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

        /* Font Size Settings for Tables */
        body.small table[data-erp-table],
        body.small table[data-erp-table] td,
        body.small table[data-erp-table] tbody td {
            font-size: 0.75rem !important; /* 12px */
        }

        body.medium table[data-erp-table],
        body.medium table[data-erp-table] td,
        body.medium table[data-erp-table] tbody td {
            font-size: 0.875rem !important; /* 14px */
        }

        body.large table[data-erp-table],
        body.large table[data-erp-table] td,
        body.large table[data-erp-table] tbody td {
            font-size: 1rem !important; /* 16px */
        }

        body.extra-large table[data-erp-table],
        body.extra-large table[data-erp-table] td,
        body.extra-large table[data-erp-table] tbody td {
            font-size: 1.125rem !important; /* 18px */
        }

        /* Font Size for Regular DataTables */
        body.small table.dataTable,
        body.small table.dataTable td,
        body.small table.dataTable tbody td {
            font-size: 0.75rem !important; /* 12px */
        }

        body.medium table.dataTable,
        body.medium table.dataTable td,
        body.medium table.dataTable tbody td {
            font-size: 0.875rem !important; /* 14px */
        }

        body.large table.dataTable,
        body.large table.dataTable td,
        body.large table.dataTable tbody td {
            font-size: 1rem !important; /* 16px */
        }

        body.extra-large table.dataTable,
        body.extra-large table.dataTable td,
        body.extra-large table.dataTable tbody td {
            font-size: 1.125rem !important; /* 18px */
        }

        /* Font Size for Regular DataTables Headers */
        body.small table.dataTable thead th {
            font-size: 0.625rem !important; /* 10px */
        }

        body.medium table.dataTable thead th {
            font-size: 0.7rem !important; /* 11.2px */
        }

        body.large table.dataTable thead th {
            font-size: 0.75rem !important; /* 12px */
        }

        body.extra-large table.dataTable thead th {
            font-size: 0.875rem !important; /* 14px */
        }

        /* Font Size for All Tables (fallback) */
        body.small table,
        body.small table td,
        body.small table tbody td {
            font-size: 0.75rem !important; /* 12px */
        }

        body.medium table,
        body.medium table td,
        body.medium table tbody td {
            font-size: 0.875rem !important; /* 14px */
        }

        body.large table,
        body.large table td,
        body.large table tbody td {
            font-size: 1rem !important; /* 16px */
        }

        body.extra-large table,
        body.extra-large table td,
        body.extra-large table tbody td {
            font-size: 1.125rem !important; /* 18px */
        }

        /* Font Size for All Table Headers (fallback) */
        body.small table thead th {
            font-size: 0.625rem !important; /* 10px */
        }

        body.medium table thead th {
            font-size: 0.7rem !important; /* 11.2px */
        }

        body.large table thead th {
            font-size: 0.75rem !important; /* 12px */
        }

        body.extra-large table thead th {
            font-size: 0.875rem !important; /* 14px */
        }

        /* Font Size for Table Headers */
        body.small table[data-erp-table] thead th {
            font-size: 0.625rem !important; /* 10px */
        }

        body.medium table[data-erp-table] thead th {
            font-size: 0.7rem !important; /* 11.2px */
        }

        body.large table[data-erp-table] thead th {
            font-size: 0.75rem !important; /* 12px */
        }

        body.extra-large table[data-erp-table] thead th {
            font-size: 0.875rem !important; /* 14px */
        }

        /* Font Size for Pagination */
        body.small [data-erp-table-wrapper] .datatable-pagination ul.pagination li a,
        body.small [data-erp-table-wrapper] .datatable-pagination ul.pagination li span {
            font-size: 0.75rem !important; /* 12px */
        }

        body.medium [data-erp-table-wrapper] .datatable-pagination ul.pagination li a,
        body.medium [data-erp-table-wrapper] .datatable-pagination ul.pagination li span {
            font-size: 0.875rem !important; /* 14px */
        }

        body.large [data-erp-table-wrapper] .datatable-pagination ul.pagination li a,
        body.large [data-erp-table-wrapper] .datatable-pagination ul.pagination li span {
            font-size: 1rem !important; /* 16px */
        }

        body.extra-large [data-erp-table-wrapper] .datatable-pagination ul.pagination li a,
        body.extra-large [data-erp-table-wrapper] .datatable-pagination ul.pagination li span {
            font-size: 1.125rem !important; /* 18px */
        }

        /* Font Size for Table Info */
        body.small [data-erp-table-wrapper] .datatable-info {
            font-size: 0.75rem; /* 12px */
        }

        body.medium [data-erp-table-wrapper] .datatable-info {
            font-size: 0.875rem; /* 14px */
        }

        body.large [data-erp-table-wrapper] .datatable-info {
            font-size: 1rem; /* 16px */
        }

        body.extra-large [data-erp-table-wrapper] .datatable-info {
            font-size: 1.125rem; /* 18px */
        }

        /* Font Size for Action Buttons */
        body.small [data-erp-table-wrapper] .btn-action {
            font-size: 0.75rem; /* 12px */
            padding: 4px 8px;
        }

        body.medium [data-erp-table-wrapper] .btn-action {
            font-size: 0.875rem; /* 14px */
            padding: 6px 12px;
        }

        body.large [data-erp-table-wrapper] .btn-action {
            font-size: 1rem; /* 16px */
            padding: 8px 16px;
        }

        body.extra-large [data-erp-table-wrapper] .btn-action {
            font-size: 1.125rem; /* 18px */
            padding: 10px 20px;
        }

        table[data-erp-table] thead {
            background: linear-gradient(135deg,
                rgb(var(--dt-primary-rgb) / 0.65),
                rgb(var(--dt-primary-rgb) / 0.35)
            );
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.12);
        }

        @supports (background: color-mix(in srgb, red 50%, transparent)) {
            table[data-erp-table] thead {
                background: linear-gradient(135deg,
                    color-mix(in srgb, var(--dt-primary-color) 75%, transparent),
                    color-mix(in srgb, var(--dt-primary-color) 40%, transparent)
                );
            }
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
            width: 1.9rem;
            height: 1.9rem;
            min-width: 1.9rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.875rem;
            color: #64748b;
            text-decoration: none;
            transition: color 140ms ease, background-color 140ms ease, transform 0.2s ease, box-shadow 0.2s ease;
            padding: 0;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            line-height: 1;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button a {
            color: #64748b;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button:not(.disabled):hover a {
            color: rgb(var(--dt-primary-rgb));
            background-color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb) 12%, #ffffff);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
            border-color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb), transparent 80%);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button:not(.previous):not(.next) a {
            width: 1.9rem;
            height: 1.9rem;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a {
            width: 1.9rem;
            height: 1.9rem;
            --btn-surface: color-mix(in oklch, var(--dt-primary-rgb, #2563eb) 20%, #ffffff);
            --btn-border: color-mix(in oklch, var(--dt-primary-rgb, #2563eb), transparent 80%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 9999px;
            border: 1px solid var(--btn-border);
            background-color: var(--btn-surface);
            color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb), black 20%);
            font-weight: 600;
            font-size: 0.875rem;
            line-height: 1;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 15px 25px rgba(37, 99, 235, 0.12);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a:focus-visible {
            outline: 2px solid color-mix(in oklch, var(--dt-primary-rgb, #2563eb), transparent 60%);
            outline-offset: 3px;
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
            background-color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb) 15%, #ffffff);
            border: 1px solid color-mix(in oklch, var(--dt-primary-rgb, #2563eb), transparent 85%);
            color: transparent;
            font-size: 0;
            position: relative;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a::after,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            border-top: 3px solid #374151;
            border-right: 3px solid #374151;
            transform: translate(-50%, -50%) rotate(45deg);
            transition: border-color 140ms ease;
            z-index: 10;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a::after {
            transform: translate(-50%, -50%) rotate(-135deg);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a:hover,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a:hover {
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.12);
            background-color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb) 20%, #ffffff);
            border-color: color-mix(in oklch, var(--dt-primary-rgb, #2563eb), transparent 75%);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a:hover::after,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a:hover::after {
            border-top: 3px solid #1f2937;
            border-right: 3px solid #1f2937;
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

        /* Unified Button Animations for DataTable Actions */
        [data-erp-table-wrapper] .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        [data-erp-table-wrapper] .btn-action::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        [data-erp-table-wrapper] .btn-action:hover::before {
            width: 200px;
            height: 200px;
        }

        [data-erp-table-wrapper] .btn-action svg {
            transition: transform 0.3s ease;
            width: 16px;
            height: 16px;
        }

        [data-erp-table-wrapper] .btn-action:hover svg {
            transform: scale(1.1) rotate(5deg);
        }

        [data-erp-table-wrapper] .btn-primary {
            background: rgb(var(--dt-primary-rgb));
            color: white;
        }

        [data-erp-table-wrapper] .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(var(--dt-primary-rgb), 0.3);
        }

        [data-erp-table-wrapper] .btn-secondary {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #374151;
        }

        [data-erp-table-wrapper] .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: #e5e7eb;
        }

        [data-erp-table-wrapper] .btn-danger {
            background: #ef4444;
            color: white;
        }

        [data-erp-table-wrapper] .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        [data-erp-table-wrapper] .btn-warning {
            background: #f59e0b;
            color: white;
        }

        [data-erp-table-wrapper] .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
        }

        /* Unified Status Badge Styling */
        [data-erp-table-wrapper] .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s ease;
        }

        [data-erp-table-wrapper] .status-badge svg {
            width: 14px;
            height: 14px;
            animation: status-badge-pulse 2s ease-in-out infinite;
        }

        [data-erp-table-wrapper] .status-active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        [data-erp-table-wrapper] .status-inactive {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        [data-erp-table-wrapper] .status-pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        [data-erp-table-wrapper] .status-suspended {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);
        }

        @keyframes status-badge-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
    </style>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/datatable/theme.blade.php ENDPATH**/ ?>