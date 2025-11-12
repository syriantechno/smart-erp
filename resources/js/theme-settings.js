// Theme Customizer JavaScript for Settings Page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize theme customizer
    initializeThemeCustomizer();
});

function initializeThemeCustomizer() {
    // Setup color inputs
    setupColorInputs();

    // Setup font size preview
    setupFontSizePreview();

    // Update color preview on load
    updateColorPreview();
}

function setupColorInputs() {
    const colorInputs = document.querySelectorAll('input[type="color"]');
    const textInputs = document.querySelectorAll('input[name*="hex"]');

    // Sync color picker to text input
    colorInputs.forEach(input => {
        input.addEventListener('input', function() {
            const textInput = document.querySelector(`input[name="${this.name}_hex"]`);
            if (textInput) {
                textInput.value = this.value;
            }
            updateColorPreview();
        });
    });

    // Sync text input to color picker
    textInputs.forEach(input => {
        input.addEventListener('input', function() {
            const colorInputName = this.name.replace('_hex', '');
            const colorInput = document.querySelector(`input[name="${colorInputName}"]`);
            if (colorInput && /^#[0-9A-F]{6}$/i.test(this.value)) {
                colorInput.value = this.value;
                updateColorPreview();
            }
        });
    });
}

function updateColorPreview() {
    const primaryColor = document.querySelector('input[name="primary_color"]')?.value || '#1e40af';
    const secondaryColor = document.querySelector('input[name="secondary_color"]')?.value || '#7c3aed';
    const accentColor = document.querySelector('input[name="accent_color"]')?.value || '#06b6d4';

    const primaryPreview = document.getElementById('preview-primary');
    const secondaryPreview = document.getElementById('preview-secondary');
    const accentPreview = document.getElementById('preview-accent');

    if (primaryPreview) primaryPreview.style.backgroundColor = primaryColor;
    if (secondaryPreview) secondaryPreview.style.backgroundColor = secondaryColor;
    if (accentPreview) accentPreview.style.backgroundColor = accentColor;
}

function setupFontSizePreview() {
    const fontSizeSelect = document.querySelector('select[name="font_size"]');
    if (fontSizeSelect) {
        fontSizeSelect.addEventListener('change', function() {
            console.log('Selected font size:', this.value);
        });
    }
}

function resetToDefaults() {
    if (!confirm('Are you sure you want to reset all theme settings to defaults?')) {
        return;
    }

    // Reset color inputs
    document.querySelector('input[name="primary_color"]').value = '#1e40af';
    document.querySelector('input[name="primary_color_hex"]').value = '#1e40af';
    document.querySelector('input[name="secondary_color"]').value = '#7c3aed';
    document.querySelector('input[name="secondary_color_hex"]').value = '#7c3aed';
    document.querySelector('input[name="accent_color"]').value = '#06b6d4';
    document.querySelector('input[name="accent_color_hex"]').value = '#06b6d4';

    // Reset other inputs
    document.querySelector('select[name="font_size"]').value = 'medium';
    document.querySelector('input[name="dark_mode"]').checked = false;
    document.querySelector('input[name="sidebar_collapsed"]').checked = false;
    document.querySelector('input[name="animations_enabled"]').checked = true;

    // Update preview
    updateColorPreview();

    // Show success message
    showNotification('Settings reset to defaults successfully!', 'success');
}

function previewChanges() {
    updateColorPreview();
    showNotification('Preview updated! Changes are not saved yet.', 'info');
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.theme-notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create new notification
    const notification = document.createElement('div');
    notification.className = `theme-notification fixed top-4 right-4 z-50 px-4 py-2 rounded-lg text-sm font-medium shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        type === 'warning' ? 'bg-yellow-500 text-black' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Handle form submission
document.addEventListener('submit', function(e) {
    const form = e.target;
    if (form.action.includes('appearance')) {
        // Show loading state
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...';
        submitButton.disabled = true;

        // Re-enable after 5 seconds (in case of error)
        setTimeout(() => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }, 5000);
    }
});

// Make functions globally available
window.resetToDefaults = resetToDefaults;
window.previewChanges = previewChanges;
