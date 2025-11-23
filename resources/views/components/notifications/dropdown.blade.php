{{-- Notification Bell + Slide Over (medium) --}}
@props(['unreadCount' => 0])

<div class="relative" id="notification-dropdown">
    {{-- Notification Bell Button --}}
    <button
        class="relative notification-bell inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/60 bg-white text-slate-800 shadow-[0_14px_30px_rgba(15,15,20,0.12)] transition hover:-translate-y-0.5 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-200"
        data-tw-toggle="modal"
        data-tw-target="#notifications-slideover"
        :class="{ 'text-blue-600': unreadCount > 0 }"
    >
        <x-base.lucide icon="Bell" class="h-5 w-5" />

        {{-- Unread Badge --}}
        <div
            id="notification-badge"
            class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white"
            style="display: {{ $unreadCount > 0 ? 'flex' : 'none' }};"
        >
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </div>
    </button>
</div>

{{-- Slide Over for Notifications --}}
<x-base.slideover id="notifications-slideover" size="md">
    <x-base.slideover.panel>
        {{-- Header --}}
        <x-base.slideover.title class="p-5 border-b border-slate-200/60">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2">
                    <x-base.lucide icon="Bell" class="h-5 w-5 text-yellow-500" />
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
        </x-base.slideover.title>

        {{-- Body: Notifications List --}}
        <x-base.slideover.description class="px-0 py-0">
            <div class="max-h-[420px] overflow-y-auto">
                <div id="notifications-list" class="divide-y divide-gray-100">
                    <!-- Notifications will be loaded here -->
                    <div class="px-4 py-8 text-center text-sm text-gray-500">
                        Loading notifications...
                    </div>
                </div>
            </div>
        </x-base.slideover.description>

        {{-- Footer --}}
        <div id="notifications-footer" class="px-5 py-3 border-t border-slate-200/60 bg-slate-50" style="display: none;">
            <a
                href="{{ route('notifications.index') }}"
                class="text-sm text-blue-600 hover:text-blue-800 font-medium"
            >
                View all notifications →
            </a>
        </div>
    </x-base.slideover.panel>
</x-base.slideover>

{{-- Vanilla JavaScript for Notification Dropdown --}}
<script>
let notifications = [];
let unreadCount = {{ $unreadCount ?? 0 }};
let pollingInterval = null;

function initNotifications() {
    loadRecentNotifications();
    startPolling();
    updateBadge();
}

function loadRecentNotifications() {
    fetch('{{ route("notifications.recent") }}?limit=10', {
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
    fetch('{{ route("notifications.unread-count") }}', {
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
    fetch(`{{ url('/notifications') }}/${notificationId}/read`, {
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
    fetch('{{ route("notifications.mark-all-read") }}', {
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
    if (!confirm('Are you sure you want to delete this notification?')) {
        return;
    }

    fetch(`{{ url('/notifications') }}/${notificationId}`, {
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
}

function deleteAllNotifications() {
    if (!confirm('Are you sure you want to delete all notifications? This action cannot be undone.')) {
        return;
    }

    fetch('{{ route("notifications.delete-all") }}', {
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
