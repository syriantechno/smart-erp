@pushonce('scripts')
<script>
    console.log('Settings scripts loaded successfully');

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing settings tabs');

        // Use a longer timeout to ensure all content is loaded
        setTimeout(function() {
            initializeSettingsTabs();
        }, 1000); // Increased from 100ms to 1000ms
    });

    function initializeSettingsTabs() {
        const tabs = document.querySelectorAll('.settings-tab');
        const contents = document.querySelectorAll('.settings-content');

        console.log('Found', tabs.length, 'tabs and', contents.length, 'contents');

        // Log all tab data attributes
        tabs.forEach((tab, index) => {
            console.log('Tab', index + 1, ':', tab.getAttribute('data-tab'));
        });

        // Log all content IDs
        contents.forEach((content, index) => {
            console.log('Content', index + 1, ':', content.id);
        });

        // Function to show specific tab content
        function showTab(tabName) {
            console.log('Showing tab:', tabName);

            // Remove active class from all tabs
            tabs.forEach(t => {
                t.classList.remove('bg-primary', 'text-white');
                t.classList.add('text-slate-700', 'hover:bg-slate-100', 'dark:text-slate-300', 'dark:hover:bg-darkmode-400');
            });

            // Hide all contents
            contents.forEach(content => {
                content.classList.add('hidden');
            });

            // Show target content and activate tab
            const targetTab = document.querySelector(`[data-tab="${tabName}"]`);
            const targetContent = document.getElementById(tabName + '-content');

            if (targetTab && targetContent) {
                targetTab.classList.add('bg-primary', 'text-white');
                targetTab.classList.remove('text-slate-700', 'hover:bg-slate-100', 'dark:text-slate-300', 'dark:hover:bg-darkmode-400');
                targetContent.classList.remove('hidden');
                console.log('Successfully showed tab:', tabName);
            } else {
                console.error('Tab or content not found:', tabName, targetTab, targetContent);
                console.error('Available tabs:', Array.from(tabs).map(t => t.getAttribute('data-tab')));
                console.error('Available contents:', Array.from(contents).map(c => c.id));
            }
        }

        // Add click event to all tabs
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-tab');
                showTab(targetTab);
            });
        });

        // Show default tab (general)
        console.log('Setting default tab to general');
        showTab('general');

        // Auto-open specific tab if URL contains hash
        if (window.location.hash) {
            const tabName = window.location.hash.substring(1); // Remove #
            if (document.getElementById(tabName + '-content')) {
                showTab(tabName);
            }
        }

        // Handle General Settings Form with AJAX
        const generalForm = document.getElementById('generalSettingsForm');
        if (generalForm) {
            console.log('General form found');
            generalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';

                fetch('{{ route("settings.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'Settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        }

        // Handle AI Settings Form with AJAX
        const aiForm = document.getElementById('ai-settings-form');
        if (aiForm && !aiForm.dataset.listenerAdded) {
            console.log('AI settings form found');
            aiForm.dataset.listenerAdded = 'true';

            aiForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                // The submit button is outside the form and linked via form="ai-settings-form"
                let submitBtn = this.querySelector('button[type="submit"]');
                if (!submitBtn) {
                    submitBtn = document.querySelector('button[form="ai-settings-form"]');
                }
                const originalText = submitBtn ? submitBtn.textContent : '';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';
                }

                fetch('{{ route("settings.ai.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'AI settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating AI settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving AI settings', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });

            // Provider toggle
            const providerSelect = document.getElementById('ai_provider');
            const openaiSection = document.getElementById('openai-settings');
            const ollamaSection = document.getElementById('ollama-settings');

            function toggleAiProviderSections() {
                if (!providerSelect || !openaiSection || !ollamaSection) return;
                const provider = providerSelect.value;
                if (provider === 'ollama') {
                    openaiSection.classList.add('hidden');
                    ollamaSection.classList.remove('hidden');
                } else {
                    openaiSection.classList.remove('hidden');
                    ollamaSection.classList.add('hidden');
                }
            }

            if (providerSelect) {
                providerSelect.addEventListener('change', toggleAiProviderSections);
                toggleAiProviderSections();
            }
        }

        // Handle Prefix Settings Form with AJAX
        const prefixForm = document.querySelector('#prefixForm');
        if (prefixForm && !prefixForm.dataset.listenerAdded) {
            console.log('Prefix form found');
            prefixForm.dataset.listenerAdded = 'true';

            prefixForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';

                fetch('{{ route("settings.prefix.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'Prefix settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating prefix settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // Handle Company Settings Form with AJAX
        const companyForm = document.getElementById('companySettingsForm');
        if (companyForm && !companyForm.dataset.listenerAdded) {
            console.log('Company form found');
            companyForm.dataset.listenerAdded = 'true';

            companyForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';

                fetch('{{ route("settings.company.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'Company settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating company settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // Handle Notification Settings Form with AJAX
        const notificationForm = document.getElementById('notification-settings-form');
        if (notificationForm && !notificationForm.dataset.listenerAdded) {
            console.log('Notification settings form found');
            notificationForm.dataset.listenerAdded = 'true';

            notificationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';

                fetch('{{ route("settings.notifications.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'Notification settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating notification settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving notification settings', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
        }

        // Preview functionality for prefix settings
        function updatePreview(id) {
            const prefix = document.querySelector(`.prefix-input[data-id="${id}"]`)?.value;
            const padding = parseInt(document.querySelector(`.padding-input[data-id="${id}"]`)?.value);
            const startNumber = parseInt(document.querySelector(`.start-number-input[data-id="${id}"]`)?.value);
            const includeYear = document.querySelector(`.include-year-input[data-id="${id}"]`)?.checked;

            if (!prefix || !padding || !startNumber) return;

            const number = String(startNumber).padStart(padding, '0');
            const year = new Date().getFullYear();

            let preview = includeYear ? `${prefix}-${year}-${number}` : `${prefix}-${number}`;

            const previewElement = document.getElementById(`preview-${id}`);
            if (previewElement) {
                previewElement.textContent = preview;
            }
        }

        // Initialize prefix preview functionality
        function initializePrefixPreview() {
            // Add event listeners to all prefix input fields
            document.querySelectorAll('.prefix-input, .padding-input, .start-number-input, .include-year-input').forEach(input => {
                const id = input.getAttribute('data-id');
                if (id) {
                    input.addEventListener('input', () => updatePreview(id));
                    input.addEventListener('change', () => updatePreview(id));
                }
            });

            // Update all previews on page load
            document.querySelectorAll('.prefix-input').forEach(input => {
                const id = input.getAttribute('data-id');
                if (id) {
                    updatePreview(id);
                }
            });
        }

        // Initialize prefix preview when DOM is ready
        initializePrefixPreview();

        // Handle Attendance Settings Form with AJAX
        const attendanceForm = document.getElementById('attendance-settings-form');
        if (attendanceForm && !attendanceForm.dataset.listenerAdded) {
            console.log('Attendance form found');
            attendanceForm.dataset.listenerAdded = 'true';

            attendanceForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';

                fetch('{{ route("settings.attendance.update") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.showToast(data.message || 'Attendance settings updated successfully!', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating attendance settings', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while saving', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
            });
    } // Close initializeSettingsTabs function
} // Close DOMContentLoaded event listener
</script>
@endpushonce
