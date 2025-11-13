@pushOnce('styles')
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
@endPushOnce

<!-- Toast Container -->
<div id="global-toast-container"></div>

<!-- Confirm Modal -->
<div id="global-confirm-modal">
    <div class="confirm-modal-content">
        <div class="confirm-modal-header">
            <div id="confirm-icon-container"></div>
            <div class="ml-4">
                <h3 id="confirm-title" class="text-lg font-semibold text-slate-800"></h3>
            </div>
        </div>
        <div class="confirm-modal-body">
            <p id="confirm-message" class="text-slate-600"></p>
        </div>
        <div class="confirm-modal-actions">
            <button id="confirm-cancel-btn" class="px-4 py-2 text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                Cancel
            </button>
            <button id="confirm-ok-btn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- Session Notifications -->
@if(session()->has('notification'))
    @php
        $notification = session('notification');
    @endphp
    <x-notification
        :type="$notification['type'] ?? 'info'"
        :title="$notification['title'] ?? ''"
        :message="$notification['message'] ?? ''"
        dismissible="true"
    />
@endif

<!-- Hidden Templates -->
<div class="hidden">
    <!-- Success Toast -->
    <div id="toast-template-success" class="toast-wrapper">
        <x-base.lucide icon="CheckCircle" class="toast-icon-success stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Success!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Error Toast -->
    <div id="toast-template-error" class="toast-wrapper">
        <x-base.lucide icon="XCircle" class="toast-icon-error stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Error!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Warning Toast -->
    <div id="toast-template-warning" class="toast-wrapper">
        <x-base.lucide icon="AlertTriangle" class="toast-icon-warning stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Warning!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Info Toast -->
    <div id="toast-template-info" class="toast-wrapper">
        <x-base.lucide icon="Info" class="toast-icon-info stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="ml-4 mr-4 flex-1">
            <div class="toast-title">Information</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Confirm Modal Templates -->
    <div id="confirm-template-delete">
        <x-base.lucide icon="Trash2" class="confirm-icon-delete stroke-1.5 w-8 h-8"></x-base.lucide>
    </div>

    <div id="confirm-template-warning">
        <x-base.lucide icon="AlertTriangle" class="confirm-icon-warning stroke-1.5 w-8 h-8"></x-base.lucide>
    </div>
</div>

@pushOnce('scripts')
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
            'info': 'Information'
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

        const modal = document.getElementById('global-confirm-modal');
        const iconContainer = document.getElementById('confirm-icon-container');
        const titleElement = document.getElementById('confirm-title');
        const messageElement = document.getElementById('confirm-message');
        const cancelBtn = document.getElementById('confirm-cancel-btn');
        const confirmBtn = document.getElementById('confirm-ok-btn');

        // تحديث المحتوى
        const templateId = `confirm-template-${config.type}`;
        const template = document.getElementById(templateId);

        if (template) {
            const iconNode = template.cloneNode(true);
            iconContainer.innerHTML = '';
            iconContainer.appendChild(iconNode);
        }

        titleElement.textContent = config.title;
        messageElement.textContent = config.message;
        cancelBtn.textContent = config.cancelText;
        confirmBtn.textContent = config.confirmText;
        confirmBtn.className = `px-4 py-2 text-white rounded-lg transition-colors ${config.confirmButtonClass}`;

        // إظهار النافذة
        modal.style.display = 'flex';

        return new Promise((resolve) => {
            const handleConfirm = () => {
                modal.style.display = 'none';
                config.onConfirm();
                resolve(true);
            };

            const handleCancel = () => {
                modal.style.display = 'none';
                config.onCancel();
                resolve(false);
            };

            confirmBtn.onclick = handleConfirm;
            cancelBtn.onclick = handleCancel;

            // إغلاق عند النقر خارج النافذة
            modal.onclick = (e) => {
                if (e.target === modal) {
                    handleCancel();
                }
            };

            // إغلاق عند الضغط على Escape
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    handleCancel();
                    document.removeEventListener('keydown', handleEscape);
                }
            };
            document.addEventListener('keydown', handleEscape);
        });
    };

    /**
     * Confirm deletion
     */
    window.confirmDelete = function(itemName = 'this item', onConfirm = () => {}) {
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

    // Auto-initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎉 Global Notification System Initialized');
    });
</script>
@endPushOnce
