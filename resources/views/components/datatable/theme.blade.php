@pushOnce('styles')
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
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border: 1px solid rgba(var(--color-primary), 0.18);
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--dt-text-color);
            background-color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li a:hover {
            background-color: rgba(var(--color-primary), 0.08);
            border-color: rgba(var(--color-primary), 0.32);
            color: rgb(var(--color-primary));
            box-shadow: 0 10px 24px rgba(var(--color-primary), 0.15);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.active a {
            background-color: rgb(var(--color-primary));
            border-color: rgb(var(--color-primary));
            color: #ffffff;
            box-shadow: 0 16px 30px rgba(var(--color-primary), 0.35);
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
            width: 36px;
            height: 36px;
            padding: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: 56%;
            text-indent: -9999px;
            overflow: hidden;
            font-size: 0;
            line-height: 0;
            background-color: rgba(var(--color-primary), 0.08);
            border-color: rgba(var(--color-primary), 0.18);
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.first a {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' stroke='%230f172a' stroke-width='1.15' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='11 17 6 12 11 7'%3E%3C/polyline%3E%3Cpolyline points='18 17 13 12 18 7'%3E%3C/polyline%3E%3C/svg%3E");
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.previous a {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' stroke='%230f172a' stroke-width='1.15' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='15 18 9 12 15 6'%3E%3C/polyline%3E%3C/svg%3E");
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.next a {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' stroke='%230f172a' stroke-width='1.15' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='9 18 15 12 9 6'%3E%3C/polyline%3E%3C/svg%3E");
        }

        [data-erp-table-wrapper] .datatable-pagination ul.pagination li.paginate_button.last a {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24' stroke='%230f172a' stroke-width='1.15' fill='none' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='13 17 18 12 13 7'%3E%3C/polyline%3E%3Cpolyline points='6 17 11 12 6 7'%3E%3C/polyline%3E%3C/svg%3E");
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
@endPushOnce
