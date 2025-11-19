<?php if (! $__env->hasRenderedOnce('420782ff-bcd5-4cf8-b7d4-f6e37dc7b578')): $__env->markAsRenderedOnce('420782ff-bcd5-4cf8-b7d4-f6e37dc7b578');
$__env->startPush('scripts'); ?>
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
                pagingType: 'full_numbers',
                language: {
                    emptyTable: 'No data available in table',
                    processing: 'Loading...',
                    paginate: {
                        first: '«',
                        previous: '‹',
                        next: '›',
                        last: '»'
                    }
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
            const refreshIcons = function () {
                try {
                    if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                        lucide.createIcons({ 'stroke-width': 1.5, nameAttr: 'data-lucide' });
                        return;
                    }
                    if (typeof window.Lucide !== 'undefined' && typeof window.Lucide.createIcons === 'function') {
                        window.Lucide.createIcons();
                    }
                } catch (e) {
                    console.error('Lucide icon refresh failed:', e);
                }
            };

            try {
                jq(selector).on('draw.dt', function () {
                    refreshIcons();
                });

                // Initial call so icons render on first load as well
                refreshIcons();
            } catch (e) {
                console.error('Failed to attach Lucide draw hook:', e);
            }

            return table;
        };
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/datatable/scripts.blade.php ENDPATH**/ ?>