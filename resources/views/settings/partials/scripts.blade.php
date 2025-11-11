@push('scripts')
<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.settings-tab');
        const contents = document.querySelectorAll('.settings-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all tabs
                tabs.forEach(t => {
                    t.classList.remove('bg-primary', 'text-white');
                    t.classList.add('text-slate-700', 'hover:bg-slate-100', 'dark:text-slate-300', 'dark:hover:bg-darkmode-400');
                });
                
                // Add active class to clicked tab
                this.classList.add('bg-primary', 'text-white');
                this.classList.remove('text-slate-700', 'hover:bg-slate-100', 'dark:text-slate-300', 'dark:hover:bg-darkmode-400');
                
                // Hide all contents
                contents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show target content
                document.getElementById(targetTab + '-content').classList.remove('hidden');
            });
        });

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
                        showToast(data.message || 'Settings updated successfully!', 'success');
                    } else {
                        showToast(data.message || 'Error updating settings', 'error');
                    }
                })
                .catch(error => {
                    showToast('An error occurred while saving', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
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
                        showToast(data.message || 'Prefix settings updated successfully!', 'success');
                    } else {
                        showToast(data.message || 'Error updating prefix settings', 'error');
                    }
                })
                .catch(error => {
                    showToast('An error occurred while saving', 'error');
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
                        showToast(data.message || 'Company settings updated successfully!', 'success');
                    } else {
                        showToast(data.message || 'Error updating company settings', 'error');
                    }
                })
                .catch(error => {
                    showToast('An error occurred while saving', 'error');
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

        // Add event listeners to all inputs
        document.querySelectorAll('.prefix-input, .padding-input, .start-number-input, .include-year-input').forEach(input => {
            input.addEventListener('input', function() {
                updatePreview(this.dataset.id);
            });
            input.addEventListener('change', function() {
                updatePreview(this.dataset.id);
            });
        });
    });
</script>
@endpush
