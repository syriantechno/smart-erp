@pushOnce('styles')
    <style>
        /* Global Notification Styles */
        #global-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            display: none;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
            max-width: 400px;
            width: auto;
            box-sizing: border-box;
        }

        #global-toast-container:not(:empty) {
            display: flex;
        }


        /* SweetAlert Delete Modal Buttons -> reuse btn-tonal styles */
        .swal-modern-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
        }

        .swal-modern-btn .swal-btn-icon {
            width: 1rem;
            height: 1rem;
            display: inline-flex;
        }

        .swal-modern-btn svg {
            width: 100%;
            height: 100%;
        }

        .swal-modern-btn.btn-tonal--danger svg {
            color: #b21a50;
        }
        @keyframes modalFadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toast-wrapper {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15);
            min-width: 320px;
            max-width: 480px;
            position: relative;
            animation: toast-slide-down 0.35s ease-out;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .toast-icon {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            animation: toast-icon-bounce 0.5s ease-in-out;
        }

        .toast-content {
            flex: 1;
            font-size: 14px;
            line-height: 1.5;
        }

        @keyframes toast-slide-down {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes toast-icon-bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
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

        /* SweetAlert modern delete dialog */
        .swal2-popup.swal-modern-popup {
            border-radius: 1.5rem !important;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.18);
            padding: 2.25rem 2.25rem 2.3rem !important;
            background: #ffffff;
        }

        .swal-modern-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            text-align: center;
        }

        .swal-modern-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: inset 0 0 0 1px rgba(239, 68, 68, 0.15), 0 18px 30px rgba(239, 68, 68, 0.25);
        }

        .swal-modern-icon svg {
            width: 24px;
            height: 24px;
        }

        .swal-modern-text {
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .swal-modern-text span {
            color: #ef4444;
            font-weight: 600;
        }

        .swal-modern-actions {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .swal2-styled.swal-modern-confirm {
            background: rgb(var(--primary-rgb, 37 99 235));
            color: #ffffff;
            border-radius: 999px;
            padding: 0.65rem 1.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            box-shadow: 0 15px 30px rgba(var(--primary-rgb, 37 99 235), 0.25);
        }

        .swal2-styled.swal-modern-cancel {
            background: #f8fafc;
            color: #1f2933;
            border-radius: 999px;
            padding: 0.65rem 1.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

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
        <x-base.lucide icon="CheckCircle" class="toast-icon toast-icon-success stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Success!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Error Toast -->
    <div id="toast-template-error" class="toast-wrapper">
        <x-base.lucide icon="XCircle" class="toast-icon toast-icon-error stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Error!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Warning Toast -->
    <div id="toast-template-warning" class="toast-wrapper">
        <x-base.lucide icon="AlertTriangle" class="toast-icon toast-icon-warning stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Warning!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Info Toast -->
    <div id="toast-template-info" class="toast-wrapper">
        <x-base.lucide icon="Info" class="toast-icon toast-icon-info stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Info!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Delete Toast -->
    <div id="toast-template-delete" class="toast-wrapper">
        <x-base.lucide icon="Trash2" class="toast-icon toast-icon-delete stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Deleted!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <!-- Update Toast -->
    <div id="toast-template-update" class="toast-wrapper">
        <x-base.lucide icon="Pencil" class="toast-icon toast-icon-update stroke-1.5 w-6 h-6"></x-base.lucide>
        <div class="toast-content">
            <div class="toast-title">Updated!</div>
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
                    <div class="swal-modern-card">
                        <div class="swal-modern-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                            </svg>
                        </div>
                        <div class="swal-modern-text">
                            Are you sure you want to delete<br>
                            <span>"${itemName}"</span>?<br>
                            This action cannot be undone.
                        </div>
                    </div>
                `,
                icon: undefined,
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                confirmButtonText: `
                    <span class="swal-btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </span>
                    <span class="swal-btn-label">Delete</span>
                `,
                cancelButtonText: `
                    <span class="swal-btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </span>
                    <span class="swal-btn-label">Cancel</span>
                `,
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-modern-popup',
                    actions: 'swal-modern-actions',
                    confirmButton: 'swal-modern-btn btn-royal btn-royal--action btn-royal--danger',
                    cancelButton: 'swal-modern-btn btn-royal btn-royal--outline btn-royal--sm',
                },
                backdrop: 'rgba(15,23,42,0.55)',
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

    /**
     * Confirm Approval Action (Approve/Reject with optional comment)
     * @param {Object} options - Configuration options
     * @param {string} options.title - Modal title
     * @param {string} options.message - Description message
     * @param {string} options.itemName - Name of item being approved
     * @param {string} options.type - 'approve', 'reject', 'pay', 'confirm'
     * @param {boolean} options.showComment - Show comment textarea
     * @param {boolean} options.requireComment - Require comment before submit
     * @param {function} options.onConfirm - Callback with comment parameter
     */
    window.confirmApproval = function(options = {}) {
        const defaults = {
            title: 'Confirm Action',
            message: 'Are you sure you want to proceed?',
            itemName: '',
            type: 'approve', // approve, reject, pay, confirm
            showComment: false,
            requireComment: false,
            commentLabel: 'Comment (optional)',
            confirmText: 'Confirm',
            cancelText: 'Cancel',
            onConfirm: () => {}
        };

        const config = { ...defaults, ...options };

        // Icon and color based on type
        const typeConfig = {
            approve: {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`,
                color: '#22c55e',
                bgColor: 'rgba(34, 197, 94, 0.08)',
                shadowColor: 'rgba(34, 197, 94, 0.25)',
                btnClass: 'btn-royal--success'
            },
            reject: {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`,
                color: '#ef4444',
                bgColor: 'rgba(239, 68, 68, 0.08)',
                shadowColor: 'rgba(239, 68, 68, 0.25)',
                btnClass: 'btn-royal--danger'
            },
            pay: {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>`,
                color: '#0ea5e9',
                bgColor: 'rgba(14, 165, 233, 0.08)',
                shadowColor: 'rgba(14, 165, 233, 0.25)',
                btnClass: 'btn-royal--info'
            },
            confirm: {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>`,
                color: '#8b5cf6',
                bgColor: 'rgba(139, 92, 246, 0.08)',
                shadowColor: 'rgba(139, 92, 246, 0.25)',
                btnClass: 'btn-royal--primary'
            }
        };

        const tc = typeConfig[config.type] || typeConfig.confirm;

        // Build comment input HTML
        const commentHtml = config.showComment ? `
            <div style="margin-top: 16px; text-align: left;">
                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #475569; margin-bottom: 6px;">
                    ${config.commentLabel}${config.requireComment ? ' <span style="color: #ef4444;">*</span>' : ''}
                </label>
                <textarea id="swal-comment" rows="3" placeholder="Enter your comment here..."
                    style="width: 100%; padding: 10px 12px; border: 1px solid rgba(148, 163, 184, 0.4); border-radius: 8px; font-size: 0.9rem; resize: vertical; min-height: 80px; outline: none; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='rgb(var(--primary-rgb, 37 99 235))'"
                    onblur="this.style.borderColor='rgba(148, 163, 184, 0.4)'"
                ></textarea>
            </div>
        ` : '';

        if (typeof Swal !== 'undefined') {
            return Swal.fire({
                title: config.title,
                html: `
                    <div class="swal-modern-card">
                        <div class="swal-modern-icon" style="background: ${tc.bgColor}; color: ${tc.color}; box-shadow: inset 0 0 0 1px ${tc.color}20, 0 18px 30px ${tc.shadowColor};">
                            ${tc.icon}
                        </div>
                        <div class="swal-modern-text">
                            ${config.message}
                            ${config.itemName ? `<br><span style="color: ${tc.color};">"${config.itemName}"</span>` : ''}
                        </div>
                        ${commentHtml}
                    </div>
                `,
                icon: undefined,
                showCancelButton: true,
                reverseButtons: true,
                focusCancel: true,
                confirmButtonText: `
                    <span class="swal-btn-icon">${tc.icon}</span>
                    <span class="swal-btn-label">${config.confirmText}</span>
                `,
                cancelButtonText: `
                    <span class="swal-btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </span>
                    <span class="swal-btn-label">${config.cancelText}</span>
                `,
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-modern-popup',
                    actions: 'swal-modern-actions',
                    confirmButton: `swal-modern-btn btn-royal btn-royal--action ${tc.btnClass}`,
                    cancelButton: 'swal-modern-btn btn-royal btn-royal--outline btn-royal--sm',
                },
                backdrop: 'rgba(15,23,42,0.55)',
                preConfirm: () => {
                    if (config.showComment) {
                        const comment = document.getElementById('swal-comment')?.value || '';
                        if (config.requireComment && !comment.trim()) {
                            Swal.showValidationMessage('Please enter a comment');
                            return false;
                        }
                        return { comment: comment };
                    }
                    return { comment: '' };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    config.onConfirm(result.value?.comment || '');
                }
                return result.isConfirmed;
            });
        }

        // Fallback to native confirm
        const confirmed = window.confirm(config.message);
        if (confirmed) {
            config.onConfirm('');
        }
        return Promise.resolve(confirmed);
    };

    /**
     * Quick approval confirmation
     */
    window.confirmApprove = function(itemName, onConfirm) {
        return confirmApproval({
            title: 'Approve',
            message: 'Are you sure you want to approve',
            itemName: itemName,
            type: 'approve',
            confirmText: 'Approve',
            onConfirm: onConfirm
        });
    };

    /**
     * Quick rejection confirmation with required comment
     */
    window.confirmReject = function(itemName, onConfirm) {
        return confirmApproval({
            title: 'Reject',
            message: 'Are you sure you want to reject',
            itemName: itemName,
            type: 'reject',
            showComment: true,
            requireComment: true,
            commentLabel: 'Rejection Reason',
            confirmText: 'Reject',
            onConfirm: onConfirm
        });
    };

    /**
     * Quick payment confirmation
     */
    window.confirmPayment = function(itemName, onConfirm) {
        return confirmApproval({
            title: 'Mark as Paid',
            message: 'Are you sure you want to mark as paid',
            itemName: itemName,
            type: 'pay',
            confirmText: 'Mark Paid',
            onConfirm: onConfirm
        });
    };

    /**
     * Quick action confirmation
     */
    window.confirmAction = function(title, message, onConfirm) {
        return confirmApproval({
            title: title,
            message: message,
            type: 'confirm',
            confirmText: 'Confirm',
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
@endPushOnce
