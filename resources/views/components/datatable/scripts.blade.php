@pushOnce('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
    <script>
        window.initDataTable = function (selector, options = {}) {
            const jq = window.jQuery || window.$;

            if (!jq) {
                console.error('jQuery failed to load. DataTables will not be initialised.');
                return null;
            }

            if (typeof jq.fn === 'undefined' || typeof jq.fn.DataTable === 'undefined') {
                console.error('DataTables plugin failed to load.');
                return null;
            }

            const defaultOptions = {
                processing: true,
                serverSide: true,
                language: {
                    emptyTable: 'No data available in table',
                    processing: 'Loading...'
                },
                responsive: true,
                stripeClasses: ['odd:bg-white', 'even:bg-slate-50/60'],
                createdRow: function (row) {
                    jq(row).addClass('intro-y');
                }
            };

            const mergedOptions = jq.extend(true, {}, defaultOptions, options);
            return jq(selector).DataTable(mergedOptions);
        };
    </script>
@endPushOnce
