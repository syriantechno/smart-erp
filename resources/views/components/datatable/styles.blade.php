@pushOnce('styles')
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
@endPushOnce
