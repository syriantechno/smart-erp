@pushOnce('styles')
    <style>
        [data-erp-table-wrapper] {
            --dt-border-color: rgba(148, 163, 184, 0.25);
            --dt-border-color-strong: rgba(148, 163, 184, 0.45);
            --dt-bg-muted: #f8fafc;
            --dt-header-bg: #1d4ed8;
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
        }

        table[data-erp-table] thead {
            background-color: var(--dt-header-bg);
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
            font-size: 0.9rem;
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        table[data-erp-table] tbody td:first-child {
            border-left: 4px solid transparent;
        }

        table[data-erp-table] tbody tr:hover td:first-child {
            border-left-color: rgba(59, 130, 246, 0.45);
        }

        [data-erp-table-wrapper] .datatable-footer {
            border-top: 1px solid var(--dt-border-color);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            background-color: #ffffff;
        }

        [data-erp-table-wrapper] .datatable-info {
            color: var(--dt-muted);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        [data-erp-table-wrapper] .datatable-pagination {
            display: flex;
            justify-content: flex-end;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
            background-color: #f8fafc;
            border-radius: 999px;
            border: 1px solid var(--dt-border-color);
            padding: 0.35rem 0.65rem;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li {
            list-style: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid transparent;
            color: #475569;
            font-weight: 600;
            text-decoration: none;
            transition: all 160ms ease;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a:hover {
            border-color: var(--dt-border-color-strong);
            color: #0f172a;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a {
            border-color: transparent;
            color: #0f172a;
            background: #ffffff;
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.12);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.disabled a {
            opacity: 0.35;
            pointer-events: none;
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.first a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a,
        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.last a {
            min-width: 32px;
            font-size: 1rem;
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
@endPushOnce
