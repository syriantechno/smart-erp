// Accessibility Fixes for Smart ERP
document.addEventListener('DOMContentLoaded', function() {
    
    // Fix aria-hidden focus issues
    function fixAriaHiddenFocus() {
        const modals = document.querySelectorAll('[aria-hidden="true"]');
        
        modals.forEach(modal => {
            // Check if modal contains focused elements
            const focusedElement = modal.querySelector(':focus');
            if (focusedElement) {
                // Remove aria-hidden when element has focus
                modal.removeAttribute('aria-hidden');
                
                // Add it back when focus is lost
                focusedElement.addEventListener('blur', function() {
                    setTimeout(() => {
                        if (!modal.contains(document.activeElement)) {
                            modal.setAttribute('aria-hidden', 'true');
                        }
                    }, 100);
                });
            }
        });
    }

    // Fix modal focus management
    function fixModalFocus() {
        const modalTriggers = document.querySelectorAll('[data-tw-toggle="modal"]');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const targetId = this.getAttribute('data-tw-target');
                if (targetId) {
                    const modal = document.querySelector(targetId);
                    if (modal) {
                        // Remove aria-hidden when modal opens
                        setTimeout(() => {
                            modal.removeAttribute('aria-hidden');
                            
                            // Focus first focusable element in modal
                            const firstFocusable = modal.querySelector('input, button, select, textarea, [tabindex]:not([tabindex="-1"])');
                            if (firstFocusable) {
                                firstFocusable.focus();
                            }
                        }, 100);
                    }
                }
            });
        });
    }

    // Fix keyboard navigation
    function fixKeyboardNavigation() {
        document.addEventListener('keydown', function(e) {
            // ESC key to close modals
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    const closeBtn = modal.querySelector('[data-tw-dismiss="modal"]');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                });
            }
            
            // Tab key navigation within modals
            if (e.key === 'Tab') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const focusableElements = openModal.querySelectorAll(
                        'input, button, select, textarea, [tabindex]:not([tabindex="-1"])'
                    );
                    
                    if (focusableElements.length > 0) {
                        const firstElement = focusableElements[0];
                        const lastElement = focusableElements[focusableElements.length - 1];
                        
                        if (e.shiftKey && document.activeElement === firstElement) {
                            e.preventDefault();
                            lastElement.focus();
                        } else if (!e.shiftKey && document.activeElement === lastElement) {
                            e.preventDefault();
                            firstElement.focus();
                        }
                    }
                }
            }
        });
    }

    // Add ARIA labels to buttons without text
    function addAriaLabels() {
        const iconButtons = document.querySelectorAll('button:not([aria-label]):not([title])');
        iconButtons.forEach(button => {
            const icon = button.querySelector('[data-lucide]');
            if (icon && !button.textContent.trim()) {
                const iconName = icon.getAttribute('data-lucide');
                button.setAttribute('aria-label', iconName.charAt(0).toUpperCase() + iconName.slice(1));
            }
        });
    }

    // Initialize all fixes
    fixAriaHiddenFocus();
    fixModalFocus();
    fixKeyboardNavigation();
    addAriaLabels();

    // Re-run fixes when new content is loaded (for AJAX)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                fixAriaHiddenFocus();
                addAriaLabels();
            }
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    console.log('✅ Accessibility fixes loaded');
});
