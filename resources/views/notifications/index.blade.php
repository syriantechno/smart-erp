@extends('../themes/' . $activeTheme . '/' . $activeLayout)

@section('subhead')
    <title>Notifications - {{ config('app.name') }}</title>
@endsection

@include('components.datatable.styles')
@include('components.datatable.theme')

@section('subcontent')
    @include('components.global-notifications')

    <div class="intro-y mt-8 flex items-center justify-between">
        <h2 class="text-lg font-medium">Notifications</h2>

        <div class="flex items-center space-x-2">
            <button
                id="mark-all-read-btn"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
            >
                Mark All as Read
            </button>
            <button
                id="delete-all-btn"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
            >
                Delete All
            </button>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <x-base.preview-component class="intro-y box">
                <div class="p-5">
                    <div id="notifications-container">
                        {{-- Notifications will be loaded here --}}
                    </div>

                    {{-- Pagination --}}
                    <div id="notifications-pagination" class="mt-5"></div>
                </div>
            </x-base.preview-component>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const perPage = 20;

    loadNotifications(currentPage);

    // Mark all as read
    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
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
                showToast('success', 'Success', 'All notifications marked as read');
                loadNotifications(currentPage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', 'Failed to mark notifications as read');
        });
    });

    // Delete all
    document.getElementById('delete-all-btn').addEventListener('click', function() {
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
                showToast('success', 'Success', 'All notifications deleted');
                loadNotifications(currentPage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Error', 'Failed to delete notifications');
        });
    });

    function loadNotifications(page = 1) {
        currentPage = page;

        fetch(`{{ route('notifications.index') }}?page=${page}`, {
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
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
    }

    function renderNotifications(notifications) {
        const container = document.getElementById('notifications-container');

        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <x-base.lucide icon="Bell" class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                </div>
            `;
            return;
        }

        const html = notifications.map(notification => `
            <div class="flex items-start space-x-4 p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors ${!notification.is_read ? 'bg-blue-50' : ''}">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full flex items-center justify-center ${getTypeColor(notification.type)}">
                        <x-base.lucide icon="${getIconClass(notification.icon)}" class="h-5 w-5 text-white" />
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-medium text-gray-900">${notification.title}</h4>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500">${formatTime(notification.created_at)}</span>
                            <div class="flex space-x-1">
                                ${!notification.is_read ? `
                                    <button onclick="markAsRead(${notification.id})" class="text-blue-600 hover:text-blue-800 p-1" title="Mark as read">
                                        <x-base.lucide icon="Check" class="h-4 w-4" />
                                    </button>
                                ` : ''}
                                <button onclick="deleteNotification(${notification.id})" class="text-red-600 hover:text-red-800 p-1" title="Delete">
                                    <x-base.lucide icon="Trash" class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="mt-1 text-sm text-gray-600">${notification.message}</p>

                    ${notification.creator ? `
                        <p class="mt-2 text-xs text-gray-500">
                            Created by ${notification.creator.name}
                        </p>
                    ` : ''}

                    ${notification.action_url ? `
                        <a href="${notification.action_url}" class="mt-2 inline-flex items-center text-xs text-blue-600 hover:text-blue-800">
                            View details →
                        </a>
                    ` : ''}
                </div>
            </div>
        `).join('');

        container.innerHTML = html;
    }

    function renderPagination(data) {
        const paginationContainer = document.getElementById('notifications-pagination');

        if (data.last_page <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let paginationHtml = '<div class="flex items-center justify-between">';

        // Previous button
        if (data.current_page > 1) {
            paginationHtml += `<button onclick="loadNotifications(${data.current_page - 1})" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-l hover:bg-gray-50">Previous</button>`;
        }

        // Page numbers
        const start = Math.max(1, data.current_page - 2);
        const end = Math.min(data.last_page, data.current_page + 2);

        if (start > 1) {
            paginationHtml += `<button onclick="loadNotifications(1)" class="px-3 py-2 text-sm bg-white border border-gray-300 hover:bg-gray-50">1</button>`;
            if (start > 2) {
                paginationHtml += '<span class="px-2 py-2 text-sm text-gray-500">...</span>';
            }
        }

        for (let i = start; i <= end; i++) {
            const isActive = i === data.current_page;
            paginationHtml += `<button onclick="loadNotifications(${i})" class="px-3 py-2 text-sm border ${isActive ? 'bg-blue-500 text-white border-blue-500' : 'bg-white border-gray-300 hover:bg-gray-50'}">${i}</button>`;
        }

        if (end < data.last_page) {
            if (end < data.last_page - 1) {
                paginationHtml += '<span class="px-2 py-2 text-sm text-gray-500">...</span>';
            }
            paginationHtml += `<button onclick="loadNotifications(${data.last_page})" class="px-3 py-2 text-sm bg-white border border-gray-300 hover:bg-gray-50">${data.last_page}</button>`;
        }

        // Next button
        if (data.current_page < data.last_page) {
            paginationHtml += `<button onclick="loadNotifications(${data.current_page + 1})" class="px-3 py-2 text-sm bg-white border border-gray-300 rounded-r hover:bg-gray-50">Next</button>`;
        }

        paginationHtml += '</div>';
        paginationContainer.innerHTML = paginationHtml;
    }

    // Global functions
    window.markAsRead = function(id) {
        fetch(`{{ url('/notifications') }}/${id}/read`, {
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
        if (!confirm('Are you sure you want to delete this notification?')) {
            return;
        }

        fetch(`{{ url('/notifications') }}/${id}`, {
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

    // Helper functions
    function getTypeColor(type) {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };
        return colors[type] || colors.info;
    }

    function getIconClass(icon) {
        return icon || 'Bell';
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

    function showToast(icon, title, message = '') {
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
});
</script>
@endpush
