<?php $__env->startSection('subhead'); ?>
    <title><?php echo e(__('Notifications')); ?> - <?php echo e(config('app.name')); ?></title>
    <style>
        .notification-card {
            transition: all 0.3s ease;
        }
        .notification-card:hover {
            transform: translateX(4px);
        }
        .notification-card.unread {
            border-left: 4px solid #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        }
        .notification-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .notification-icon.success { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
        .notification-icon.error { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .notification-icon.warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .notification-icon.info { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        
        .filter-tab {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .filter-tab.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .filter-tab:not(.active) {
            background: #f1f5f9;
            color: #64748b;
        }
        .filter-tab:not(.active):hover {
            background: #e2e8f0;
        }

        .stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 16px;
            font-weight: 600;
        }
        .stats-badge.total { background: #f1f5f9; color: #475569; }
        .stats-badge.unread { background: #dbeafe; color: #1d4ed8; }
        .stats-badge.read { background: #dcfce7; color: #16a34a; }

        .action-btn {
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: scale(1.1);
        }
        .action-btn.read { background: #dbeafe; color: #2563eb; }
        .action-btn.read:hover { background: #bfdbfe; }
        .action-btn.delete { background: #fee2e2; color: #dc2626; }
        .action-btn.delete:hover { background: #fecaca; }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
        .empty-state-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-btn {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .pagination-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        .pagination-btn:not(.active) {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        .pagination-btn:not(.active):hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="max-w-5xl mx-auto">
        
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white"><?php echo e(__('Notifications')); ?></h1>
                    <p class="text-slate-500 mt-1"><?php echo e(__('Stay updated with your latest activities')); ?></p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        id="mark-all-read-btn"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 transition-all shadow-sm"
                    >
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        <span><?php echo e(__('Mark All Read')); ?></span>
                    </button>
                    <button
                        id="delete-all-btn"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 border border-red-100 text-red-600 rounded-xl hover:bg-red-100 transition-all"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span><?php echo e(__('Clear All')); ?></span>
                    </button>
                </div>
            </div>

            
            <div class="flex items-center gap-4 mb-6" id="notification-stats">
                <div class="stats-badge total">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    <span id="total-count">0</span> <?php echo e(__('Total')); ?>

                </div>
                <div class="stats-badge unread">
                    <i data-lucide="bell-ring" class="w-4 h-4"></i>
                    <span id="unread-count">0</span> <?php echo e(__('Unread')); ?>

                </div>
                <div class="stats-badge read">
                    <i data-lucide="bell-off" class="w-4 h-4"></i>
                    <span id="read-count">0</span> <?php echo e(__('Read')); ?>

                </div>
            </div>

            
            <div class="flex items-center gap-2">
                <button class="filter-tab active" data-filter="all"><?php echo e(__('All')); ?></button>
                <button class="filter-tab" data-filter="unread"><?php echo e(__('Unread')); ?></button>
                <button class="filter-tab" data-filter="read"><?php echo e(__('Read')); ?></button>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden dark:bg-darkmode-600 dark:border-darkmode-400">
            <div id="notifications-container">
                
                <div class="p-8 text-center">
                    <div class="animate-pulse flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-slate-200 rounded-2xl"></div>
                        <div class="h-4 w-32 bg-slate-200 rounded"></div>
                    </div>
                    <p class="text-slate-500 mt-4"><?php echo e(__('Loading notifications...')); ?></p>
                </div>
            </div>
        </div>

        
        <div id="notifications-pagination" class="mt-6 flex justify-center"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let currentFilter = 'all';
    const perPage = 15;

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    loadNotifications(currentPage);

    // Filter tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            currentPage = 1;
            loadNotifications(currentPage);
        });
    });

    // Mark all as read
    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
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
                showToast('success', '<?php echo e(__("Success")); ?>', '<?php echo e(__("All notifications marked as read")); ?>');
                loadNotifications(currentPage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', '<?php echo e(__("Error")); ?>', '<?php echo e(__("Failed to mark notifications as read")); ?>');
        });
    });

    // Delete all
    document.getElementById('delete-all-btn').addEventListener('click', function() {
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
                    showToast('success', '<?php echo e(__("Success")); ?>', '<?php echo e(__("All notifications deleted")); ?>');
                    loadNotifications(currentPage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', '<?php echo e(__("Error")); ?>', '<?php echo e(__("Failed to delete notifications")); ?>');
            });
        };

        if (typeof window.confirmDelete === 'function') {
            window.confirmDelete('all notifications', doDeleteAll);
        } else if (confirm('<?php echo e(__("Are you sure you want to delete all notifications?")); ?>')) {
            doDeleteAll();
        }
    });

    function loadNotifications(page = 1) {
        currentPage = page;
        const container = document.getElementById('notifications-container');
        
        // Show loading
        container.innerHTML = `
            <div class="p-8 text-center">
                <div class="animate-pulse flex flex-col items-center gap-4">
                    <div class="w-16 h-16 bg-slate-200 rounded-2xl"></div>
                    <div class="h-4 w-32 bg-slate-200 rounded"></div>
                </div>
                <p class="text-slate-500 mt-4"><?php echo e(__('Loading notifications...')); ?></p>
            </div>
        `;

        let url = `<?php echo e(route('notifications.index')); ?>?page=${page}`;
        if (currentFilter === 'unread') {
            url += '&filter=unread';
        } else if (currentFilter === 'read') {
            url += '&filter=read';
        }

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderNotifications(data.data.data);
                renderPagination(data.data);
                updateStats(data.stats || {});
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i data-lucide="alert-circle" class="w-12 h-12 text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800"><?php echo e(__('Error loading notifications')); ?></h3>
                    <p class="text-slate-500 mt-2"><?php echo e(__('Please try again later')); ?></p>
                </div>
            `;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    }

    function updateStats(stats) {
        document.getElementById('total-count').textContent = stats.total || 0;
        document.getElementById('unread-count').textContent = stats.unread || 0;
        document.getElementById('read-count').textContent = stats.read || 0;
    }

    function renderNotifications(notifications) {
        const container = document.getElementById('notifications-container');

        if (!notifications || notifications.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i data-lucide="bell-off" class="w-12 h-12 text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white"><?php echo e(__('No notifications')); ?></h3>
                    <p class="text-slate-500 mt-2"><?php echo e(__("You're all caught up! Check back later for updates.")); ?></p>
                </div>
            `;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        const html = notifications.map(notification => `
            <div class="notification-card ${!notification.is_read ? 'unread' : ''} p-5 border-b border-slate-100 dark:border-darkmode-400 hover:bg-slate-50/50 dark:hover:bg-darkmode-500/50 transition-all cursor-pointer"
                 onclick="handleNotificationClick(${notification.id}, '${notification.action_url || ''}')">
                <div class="flex items-start gap-4">
                    <div class="notification-icon ${notification.type || 'info'}">
                        <i data-lucide="${getIconName(notification.icon, notification.type)}" class="w-5 h-5 text-white"></i>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-slate-800 dark:text-white">${escapeHtml(notification.title)}</h4>
                                    ${!notification.is_read ? '<span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>' : ''}
                                </div>
                                <p class="text-slate-600 dark:text-slate-300 mt-1 text-sm leading-relaxed">${escapeHtml(notification.message)}</p>
                                
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        ${formatTime(notification.created_at)}
                                    </span>
                                    ${notification.creator ? `
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
                                            <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                            ${escapeHtml(notification.creator.name)}
                                        </span>
                                    ` : ''}
                                    ${notification.action_url ? `
                                        <span class="inline-flex items-center gap-1 text-xs text-blue-600 font-medium">
                                            <?php echo e(__('View details')); ?>

                                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                ${!notification.is_read ? `
                                    <button onclick="markAsRead(${notification.id})" class="action-btn read" title="<?php echo e(__('Mark as read')); ?>">
                                        <i data-lucide="check" class="w-4 h-4"></i>
                                    </button>
                                ` : ''}
                                <button onclick="deleteNotification(${notification.id})" class="action-btn delete" title="<?php echo e(__('Delete')); ?>">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

        container.innerHTML = html;
        
        // Re-initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function renderPagination(data) {
        const paginationContainer = document.getElementById('notifications-pagination');

        if (!data || data.last_page <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let paginationHtml = '<div class="flex items-center gap-2">';

        // Previous button
        if (data.current_page > 1) {
            paginationHtml += `
                <button onclick="window.loadNotificationsPage(${data.current_page - 1})" class="pagination-btn flex items-center gap-1">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    <?php echo e(__('Previous')); ?>

                </button>
            `;
        }

        // Page numbers
        const start = Math.max(1, data.current_page - 2);
        const end = Math.min(data.last_page, data.current_page + 2);

        if (start > 1) {
            paginationHtml += `<button onclick="window.loadNotificationsPage(1)" class="pagination-btn">1</button>`;
            if (start > 2) {
                paginationHtml += '<span class="px-2 text-slate-400">...</span>';
            }
        }

        for (let i = start; i <= end; i++) {
            const isActive = i === data.current_page;
            paginationHtml += `<button onclick="window.loadNotificationsPage(${i})" class="pagination-btn ${isActive ? 'active' : ''}">${i}</button>`;
        }

        if (end < data.last_page) {
            if (end < data.last_page - 1) {
                paginationHtml += '<span class="px-2 text-slate-400">...</span>';
            }
            paginationHtml += `<button onclick="window.loadNotificationsPage(${data.last_page})" class="pagination-btn">${data.last_page}</button>`;
        }

        // Next button
        if (data.current_page < data.last_page) {
            paginationHtml += `
                <button onclick="window.loadNotificationsPage(${data.current_page + 1})" class="pagination-btn flex items-center gap-1">
                    <?php echo e(__('Next')); ?>

                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            `;
        }

        paginationHtml += '</div>';
        paginationContainer.innerHTML = paginationHtml;
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Global functions
    window.loadNotificationsPage = function(page) {
        loadNotifications(page);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    window.handleNotificationClick = function(id, actionUrl) {
        // Mark as read first
        fetch(`<?php echo e(url('/notifications')); ?>/${id}/read`, {
            method: 'PATCH',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => {
            if (actionUrl) {
                window.location.href = actionUrl;
            } else {
                loadNotifications(currentPage);
            }
        });
    };

    window.markAsRead = function(id) {
        fetch(`<?php echo e(url('/notifications')); ?>/${id}/read`, {
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
                loadNotifications(currentPage);
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    };

    window.deleteNotification = function(id) {
        const doDelete = () => {
            fetch(`<?php echo e(url('/notifications')); ?>/${id}`, {
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
                    loadNotifications(currentPage);
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
            });
        };

        if (typeof window.confirmDelete === 'function') {
            window.confirmDelete('this notification', doDelete);
        } else if (confirm('<?php echo e(__("Are you sure you want to delete this notification?")); ?>')) {
            doDelete();
        }
    };

    // Helper functions
    function getIconName(icon, type) {
        if (icon) {
            const iconMap = {
                'UserPlus': 'user-plus',
                'UserMinus': 'user-minus',
                'UserCheck': 'user-check',
                'UserX': 'user-x',
                'InformationCircle': 'info',
                'CheckCircle': 'check-circle',
                'ExclamationCircle': 'alert-circle',
                'ExclamationTriangle': 'alert-triangle',
                'Bell': 'bell',
                'Mail': 'mail',
                'Calendar': 'calendar',
                'FileText': 'file-text',
                'Package': 'package',
                'DollarSign': 'dollar-sign',
                'ShoppingCart': 'shopping-cart',
                'Truck': 'truck'
            };
            return iconMap[icon] || icon.toLowerCase().replace(/([A-Z])/g, '-$1').toLowerCase().replace(/^-/, '');
        }

        switch (type) {
            case 'success': return 'check-circle';
            case 'error': return 'alert-circle';
            case 'warning': return 'alert-triangle';
            default: return 'bell';
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / (1000 * 60));

        if (diffInMinutes < 1) return '<?php echo e(__("Just now")); ?>';
        if (diffInMinutes < 60) return `${diffInMinutes}<?php echo e(__("m ago")); ?>`;

        const diffInHours = Math.floor(diffInMinutes / 60);
        if (diffInHours < 24) return `${diffInHours}<?php echo e(__("h ago")); ?>`;

        const diffInDays = Math.floor(diffInHours / 24);
        if (diffInDays < 7) return `${diffInDays}<?php echo e(__("d ago")); ?>`;

        return date.toLocaleDateString('<?php echo e(app()->getLocale()); ?>', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function showToast(icon, title, message = '') {
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: title,
                text: message
            });
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('../themes/' . $activeTheme . '/' . $activeLayout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\smart-erp\resources\views/notifications/index.blade.php ENDPATH**/ ?>