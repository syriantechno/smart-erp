
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['unreadCount' => 0]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['unreadCount' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="relative" id="notification-dropdown">
    
    <button
        class="relative notification-bell inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/60 bg-white text-slate-800 shadow-[0_14px_30px_rgba(15,15,20,0.12)] transition hover:-translate-y-0.5 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-200"
        data-tw-toggle="modal"
        data-tw-target="#notifications-slideover"
        :class="{ 'text-blue-600': unreadCount > 0 }"
    >
        <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Bell','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Bell','class' => 'h-5 w-5']); ?>
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

        
        <div
            id="notification-badge"
            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white"
            style="display: <?php echo e($unreadCount > 0 ? 'flex' : 'none'); ?>;"
        >
            <?php echo e($unreadCount > 99 ? '99+' : $unreadCount); ?>

        </div>
    </button>
</div>


<?php if (isset($component)) { $__componentOriginal7b984b2f83e0e1ed46be48207486a493 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b984b2f83e0e1ed46be48207486a493 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.index','data' => ['id' => 'notifications-slideover','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'notifications-slideover','size' => 'md']); ?>
    <?php if (isset($component)) { $__componentOriginalbf24d1b6c00bc08aa4e052383ee60570 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.panel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.panel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        
        <?php if (isset($component)) { $__componentOriginala9479a745407756aa806bba6e780c74f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9479a745407756aa806bba6e780c74f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.title','data' => ['class' => 'p-5 border-b border-slate-200/60']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'p-5 border-b border-slate-200/60']); ?>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal16b2e62e74cde9150905c2d0c2cb6800 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal16b2e62e74cde9150905c2d0c2cb6800 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.lucide.index','data' => ['icon' => 'Bell','class' => 'h-5 w-5 text-yellow-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.lucide'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'Bell','class' => 'h-5 w-5 text-yellow-500']); ?>
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
                    <h3 class="text-base font-medium text-slate-800">Notifications</h3>
                </div>
                <div class="flex space-x-2">
                    <button
                        onclick="markAllNotificationsAsRead()"
                        class="text-xs text-blue-600 hover:text-blue-800"
                        id="mark-all-read-btn"
                    >
                        Mark all read
                    </button>
                    <button
                        onclick="deleteAllNotifications()"
                        class="text-xs text-red-600 hover:text-red-800"
                    >
                        Clear all
                    </button>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9479a745407756aa806bba6e780c74f)): ?>
<?php $attributes = $__attributesOriginala9479a745407756aa806bba6e780c74f; ?>
<?php unset($__attributesOriginala9479a745407756aa806bba6e780c74f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9479a745407756aa806bba6e780c74f)): ?>
<?php $component = $__componentOriginala9479a745407756aa806bba6e780c74f; ?>
<?php unset($__componentOriginala9479a745407756aa806bba6e780c74f); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal52a8e2b085d6c4797e2849447438b96c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52a8e2b085d6c4797e2849447438b96c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base.slideover.description','data' => ['class' => 'px-0 py-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('base.slideover.description'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'px-0 py-0']); ?>
            <div class="max-h-[420px] overflow-y-auto">
                <div id="notifications-list" class="divide-y divide-gray-100">
                    <!-- Notifications will be loaded here -->
                    <div class="px-4 py-8 text-center text-sm text-gray-500">
                        Loading notifications...
                    </div>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52a8e2b085d6c4797e2849447438b96c)): ?>
<?php $attributes = $__attributesOriginal52a8e2b085d6c4797e2849447438b96c; ?>
<?php unset($__attributesOriginal52a8e2b085d6c4797e2849447438b96c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52a8e2b085d6c4797e2849447438b96c)): ?>
<?php $component = $__componentOriginal52a8e2b085d6c4797e2849447438b96c; ?>
<?php unset($__componentOriginal52a8e2b085d6c4797e2849447438b96c); ?>
<?php endif; ?>

        
        <div id="notifications-footer" class="px-5 py-3 border-t border-slate-200/60 bg-slate-50" style="display: none;">
            <a
                href="<?php echo e(route('notifications.index')); ?>"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium"
            >
                View all notifications →
            </a>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570)): ?>
<?php $attributes = $__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570; ?>
<?php unset($__attributesOriginalbf24d1b6c00bc08aa4e052383ee60570); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbf24d1b6c00bc08aa4e052383ee60570)): ?>
<?php $component = $__componentOriginalbf24d1b6c00bc08aa4e052383ee60570; ?>
<?php unset($__componentOriginalbf24d1b6c00bc08aa4e052383ee60570); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b984b2f83e0e1ed46be48207486a493)): ?>
<?php $attributes = $__attributesOriginal7b984b2f83e0e1ed46be48207486a493; ?>
<?php unset($__attributesOriginal7b984b2f83e0e1ed46be48207486a493); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b984b2f83e0e1ed46be48207486a493)): ?>
<?php $component = $__componentOriginal7b984b2f83e0e1ed46be48207486a493; ?>
<?php unset($__componentOriginal7b984b2f83e0e1ed46be48207486a493); ?>
<?php endif; ?>


<script>
let notifications = [];
let unreadCount = <?php echo e($unreadCount ?? 0); ?>;
let pollingInterval = null;

function initNotifications() {
    loadRecentNotifications();
    startPolling();
    updateBadge();
}

function loadRecentNotifications() {
    fetch('<?php echo e(route("notifications.recent")); ?>?limit=10', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            notifications = data.data;
            renderNotifications();
            updateBadge();
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
    });
}

function loadUnreadCount() {
    fetch('<?php echo e(route("notifications.unread-count")); ?>', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            unreadCount = data.count;
            updateBadge();
        }
    })
    .catch(error => {
        console.error('Error loading unread count:', error);
    });
}

function startPolling() {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
    // Update unread count every 30 seconds
    pollingInterval = setInterval(() => {
        loadUnreadCount();
    }, 30000);
}

function updateBadge() {
    const badge = document.getElementById('notification-badge');
    if (badge) {
        if (unreadCount > 0) {
            badge.style.display = 'flex';
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
        } else {
            badge.style.display = 'none';
        }
    }
}

function renderNotifications() {
    const container = document.getElementById('notifications-list');
    const footer = document.getElementById('notifications-footer');
    const markAllBtn = document.getElementById('mark-all-read-btn');

    if (!container) return;

    if (notifications.length === 0) {
        container.innerHTML = `
            <div class="px-4 py-8 text-center text-sm text-gray-500">
                No notifications
            </div>
        `;
        if (footer) footer.style.display = 'none';
        if (markAllBtn) {
            markAllBtn.disabled = true;
            markAllBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
        return;
    }

    const hasUnread = notifications.some(n => !n.is_read);
    if (markAllBtn) {
        markAllBtn.disabled = !hasUnread;
        if (hasUnread) {
            markAllBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            markAllBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    const html = notifications.map(notification => `
        <div onclick="handleNotificationClick(${notification.id})"
             class="px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors ${!notification.is_read ? 'bg-blue-50' : ''}">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full flex items-center justify-center ${getTypeColor(notification.type)}">
                        <i data-lucide="${getIconName(notification.icon, notification.type)}" class="h-4 w-4 text-white"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            ${notification.title}
                            ${!notification.is_read ? '<span class="ml-1 inline-block h-2 w-2 bg-blue-500 rounded-full"></span>' : ''}
                        </p>
                        <p class="text-xs text-gray-500">${formatTime(notification.created_at)}</p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                </div>
                <div class="flex-shrink-0 flex space-x-1">
                    ${!notification.is_read ? `
                        <button onclick="event.stopPropagation(); markAsRead(${notification.id})"
                                class="text-blue-600 hover:text-blue-800 p-1" title="Mark as read">
                            <i data-lucide="check" class="h-3 w-3"></i>
                        </button>
                    ` : ''}
                    <button onclick="event.stopPropagation(); deleteNotification(${notification.id})"
                            class="text-red-600 hover:text-red-800 p-1" title="Delete">
                        <i data-lucide="x" class="h-3 w-3"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    container.innerHTML = html;
    if (footer) footer.style.display = 'block';

    // Re-initialize Lucide icons
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons({
            'stroke-width': 1.5,
            nameAttr: 'data-lucide'
        });
    }
}

function markAsRead(notificationId) {
    fetch(`<?php echo e(url('/notifications')); ?>/${notificationId}/read`, {
        method: 'PATCH',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.is_read = true;
                unreadCount = Math.max(0, unreadCount - 1);
                renderNotifications();
                updateBadge();
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllNotificationsAsRead() {
    fetch('<?php echo e(route("notifications.mark-all-read")); ?>', {
        method: 'PATCH',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            notifications.forEach(notification => {
                notification.is_read = true;
            });
            unreadCount = 0;
            renderNotifications();
            updateBadge();
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

function deleteNotification(notificationId) {
    const doDelete = () => {
        fetch(`<?php echo e(url('/notifications')); ?>/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                notifications = notifications.filter(n => n.id !== notificationId);
                renderNotifications();
                updateBadge();
            }
        })
        .catch(error => {
            console.error('Error deleting notification:', error);
        });
    };

    if (typeof window.confirmDelete === 'function') {
        window.confirmDelete('this notification', doDelete);
    } else {
        doDelete();
    }
}

function deleteAllNotifications() {
    const doDeleteAll = () => {
        fetch('<?php echo e(route("notifications.delete-all")); ?>', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                notifications = [];
                unreadCount = 0;
                renderNotifications();
                updateBadge();
            }
        })
        .catch(error => {
            console.error('Error deleting all notifications:', error);
        });
    };

    if (typeof window.confirmDelete === 'function') {
        window.confirmDelete('all notifications', doDeleteAll);
    } else {
        doDeleteAll();
    }
}

function handleNotificationClick(notificationId) {
    const notification = notifications.find(n => n.id === notificationId);
    if (!notification) return;

    // Mark as read if not already read
    if (!notification.is_read) {
        markAsRead(notificationId);
    }

    // Navigate to action URL if exists
    if (notification.action_url) {
        window.location.href = notification.action_url;
    }

    // Close dropdown
    closeNotificationDropdown();
}

function getTypeColor(type) {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    return colors[type] || colors.info;
}

function getIconName(icon, type) {
    if (icon) {
        // Fix common icon name issues
        const iconMap = {
            'UserPlus': 'user-plus',
            'UserMinus': 'user-minus',
            'UserCheck': 'user-check',
            'UserX': 'user-x',
            'InformationCircle': 'info',
            'CheckCircle': 'check-circle',
            'ExclamationCircle': 'alert-circle',
            'ExclamationTriangle': 'alert-triangle'
        };
        return iconMap[icon] || icon.toLowerCase();
    }

    // Return default icon based on notification type
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'alert-circle';
        case 'warning': return 'alert-triangle';
        default: return 'info';
    }
}

function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInMinutes = Math.floor((now - date) / (1000 * 60));

    if (diffInMinutes < 1) return 'Just now';
    if (diffInMinutes < 60) return `${diffInMinutes}m ago`;

    const diffInHours = Math.floor(diffInMinutes / 60);
    if (diffInHours < 24) return `${diffInHours}h ago`;

    const diffInDays = Math.floor(diffInHours / 24);
    if (diffInDays < 7) return `${diffInDays}d ago`;

    return date.toLocaleDateString();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initNotifications, 100); // Small delay to ensure everything is loaded
});
</script>
<?php /**PATH E:\ERP System\Source\resources\views/components/notifications/dropdown.blade.php ENDPATH**/ ?>