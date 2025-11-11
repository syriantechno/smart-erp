@push('styles')
    <style>
        .global-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .toast-message {
            padding: 12px 24px;
            margin-bottom: 10px;
            border-radius: 4px;
            color: white;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease-out;
            min-width: 250px;
        }
        
        .toast-success {
            background-color: #10B981;
        }
        
        .toast-error {
            background-color: #EF4444;
        }
        
        .toast-icon {
            margin-right: 12px;
            font-size: 20px;
        }
        
        .toast-close {
            margin-left: 20px;
            cursor: pointer;
            font-weight: bold;
            opacity: 0.8;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
@endpush

<div id="global-toast-container" class="global-toast"></div>

@push('scripts')
<script>
    // Global toast notification function
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('global-toast-container');
        if (!container) return;
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type}`;
        
        // Set icon based on type
        const icon = type === 'success' ? '✓' : '✗';
        
        // Create toast content
        toast.innerHTML = `
            <span class="toast-icon">${icon}</span>
            <span class="toast-message-text">${message}</span>
            <span class="toast-close" onclick="this.parentElement.remove()">&times;</span>
        `;
        
        // Add to container
        container.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.5s forwards';
            toast.addEventListener('animationend', () => toast.remove());
        }, 5000);
    };
    
    // Add slide out animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
