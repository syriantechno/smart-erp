

<?php $__env->startSection('subhead'); ?>
    <title>Approval Templates - <?php echo e(config('app.name')); ?></title>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.datatable.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Approval Templates</h2>
        <button
            type="button"
            class="btn btn-primary"
            onclick="openCreateModal()"
        >
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
            New Template
        </button>
    </div>

    <?php echo $__env->make('components.global-notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="intro-y box mt-5">
        <div class="p-5">
            <table id="templates-table" class="display table w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Levels</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <?php if (isset($component)) { $__componentOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalad7e71e98d6bc7c4deec90df8ba81dfd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.index','data' => ['id' => 'template-modal','size' => 'xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'template-modal','size' => 'xl']); ?>
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
                <h2 id="modal-title" class="text-lg font-medium">Create Template</h2>
                <button type="button" class="text-slate-400" data-tw-dismiss="modal">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'X','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'X','class' => 'w-4 h-4']); ?>
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
                </button>
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

            <?php if (isset($component)) { $__componentOriginalddd13be32d44d36d335ddd0d0d16868a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalddd13be32d44d36d335ddd0d0d16868a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.dialog.description','data' => ['class' => 'p-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.dialog.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'p-5']); ?>
                <form id="template-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="template-id" name="id">

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name -->
                        <div>
                            <label class="form-label">Template Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="form-label">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="material_request">Material Request</option>
                                <option value="invoice">Invoice</option>
                                <option value="purchase_order">Purchase Order</option>
                                <option value="expense">Expense</option>
                                <option value="leave_request">Leave Request</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="form-label">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Levels -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="form-label mb-0">Approval Levels</label>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addLevel()">
                                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Plus','class' => 'w-3 h-3 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Plus','class' => 'w-3 h-3 mr-1']); ?>
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
                                    Add Level
                                </button>
                            </div>
                            <div id="levels-container" class="space-y-3">
                                <!-- Levels will be added here -->
                            </div>
                        </div>

                        <!-- Active -->
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input" checked>
                            <label for="is_active" class="form-check-label ml-2">Active</label>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end gap-2">
                        <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </form>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalddd13be32d44d36d335ddd0d0d16868a)): ?>
<?php $attributes = $__attributesOriginalddd13be32d44d36d335ddd0d0d16868a; ?>
<?php unset($__attributesOriginalddd13be32d44d36d335ddd0d0d16868a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalddd13be32d44d36d335ddd0d0d16868a)): ?>
<?php $component = $__componentOriginalddd13be32d44d36d335ddd0d0d16868a; ?>
<?php unset($__componentOriginalddd13be32d44d36d335ddd0d0d16868a); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const jq = window.jQuery || window.$;
    if (!jq) {
        console.error('jQuery not available on approval templates page.');
        return;
    }

    let levelCounter = 0;
    let table;

    jq(function() {
        // Initialize DataTable
        table = window.erpCrud.initDataTable({
            tableSelector: '#templates-table',
            ajaxUrl: '<?php echo e(route("approval-system.templates.datatable")); ?>',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'levels_count', name: 'levels_count', orderable: false },
                { data: 'status', name: 'is_active' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Form submit
        jq('#template-form').on('submit', function(e) {
            e.preventDefault();

            const formData = {
                id: jq('#template-id').val(),
                name: jq('#name').val(),
                type: jq('#type').val(),
                description: jq('#description').val(),
                is_active: jq('#is_active').is(':checked') ? 1 : 0,
                levels: getLevelsData()
            };

            const url = formData.id 
                ? '<?php echo e(route("approval-system.templates.update", ":id")); ?>'.replace(':id', formData.id)
                : '<?php echo e(route("approval-system.templates.store")); ?>';

            const method = formData.id ? 'PUT' : 'POST';

            jq.ajax({
                url: url,
                method: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Success!', response.message, 'success');
                        table.ajax.reload();
                        jq('[data-tw-dismiss="modal"]').click();
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                }
            });
        });
    });

    window.openCreateModal = function () {
        jq('#modal-title').text('Create Template');
        jq('#template-form')[0].reset();
        jq('#template-id').val('');
        jq('#levels-container').empty();
        levelCounter = 0;
        addLevel(); // Add first level
        tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
    };

    window.editTemplate = function (id) {
        jq.get('<?php echo e(route("approval-system.templates.show", ":id")); ?>'.replace(':id', id), function(data) {
            jq('#modal-title').text('Edit Template');
            jq('#template-id').val(data.id);
            jq('#name').val(data.name);
            jq('#type').val(data.type);
            jq('#description').val(data.description);
            jq('#is_active').prop('checked', data.is_active);

            jq('#levels-container').empty();
            levelCounter = 0;

            if (data.levels && data.levels.length > 0) {
                data.levels.forEach(level => {
                    addLevel(level);
                });
            } else {
                addLevel();
            }

            tailwind.Modal.getOrCreateInstance(document.querySelector('#template-modal')).show();
        });
    };

    window.addLevel = function (levelData = null) {
        levelCounter++;
        const levelHtml = `
            <div class="level-item border rounded p-3" data-level="${levelCounter}">
                <div class="flex items-start gap-3">
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm">Level Name</label>
                            <input type="text" class="form-control level-name" placeholder="e.g., Department Manager" 
                                   value="${levelData?.name || 'Level ' + levelCounter}">
                        </div>
                        <div>
                            <label class="text-sm">Approver</label>
                            <select class="form-control level-approver" required>
                                <option value="">Select User</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" ${levelData?.approver_id == <?php echo e($user->id); ?> ? 'selected' : ''}>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger mt-6" onclick="removeLevel(${levelCounter})">
                        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Trash2','class' => 'w-3 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','class' => 'w-3 h-3']); ?>
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
                    </button>
                </div>
            </div>
        `;
        jq('#levels-container').append(levelHtml);
    };

    window.removeLevel = function (id) {
        jq(`.level-item[data-level="${id}"]`).remove();
    };

    function getLevelsData() {
        const levels = [];
        let levelNum = 1;

        jq('.level-item').each(function() {
            levels.push({
                level: levelNum++,
                name: jq(this).find('.level-name').val(),
                approver_id: parseInt(jq(this).find('.level-approver').val()),
                can_reject: true,
                is_required: true
            });
        });

        return levels;
    }

    window.deleteTemplate = function (id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                jq.ajax({
                    url: '<?php echo e(route("approval-system.templates.destroy", ":id")); ?>'.replace(':id', id),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                        }
                    }
                });
            }
        });
    };
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/approval-system/templates/index.blade.php ENDPATH**/ ?>