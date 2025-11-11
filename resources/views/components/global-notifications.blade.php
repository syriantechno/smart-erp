@pushOnce('styles')
    <style>
        #global-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .toast-wrapper {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.15);
            min-width: 260px;
            position: relative;
            animation: toast-slide-down 0.35s ease-out;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .toast-message {
            color: #64748b;
            font-size: 0.875rem;
        }

        .toast-icon-success {
            color: #22c55e;
        }

        .toast-icon-error {
            color: #ef4444;
        }

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
        }

        .toast-close-btn:hover {
            background-color: rgba(148, 163, 184, 0.35);
        }

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
    </style>
@endPushOnce

<div id="global-toast-container"></div>

<!-- Hidden templates -->
<div class="hidden">
    <div id="toast-template-success" class="toast-wrapper">
        <x-base.lucide icon="CheckCircle" class="toast-icon-success stroke-1.5 w-5 h-5"></x-base.lucide>
        <div class="ml-4 mr-4">
            <div class="toast-title">Success!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>

    <div id="toast-template-error" class="toast-wrapper">
        <x-base.lucide icon="XCircle" class="toast-icon-error stroke-1.5 w-5 h-5"></x-base.lucide>
        <div class="ml-4 mr-4">
            <div class="toast-title">Error!</div>
            <div class="toast-message"></div>
        </div>
        <button type="button" class="toast-close-btn">×</button>
    </div>
</div>

@pushOnce('scripts')
<script>
    function cloneToastTemplate(type, message) {
        const container = document.getElementById('global-toast-container');
        if (!container) return;

        const templateId = type === 'success' ? 'toast-template-success' : 'toast-template-error';
        const template = document.getElementById(templateId);
        if (!template) return;

        const node = template.cloneNode(true);
        node.id = '';
        node.classList.remove('hidden');
        node.querySelector('.toast-title').textContent = type === 'success' ? 'Success!' : 'Error!';
        node.querySelector('.toast-message').textContent = message;

        const closeBtn = node.querySelector('.toast-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                node.remove();
            });
        }

        container.appendChild(node);
        setTimeout(() => node.remove(), 5000);
    }

    window.showToast = function (message, type = 'success') {
        cloneToastTemplate(type, message || (type === 'success' ? 'Operation completed successfully.' : 'Something went wrong.'));
    };
</script>
@endPushOnce
