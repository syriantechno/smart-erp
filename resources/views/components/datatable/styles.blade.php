@pushOnce('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css" />
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
