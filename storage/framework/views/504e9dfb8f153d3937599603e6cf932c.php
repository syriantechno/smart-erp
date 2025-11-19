<?php if (! $__env->hasRenderedOnce('1932d3ed-0f8b-4cd0-b097-1cb15249c779')): $__env->markAsRenderedOnce('1932d3ed-0f8b-4cd0-b097-1cb15249c779');
$__env->startPush('scripts'); ?>
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
        const companyTableSection = document.getElementById('company-table-section');

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
                if (companyTableSection) {
                    companyTableSection.classList.toggle('hidden', tabName !== 'company');
                }
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

                fetch('<?php echo e(route("settings.update")); ?>', {
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

            const appLogoInput = document.getElementById('app_logo');
            const appLogoPreview = document.getElementById('app-logo-preview');
            const appLogoPlaceholder = document.getElementById('app-logo-placeholder');
            const appLogoResetBtn = document.getElementById('app-logo-reset');
            const resetAppLogoField = document.getElementById('reset_app_logo');

            function toggleAppLogoPreview(showPreview) {
                if (!appLogoPreview || !appLogoPlaceholder) return;
                appLogoPreview.classList.toggle('hidden', !showPreview);
                appLogoPlaceholder.classList.toggle('hidden', showPreview);
            }

            function resetAppLogoPreview() {
                if (appLogoPreview) {
                    appLogoPreview.src = '';
                }
                toggleAppLogoPreview(false);
                if (appLogoInput) {
                    appLogoInput.value = '';
                }
                if (resetAppLogoField) {
                    resetAppLogoField.value = '1';
                }
            }

            if (appLogoInput && appLogoPreview) {
                appLogoInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            appLogoPreview.src = e.target.result;
                            toggleAppLogoPreview(true);
                        };
                        reader.readAsDataURL(this.files[0]);
                        if (resetAppLogoField) {
                            resetAppLogoField.value = '0';
                        }
                    } else {
                        resetAppLogoPreview();
                    }
                });
            }

            if (appLogoResetBtn) {
                appLogoResetBtn.addEventListener('click', function () {
                    resetAppLogoPreview();
                    window.showToast('Application logo reset. Save to apply.', 'info');
                });
            }
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

                fetch('<?php echo e(route("settings.ai.update")); ?>', {
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

            // Test AI connection button
            const testBtn = document.getElementById('ai-test-connection-btn');
            if (testBtn && !testBtn.dataset.listenerAdded) {
                testBtn.dataset.listenerAdded = 'true';

                testBtn.addEventListener('click', function () {
                    const originalText = testBtn.textContent;
                    testBtn.disabled = true;
                    testBtn.textContent = 'Testing...';

                    fetch('<?php echo e(route("ai.interact")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            message: 'Test connection from settings page',
                            type: 'chat'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            window.showToast('AI connection is working correctly.', 'success');
                        } else {
                            const errorMsg = (data && data.error) ? data.error : 'Unable to connect to AI service. Please check your configuration.';
                            window.showToast(errorMsg, 'error');
                        }
                    })
                    .catch(() => {
                        window.showToast('Failed to contact AI service. Please verify server/API settings.', 'error');
                    })
                    .finally(() => {
                        testBtn.disabled = false;
                        testBtn.textContent = originalText;
                    });
                });
            }
        }

        // Handle Font Size Preview
        const fontSizeSelect = document.querySelector('select[name="font_size"]');
        if (fontSizeSelect) {
            // Apply current font size on page load
            applyFontSizePreview(fontSizeSelect.value);
            
            fontSizeSelect.addEventListener('change', function() {
                applyFontSizePreview(this.value);
            });
        }

        // Handle Appearance Settings Form with AJAX
        const appearanceForm = document.getElementById('appearance-settings-form');
        if (appearanceForm && !appearanceForm.dataset.listenerAdded) {
            console.log('Appearance settings form found');
            appearanceForm.dataset.listenerAdded = 'true';

            appearanceForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.textContent : '';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';
                }

                fetch('<?php echo e(route("settings.appearance.update")); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                    .then(async response => {
                        const contentType = response.headers.get('content-type') || '';
                        let data = null;

                        if (contentType.includes('application/json')) {
                            try {
                                data = await response.json();
                            } catch (e) {
                                console.error('Failed to parse JSON response for appearance settings', e);
                            }
                        }

                        if (data && data.success) {
                            window.showToast(data.message || 'Appearance settings updated successfully!', 'success');
                        } else if (data && data.errors) {
                            // Laravel validation errors
                            const firstError = Object.values(data.errors)[0][0] || 'Validation error';
                            window.showToast(firstError, 'error');
                        } else if (!response.ok) {
                            window.showToast('Server returned an error while saving appearance settings', 'error');
                        } else {
                            // Non-JSON but OK response (likely redirect HTML). Treat as success.
                            window.showToast('Appearance settings updated successfully!', 'success');
                        }
                    })
                    .catch(error => {
                        window.showToast('An error occurred while saving appearance settings', 'error');
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

                fetch('<?php echo e(route("settings.prefix.update")); ?>', {
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

                fetch('<?php echo e(route("settings.company.update")); ?>', {
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

                fetch('<?php echo e(route("settings.notifications.update")); ?>', {
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

                fetch('<?php echo e(route("settings.attendance.update")); ?>', {
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
        }

        const roleForms = document.querySelectorAll('.role-permissions-form');
        roleForms.forEach(form => {
            if (form.dataset.listenerAdded) {
                return;
            }
            form.dataset.listenerAdded = 'true';

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const roleId = this.getAttribute('data-role-id');
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn ? submitBtn.textContent : '';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';
                }

                fetch(`/settings/permissions/roles/${roleId}`, {
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
                        window.showToast(data.message || 'Role permissions updated successfully.', 'success');
                    } else {
                        window.showToast(data.message || 'Error updating role permissions', 'error');
                    }
                })
                .catch(error => {
                    window.showToast('An error occurred while updating role permissions', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        });
    } // Close initializeSettingsTabs function

    // Font Size Preview Function
    function applyFontSizePreview(fontSize) {
        // Remove existing font size classes
        document.body.classList.remove('small', 'medium', 'large', 'extra-large');
        
        // Add new font size class
        document.body.classList.add(fontSize);
        
        console.log('Applied font size preview:', fontSize);
        
        // Show notification
        if (typeof window.showToast === 'function') {
            window.showToast(`Font size changed to ${fontSize}. Save to make it permanent.`, 'info');
        }

        // Company table actions
        const companyTable = document.getElementById('settings-company-table');
        const companyLoadButtons = document.querySelectorAll('.company-load-btn');
        const companyExportBtn = document.getElementById('company-table-export');
        const companyRefreshBtn = document.getElementById('company-table-refresh');
        const companyLogoInput = document.getElementById('company_logo');
        const companyLogoPreview = document.getElementById('company-logo-preview');
        const companyLogoPlaceholder = document.getElementById('company-logo-placeholder');
        const companyLogoReset = document.getElementById('company-logo-reset');

        function toggleLogoPreview(showPreview) {
            if (!companyLogoPreview || !companyLogoPlaceholder) return;
            companyLogoPreview.classList.toggle('hidden', !showPreview);
            companyLogoPlaceholder.classList.toggle('hidden', showPreview);
        }

        function resetLogoPreview() {
            if (!companyLogoPreview) return;
            const defaultSrc = companyLogoPreview.dataset.initialSrc || '';
            companyLogoPreview.src = defaultSrc;
            toggleLogoPreview(!!defaultSrc);
            if (companyLogoInput) {
                companyLogoInput.value = '';
            }
        }

        if (companyLogoInput && companyLogoPreview) {
            companyLogoInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        companyLogoPreview.src = e.target.result;
                        toggleLogoPreview(true);
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    resetLogoPreview();
                }
            });
        }

        if (companyLogoReset) {
            companyLogoReset.addEventListener('click', function () {
                resetLogoPreview();
                window.showToast('Logo selection cleared.', 'info');
            });
        }

        function populateCompanyForm(payload) {
            if (!companyForm || !payload) return;
            const entries = {
                name: 'company_name',
                address: 'company_address',
                commercial_registration: 'commercial_registration',
                tax_number: 'tax_number',
                phone: 'company_phone',
                email: 'company_email',
                website: 'company_website',
                country: 'company_country',
                city: 'company_city',
                postal_code: 'postal_code'
            };

            Object.entries(entries).forEach(([key, inputId]) => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.value = payload[key] ?? '';
                }
            });
        }

        companyLoadButtons.forEach(button => {
            button.addEventListener('click', function () {
                const payload = this.dataset.company ? JSON.parse(this.dataset.company) : null;
                populateCompanyForm(payload);
                window.showToast('Company details loaded into the form.', 'success');
            });
        });

        if (companyExportBtn && companyTable) {
            companyExportBtn.addEventListener('click', function () {
                const rows = Array.from(companyTable.querySelectorAll('tbody tr'));
                if (!rows.length) {
                    window.showToast('No company data to export.', 'warning');
                    return;
                }

                const headers = ['Name', 'Commercial Registration', 'Tax Number', 'Phone', 'Email', 'Website', 'Country', 'City', 'Postal Code'];
                const csvRows = [headers.join(',')];

                rows.forEach(row => {
                    const payload = row.querySelector('.company-load-btn')?.dataset.company;
                    if (!payload) return;
                    const data = JSON.parse(payload);
                    const csvRow = [
                        data.name || '',
                        data.commercial_registration || '',
                        data.tax_number || '',
                        data.phone || '',
                        data.email || '',
                        data.website || '',
                        data.country || '',
                        data.city || '',
                        data.postal_code || ''
                    ].map(value => '"' + String(value).replace(/"/g, '""') + '"');
                    csvRows.push(csvRow.join(','));
                });

                const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'companies.csv';
                link.click();
                URL.revokeObjectURL(url);
            });
        }

        if (companyRefreshBtn) {
            companyRefreshBtn.addEventListener('click', function () {
                window.location.reload();
            });
        }
    }

</script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\laravel\smart-erp\resources\views/settings/partials/scripts.blade.php ENDPATH**/ ?>