@pushOnce('scripts')
    <!-- DataTables JS is now loaded globally in base.blade.php -->
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
            const table = jq(selector).DataTable(mergedOptions);

            // Global hook: re-init Lucide icons after every draw for all tables
            try {
                jq(selector).on('draw.dt', function () {
                    if (typeof window.Lucide !== 'undefined' && typeof window.Lucide.createIcons === 'function') {
                        window.Lucide.createIcons();
                    }
                });

                // Initial call so icons render on first load as well
                if (typeof window.Lucide !== 'undefined' && typeof window.Lucide.createIcons === 'function') {
                    window.Lucide.createIcons();
                }
            } catch (e) {
                console.error('Failed to attach Lucide draw hook:', e);
            }

            return table;
        };
    </script>
@endPushOnce
