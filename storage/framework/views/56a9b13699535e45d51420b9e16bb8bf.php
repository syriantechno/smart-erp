<?php if (! $__env->hasRenderedOnce('729bedc3-5a7d-4463-89a7-48a2e8025da7')): $__env->markAsRenderedOnce('729bedc3-5a7d-4463-89a7-48a2e8025da7');
$__env->startPush('styles'); ?>
    <style>
        /* Global Notification Styles */
        #global-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        #global-confirm-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99998;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .toast-wrapper {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15);
            min-width: 320px;
            max-width: 480px;
            position: relative;
            animation: toast-slide-down 0.35s ease-out;
        }

        .confirm-modal-content {
            background-color: white;
            border-radius: 0.75rem;
            padding: 24px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            animation: modal-appear 0.2s ease-out;
        }

        .confirm-modal-header {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .confirm-modal-body {
            margin-bottom: 24px;
        }

        .confirm-modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .toast-message {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        /* Toast Icons */
        .toast-icon-success { color: #22c55e; }
        .toast-icon-error { color: #ef4444; }
        .toast-icon-warning { color: #f59e0b; }
        .toast-icon-info { color: #3b82f6; }
        .toast-icon-delete { color: #ef4444; }
        .toast-icon-update { color: #0ea5e9; }

        /* Confirm Modal Icons */
        .confirm-icon-delete { color: #ef4444; font-size: 2rem; }
        .confirm-icon-warning { color: #f59e0b; font-size: 2rem; }

        .toast-close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            background-color: rgba(148, 163, 184, 0.2);
            color: #334155;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            border: none;
        }

        .toast-close-btn:hover {
            background-color: rgba(148, 163, 184, 0.35);
        }

        /* Animations */
        @keyframes toast-slide-down {
            from {
                transform: translateY(-24px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes modal-appear {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 640px) {
            #global-toast-container {
                left: 12px;
                right: 12px;
                top: 12px;
            }

            .toast-wrapper {
                min-width: auto;
                max-width: none;
            }
        }
    </style>
<?php $__env->stopPush(); endif; ?>

<!-- Toast Container -->
<div id="global-toast-container"></div>

<!-- Session Notifications -->
<?php if(session()->has('notification')): ?>
    <?php
        $notification = session('notification');
    ?>
    <?php if (isset($component)) { $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification','data' => ['type' => $notification['type'] ?? 'info','title' => $notification['title'] ?? '','message' => $notification['message'] ?? '','dismissible' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification['type'] ?? 'info'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification['title'] ?? ''),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notification['message'] ?? ''),'dismissible' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $attributes = $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $component = $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
<?php endif; ?>

<!-- Hidden Templates -->
<div class="hidden">
    <!-- Success Toast -->
    <div id="toast-template-success" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'CheckCircle','class' => 'toast-icon-success stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'CheckCircle','class' => 'toast-icon-success stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Success!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Error Toast -->
    <div id="toast-template-error" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'XCircle','class' => 'toast-icon-error stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'XCircle','class' => 'toast-icon-error stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Error!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Warning Toast -->
    <div id="toast-template-warning" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertTriangle','class' => 'toast-icon-warning stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertTriangle','class' => 'toast-icon-warning stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Warning!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Info Toast -->
    <div id="toast-template-info" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Info','class' => 'toast-icon-info stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Info','class' => 'toast-icon-info stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Information</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Delete Toast -->
    <div id="toast-template-delete" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Trash2','class' => 'toast-icon-delete stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','class' => 'toast-icon-delete stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Deleted!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Update Toast -->
    <div id="toast-template-update" class="toast-wrapper">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Pencil','class' => 'toast-icon-update stroke-1.5 w-6 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Pencil','class' => 'toast-icon-update stroke-1.5 w-6 h-6']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Updated!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Confirm Modal Templates -->
    <div id="confirm-template-delete">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Trash2','class' => 'confirm-icon-delete stroke-1.5 w-8 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Trash2','class' => 'confirm-icon-delete stroke-1.5 w-8 h-8']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
    </div>

    <div id="confirm-template-warning">
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'AlertTriangle','class' => 'confirm-icon-warning stroke-1.5 w-8 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'AlertTriangle','class' => 'confirm-icon-warning stroke-1.5 w-8 h-8']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $attributes = $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800)): ?>
<?php $component = $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800; ?>
<?php unset($__componentOriginal16b2e62e74cde9150905c2d0c2cb6800); ?>
<?php endif; ?>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('f5058433-ff1b-4f29-8a37-c9389c83d71f')): $__env->markAsRenderedOnce('f5058433-ff1b-4f29-8a37-c9389c83d71f');
$__env->startPush('scripts'); ?>
<script>
    // Global Notification System

    /**
     * إنشاء إشعار جديد
     */
    function createToast(type, title, message, duration = 5000) {
        const container = document.getElementById('global-toast-container');
        if (!container) return;

        const templateId = `toast-template-${type}`;
        const template = document.getElementById(templateId);
        if (!template) return;

        const node = template.cloneNode(true);
        node.id = '';
        node.classList.remove('hidden');

        // تحديث المحتوى
        const titleElement = node.querySelector('.toast-title');
        const messageElement = node.querySelector('.toast-message');

        if (titleElement) titleElement.textContent = title;
        if (messageElement) messageElement.textContent = message;

        // إضافة وظيفة الإغلاق
        const closeBtn = node.querySelector('.toast-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                node.remove();
            });
        }

        // إضافة للحاوي
        container.appendChild(node);

        // إزالة تلقائية بعد الوقت المحدد
        if (duration > 0) {
            setTimeout(() => {
                if (node.parentNode) {
                    node.remove();
                }
            }, duration);
        }

        return node;
    }

    /**
     * Show success message
     */
    window.showSuccess = function(message, title = 'Success!') {
        return createToast('success', title, message);
    };

    /**
     * Show error message
     */
    window.showError = function(message, title = 'Error!') {
        return createToast('error', title, message);
    };

    /**
     * Show warning message
     */
    window.showWarning = function(message, title = 'Warning!') {
        return createToast('warning', title, message);
    };

    /**
     * Show info message
     */
    window.showInfo = function(message, title = 'Information') {
        return createToast('info', title, message);
    };

    /**
     * Old showToast function for compatibility
     */
    window.showToast = function (message, type = 'success') {
        const titleMap = {
            'success': 'Success!',
            'error': 'Error!',
            'warning': 'Warning!',
            'info': 'Information',
            'delete': 'Deleted!',
            'update': 'Updated!'
        };
        return createToast(type, titleMap[type] || 'Information', message);
    };

    /**
     * Show confirmation modal
     */
    window.showConfirm = function(options) {
        const defaults = {
            title: 'Confirmation',
            message: 'Are you sure you want to proceed?',
            type: 'warning', // 'delete' or 'warning'
            confirmText: 'Confirm',
            cancelText: 'Cancel',
            confirmButtonClass: 'bg-red-600 hover:bg-red-700',
            onConfirm: () => {},
            onCancel: () => {}
        };

        const config = { ...defaults, ...options };

        return new Promise((resolve) => {
            const confirmed = window.confirm(config.message);
            if (confirmed) {
                try { config.onConfirm(); } catch (e) {}
                resolve(true);
            } else {
                try { config.onCancel(); } catch (e) {}
                resolve(false);
            }
        });
    };

    /**
     * Confirm deletion
     *
     * If SweetAlert2 (Swal) is available, use it with the same style
     * as the Positions module. Otherwise, fall back to the internal
     * confirm modal implementation.
     */
    window.confirmDelete = function(itemName = 'this item', onConfirm = () => {}) {
        if (typeof Swal !== 'undefined') {
            return Swal.fire({
                title: 'Delete this item?',
                html: `
                    <div class="flex flex-col items-center gap-3">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-500 shadow-sm">
                            <i class="fa fa-trash text-3xl"></i>
                        </div>
                        <div class="text-slate-700 dark:text-slate-200 text-sm leading-relaxed">
                            Are you sure you want to delete<br>
                            <span class="font-semibold text-red-600 dark:text-red-400">"${itemName}"</span>?<br>
                            This action cannot be undone.
                        </div>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                background: '#ffffff',
                color: '#0f172a',
                padding: '1.5rem 1.75rem 1.75rem',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl border border-slate-200/60 dark:border-slate-700/60',
                    title: 'text-base font-semibold text-slate-900 dark:text-slate-100 mb-1',
                    htmlContainer: 'mt-1',
                    actions: 'mt-6 flex justify-center gap-3',
                    confirmButton: 'px-5 py-2.5 rounded-full font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 text-sm',
                    cancelButton: 'px-5 py-2.5 rounded-full font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-1 text-sm',
                },
                backdrop: 'rgba(15,23,42,0.55)',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster',
                    backdrop: 'animate__animated animate__fadeIn animate__faster',
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster',
                    backdrop: 'animate__animated animate__fadeOut animate__faster',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    onConfirm();
                }
                return result.isConfirmed;
            });
        }

        return showConfirm({
            title: 'Confirm Deletion',
            message: `Are you sure you want to delete "${itemName}"? This action cannot be undone.`,
            type: 'delete',
            confirmText: 'Delete',
            confirmButtonClass: 'bg-red-600 hover:bg-red-700',
            onConfirm: onConfirm
        });
    };

    /**
     * Confirm dangerous action
     */
    window.confirmDanger = function(message = 'This is a dangerous action', onConfirm = () => {}) {
        return showConfirm({
            title: 'Warning!',
            message: message,
            type: 'warning',
            confirmText: 'Continue',
            confirmButtonClass: 'bg-orange-600 hover:bg-orange-700',
            onConfirm: onConfirm
        });
    };

    // Error Code Messages
    window.ERROR_CODES = {
        // Database Errors (1000-1999)
        1001: 'Database connection error',
        1002: 'Failed to save data',
        1003: 'Failed to update data',
        1004: 'Failed to delete data',
        1005: 'Data not found',
        1006: 'Unique constraint violation',
        1007: 'Foreign key constraint violation',
        1008: 'Query building error',

        // Validation Errors (2000-2999)
        2001: 'Invalid input data',
        2002: 'Required field missing',
        2003: 'Invalid data format',
        2004: 'Value out of allowed range',
        2005: 'Email already exists',
        2006: 'Password too weak',

        // File System Errors (3000-3999)
        3001: 'File upload failed',
        3002: 'Unsupported file type',
        3003: 'File too large',
        3004: 'File deletion failed',

        // Permission Errors (4000-4999)
        4001: 'Access denied',
        4002: 'Session expired',
        4003: 'Account blocked',

        // System Errors (5000-5999)
        5001: 'Internal system error',
        5002: 'Service temporarily unavailable',
        5003: 'Request processing error',
        5004: 'Network error',

        // Business Logic Errors (6000-6999)
        6001: 'Cannot delete item due to related data',
        6002: 'Insufficient balance',
        6003: 'Invalid time period',
        6004: 'Item in invalid state'
    };

    /**
     * Show error message by code
     */
    window.showErrorCode = function(code, customMessage = null) {
        const defaultMessage = window.ERROR_CODES[code] || 'Unknown error';
        const message = customMessage || defaultMessage;
        const title = `Error ${code}`;

        return showError(message, title);
    };

    /**
     * Show multiple error messages
     */
    window.showMultipleErrors = function(errors) {
        errors.forEach((error, index) => {
            setTimeout(() => {
                if (typeof error === 'string') {
                    showError(error);
                } else if (error.code) {
                    showErrorCode(error.code, error.message);
                } else {
                    showError(error.message || 'Undefined error');
                }
            }, index * 200); // Delay between messages
        });
    };

    /**
     * Show success message with action
     */
    window.showSuccessWithAction = function(message, actionText, onAction) {
        const toast = showSuccess(message);

        // Optional action after delay
        setTimeout(() => {
            if (onAction && typeof onAction === 'function') {
                onAction();
            }
        }, 1000);

        return toast;
    };
</script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH E:\ERP System\Source\resources\views/components/global-notifications.blade.php ENDPATH**/ ?>