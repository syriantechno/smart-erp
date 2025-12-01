<div class="flex items-center justify-center gap-2 min-w-[120px]">
    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Eye','title' => 'View Account','variant' => 'info','onclick' => 'viewAccount('.e($account->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Eye','title' => 'View Account','variant' => 'info','onclick' => 'viewAccount('.e($account->id).')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $attributes = $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $component = $__componentOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => 'Pencil','title' => 'Edit Account','variant' => 'warning','onclick' => 'editAccount('.e($account->id).', \''.e(addslashes($account->name)).'\', \''.e($account->type).'\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Pencil','title' => 'Edit Account','variant' => 'warning','onclick' => 'editAccount('.e($account->id).', \''.e(addslashes($account->name)).'\', \''.e($account->type).'\')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $attributes = $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $component = $__componentOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal032f83e94ea583b9c58157a8acdf0a87 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.erp.action-button','data' => ['icon' => ''.e($account->is_active ? 'Slash' : 'CheckCircle').'','title' => ''.e($account->is_active ? 'Deactivate Account' : 'Activate Account').'','variant' => ''.e($account->is_active ? 'danger' : 'success').'','onclick' => 'toggleAccountStatus('.e($account->id).', \''.e(addslashes($account->name)).'\', '.e($account->is_active ? 'true' : 'false').')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('erp.action-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => ''.e($account->is_active ? 'Slash' : 'CheckCircle').'','title' => ''.e($account->is_active ? 'Deactivate Account' : 'Activate Account').'','variant' => ''.e($account->is_active ? 'danger' : 'success').'','onclick' => 'toggleAccountStatus('.e($account->id).', \''.e(addslashes($account->name)).'\', '.e($account->is_active ? 'true' : 'false').')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $attributes = $__attributesOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__attributesOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87)): ?>
<?php $component = $__componentOriginal032f83e94ea583b9c58157a8acdf0a87; ?>
<?php unset($__componentOriginal032f83e94ea583b9c58157a8acdf0a87); ?>
<?php endif; ?>
</div>

<script>
// View Account Details
window.viewAccount = function(id) {
    console.log('Viewing account details:', id);
    showToast('Account details view coming soon', 'info');
};

// Edit Account
window.editAccount = function(id, name, type) {
    console.log('Editing account:', id, name, type);
    showToast('Account editing coming soon', 'info');
};

// Toggle Account Status
window.toggleAccountStatus = function(id, name, isActive) {
    const action = isActive ? 'deactivate' : 'activate';

    const doToggle = () => {
        fetch('/accounting/chart-of-accounts/' + id + '/status', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                is_active: !isActive
            }),
            credentials: 'same-origin'
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                showToast('Account ' + action + 'd successfully', 'success');
                // Reload the table
                if (window.accountTable) {
                    window.accountTable.ajax.reload(null, false);
                }
            } else {
                showToast(data.message || 'Failed to ' + action + ' account', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error toggling account status:', error);
            showToast('An error occurred while updating account status', 'error');
        });
    };

    if (typeof window.confirmAction === 'function') {
        window.confirmAction(
            action.charAt(0).toUpperCase() + action.slice(1) + ' Account',
            'Are you sure you want to ' + action + ' this account?',
            doToggle
        );
    } else {
        doToggle();
    }
};
</script>
<?php /**PATH D:\laravel\smart-erp\resources\views/accounting/chart-of-accounts/partials/actions.blade.php ENDPATH**/ ?>