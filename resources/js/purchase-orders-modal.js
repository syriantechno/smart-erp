/**
 * Purchase Orders Modal Enhancement
 * Specific fixes for purchase orders modal issues
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Loading Purchase Orders modal enhancements...');

    // Wait for everything to load
    setTimeout(() => {
        initializePurchaseOrderModal();
    }, 1000);
});

function initializePurchaseOrderModal() {
    try {
        // Find the modal trigger button
        const triggerBtn = document.querySelector('[data-tw-target="#create-po-modal"]');
        const modal = document.getElementById('create-po-modal');
        
        if (!triggerBtn || !modal) {
            console.warn('Purchase order modal elements not found');
            return;
        }

        // Remove existing event listeners
        const newTriggerBtn = triggerBtn.cloneNode(true);
        triggerBtn.parentNode.replaceChild(newTriggerBtn, triggerBtn);

        // Add enhanced click handler
        newTriggerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('🔧 Opening Purchase Order modal...');
            
            try {
                // Show modal with enhanced method
                showPurchaseOrderModal(modal);
            } catch (error) {
                console.error('Error opening modal:', error);
                // Fallback method
                modal.style.display = 'flex';
                modal.classList.add('show');
                document.body.classList.add('modal-open');
            }
        });

        // Setup close handlers
        setupModalCloseHandlers(modal);
        
        console.log('✅ Purchase Order modal enhanced successfully');
        
    } catch (error) {
        console.error('Error initializing Purchase Order modal:', error);
    }
}

function showPurchaseOrderModal(modal) {
    // Create and show backdrop
    let backdrop = document.querySelector('.modal-backdrop');
    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade';
        document.body.appendChild(backdrop);
    }
    
    // Force reflow
    backdrop.offsetHeight;
    backdrop.classList.add('show');
    
    // Show modal
    modal.style.display = 'flex';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
    
    // Focus management
    setTimeout(() => {
        const firstInput = modal.querySelector('input:not([readonly]), select, textarea');
        if (firstInput) {
            firstInput.focus();
        }
    }, 150);
    
    // Dispatch custom event
    try {
        const event = new CustomEvent('modal:shown', {
            detail: { modalId: 'create-po-modal' }
        });
        document.dispatchEvent(event);
    } catch (error) {
        console.warn('Could not dispatch modal event:', error);
    }
    
    console.log('✅ Purchase Order modal opened');
}

function hidePurchaseOrderModal(modal) {
    // Hide modal
    modal.classList.remove('show');
    
    // Remove backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('show');
        setTimeout(() => {
            if (backdrop.parentNode) {
                backdrop.parentNode.removeChild(backdrop);
            }
        }, 150);
    }
    
    // Hide modal after animation
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }, 150);
    
    // Dispatch custom event
    try {
        const event = new CustomEvent('modal:hidden', {
            detail: { modalId: 'create-po-modal' }
        });
        document.dispatchEvent(event);
    } catch (error) {
        console.warn('Could not dispatch modal event:', error);
    }
    
    console.log('✅ Purchase Order modal closed');
}

function setupModalCloseHandlers(modal) {
    // Close button handler
    const closeButtons = modal.querySelectorAll('[data-tw-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            hidePurchaseOrderModal(modal);
        });
    });
    
    // Backdrop click handler
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hidePurchaseOrderModal(modal);
        }
    });
    
    // Escape key handler
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            hidePurchaseOrderModal(modal);
        }
    });
}

// Global functions for external use
window.purchaseOrderModal = {
    show: function() {
        const modal = document.getElementById('create-po-modal');
        if (modal) {
            showPurchaseOrderModal(modal);
        }
    },
    hide: function() {
        const modal = document.getElementById('create-po-modal');
        if (modal) {
            hidePurchaseOrderModal(modal);
        }
    }
};

console.log('✅ Purchase Orders modal script loaded');
