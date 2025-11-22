<!-- Journal Entries Modal -->
<?php if (isset($component)) { $__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.index','data' => ['id' => 'journal-entries-modal','size' => 'xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'journal-entries-modal','size' => 'xl']); ?>
    <?php if (isset($component)) { $__componentOriginal231386b9e8f52ce181634663542c77d5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal231386b9e8f52ce181634663542c77d5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.panel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <!-- Header -->
        <?php if (isset($component)) { $__componentOriginalcff2bb8681c24921e5a983f69e36057e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcff2bb8681c24921e5a983f69e36057e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.title','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'BookOpen','class' => 'w-5 h-5 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'BookOpen','class' => 'w-5 h-5 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
            Journal Entries
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcff2bb8681c24921e5a983f69e36057e)): ?>
<?php $attributes = $__attributesOriginalcff2bb8681c24921e5a983f69e36057e; ?>
<?php unset($__attributesOriginalcff2bb8681c24921e5a983f69e36057e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcff2bb8681c24921e5a983f69e36057e)): ?>
<?php $component = $__componentOriginalcff2bb8681c24921e5a983f69e36057e; ?>
<?php unset($__componentOriginalcff2bb8681c24921e5a983f69e36057e); ?>
<?php endif; ?>

        <!-- Modal Body -->
        <div class="px-5 py-3">
            <div class="space-y-4">
                <!-- Statistics -->
                <div class="grid grid-cols-12 gap-4 mb-6">
                    <div class="col-span-12 md:col-span-3">
                        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600" id="total-entries">0</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Total Entries</div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-green-600" id="posted-entries">0</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Posted</div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600" id="draft-entries">0</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Draft</div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-3">
                        <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-red-600" id="unbalanced-entries">0</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Unbalanced</div>
                        </div>
                    </div>
                </div>

                <!-- Add Entry Button -->
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Journal Entries</h3>
                    <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['variant' => 'primary','dataTwToggle' => 'modal','dataTwTarget' => '#add-journal-entry-modal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','data-tw-toggle' => 'modal','data-tw-target' => '#add-journal-entry-modal']); ?>
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Plus','class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Plus','class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
                        Add Entry
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
                </div>

                <!-- Journal Entries Table -->
                <div class="overflow-x-auto">
                    <table id="journal-entries-table" class="datatable-default w-full min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">#</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Reference</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Date</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Description</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Status</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Debit</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap">Credit</th>
                                <th class="font-medium px-5 py-3 border-b-2 dark:border-darkmode-300 whitespace-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php if (isset($component)) { $__componentOriginal5bb3458f4debbed77859911966de4e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bb3458f4debbed77859911966de4e9b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php if (isset($component)) { $__componentOriginale00eb601fbe667f0da582732d70c41c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale00eb601fbe667f0da582732d70c41c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.button.index','data' => ['type' => 'button','variant' => 'secondary','xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'secondary','x-on:click' => '$dispatch(\'close\')']); ?>
                Close
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $attributes = $__attributesOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__attributesOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale00eb601fbe667f0da582732d70c41c5)): ?>
<?php $component = $__componentOriginale00eb601fbe667f0da582732d70c41c5; ?>
<?php unset($__componentOriginale00eb601fbe667f0da582732d70c41c5); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bb3458f4debbed77859911966de4e9b)): ?>
<?php $attributes = $__attributesOriginal5bb3458f4debbed77859911966de4e9b; ?>
<?php unset($__attributesOriginal5bb3458f4debbed77859911966de4e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bb3458f4debbed77859911966de4e9b)): ?>
<?php $component = $__componentOriginal5bb3458f4debbed77859911966de4e9b; ?>
<?php unset($__componentOriginal5bb3458f4debbed77859911966de4e9b); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal231386b9e8f52ce181634663542c77d5)): ?>
<?php $attributes = $__attributesOriginal231386b9e8f52ce181634663542c77d5; ?>
<?php unset($__attributesOriginal231386b9e8f52ce181634663542c77d5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal231386b9e8f52ce181634663542c77d5)): ?>
<?php $component = $__componentOriginal231386b9e8f52ce181634663542c77d5; ?>
<?php unset($__componentOriginal231386b9e8f52ce181634663542c77d5); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd)): ?>
<?php $attributes = $__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd; ?>
<?php unset($__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd)): ?>
<?php $component = $__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd; ?>
<?php unset($__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd); ?>
<?php endif; ?>

<script>
// Journal Entries Modal
document.addEventListener('DOMContentLoaded', function() {
    // Initialize journal entries table when modal opens
    const journalModal = document.getElementById('journal-entries-modal');
    if (journalModal) {
        journalModal.addEventListener('show', function() {
            initializeJournalEntriesTable();
        });
    }

    function initializeJournalEntriesTable() {
        if (window.journalEntriesTable) {
            window.journalEntriesTable.destroy();
        }

        window.journalEntriesTable = window.initDataTable('#journal-entries-table', {
            ajax: {
                url: '<?php echo e(route("accounting.journal-entries.datatable")); ?>',
                type: 'GET',
                error: function (xhr, textStatus, error) {
                    console.error('Journal Entries AJAX error:', textStatus, error, xhr.responseText);
                }
            },
            pageLength: 10,
            lengthChange: false,
            searching: false,
            order: [[2, 'desc']],
            dom: "t<'datatable-footer flex flex-col md:flex-row md:items-center md:justify-between mt-5 gap-4'<'datatable-info text-slate-500'i><'datatable-pagination'p>>",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center font-medium', orderable: false },
                { data: 'reference_number', name: 'reference_number', className: 'px-5 py-3 border-b dark:border-darkmode-300 font-medium text-slate-700 whitespace-nowrap' },
                { data: 'entry_date', name: 'entry_date', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap' },
                { data: 'description', name: 'description', className: 'px-5 py-3 border-b dark:border-darkmode-300 datatable-cell-wrap' },
                {
                    data: 'status_badge',
                    name: 'status_badge',
                    render: function (value) {
                        return value;
                    }
                },
                { data: 'total_debit_formatted', name: 'total_debit_formatted', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap text-green-600 font-medium' },
                { data: 'total_credit_formatted', name: 'total_credit_formatted', className: 'px-5 py-3 border-b dark:border-darkmode-300 whitespace-nowrap text-red-600 font-medium' },
                {
                    data: 'actions',
                    name: 'actions',
                    className: 'px-5 py-3 border-b dark:border-darkmode-300 text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            rawColumns: ['status_badge', 'actions'],
            drawCallback: function () {
                if (typeof window.Lucide !== 'undefined') {
                    window.Lucide.createIcons();
                }
                updateJournalEntriesStats();
            }
        });
    }

    function updateJournalEntriesStats() {
        fetch('<?php echo e(route("accounting.journal-entries.stats")); ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success && data.data) {
                const stats = data.data;
                document.getElementById('total-entries').textContent = stats.total_entries || 0;
                document.getElementById('posted-entries').textContent = stats.posted_entries || 0;
                document.getElementById('draft-entries').textContent = stats.draft_entries || 0;
                document.getElementById('unbalanced-entries').textContent = stats.unbalanced_entries || 0;
            }
        })
        .catch(function(error) {
            console.error('Error loading journal entries stats:', error);
        });
    }
});
</script>
<?php /**PATH E:\ERP System\Source\resources\views/accounting/journal-entries/modals/list.blade.php ENDPATH**/ ?>