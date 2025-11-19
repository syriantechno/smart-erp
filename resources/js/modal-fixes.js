/**
 * Modal Fixes for Purchase Orders and other modals
 * Fixes issues with getScrollbarWidth and dispatchEvent
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Loading modal fixes...');

    // Fix getScrollbarWidth function
    if (typeof window.getScrollbarWidth === 'undefined') {
        window.getScrollbarWidth = function() {
            try {
                // Create a temporary div to measure scrollbar width
                const outer = document.createElement('div');
                outer.style.visibility = 'hidden';
                outer.style.overflow = 'scroll';
                outer.style.msOverflowStyle = 'scrollbar';
                document.body.appendChild(outer);

                const inner = document.createElement('div');
                outer.appendChild(inner);

                const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
                
                // Clean up
                if (outer.parentNode) {
                    outer.parentNode.removeChild(outer);
                }

                return scrollbarWidth || 0;
            } catch (error) {
                console.warn('Error calculating scrollbar width:', error);
                return 17; // Default scrollbar width
            }
        };
    }

    // Fix modal show/hide functions
    function fixModalFunctions() {
        // Override modal show function if it exists
        const originalShow = window.show;
        if (typeof originalShow === 'function') {
            window.show = function(element) {
                try {
                    if (!element) {
                        console.warn('Modal element is undefined');
                        return;
                    }
                    
                    // Ensure element has dispatchEvent method
                    if (typeof element.dispatchEvent !== 'function') {
                        console.warn('Element does not have dispatchEvent method');
                        return;
                    }
                    
                    return originalShow.call(this, element);
                } catch (error) {
                    console.error('Error in modal show function:', error);
                }
            };
        }
    }

    // Fix modal event handling
    function fixModalEvents() {
        // Add safe event dispatcher
        window.safeDispatchEvent = function(element, eventType, detail = {}) {
            try {
                if (!element || typeof element.dispatchEvent !== 'function') {
                    console.warn('Cannot dispatch event: invalid element');
                    return false;
                }

                const event = new CustomEvent(eventType, {
                    detail: detail,
                    bubbles: true,
                    cancelable: true
                });

                return element.dispatchEvent(event);
            } catch (error) {
                console.error('Error dispatching event:', error);
                return false;
            }
        };
    }

    // Fix modal initialization
    function fixModalInit() {
        // Wait for DOM to be fully loaded
        setTimeout(() => {
            try {
                // Find all modal triggers
                const modalTriggers = document.querySelectorAll('[data-tw-toggle="modal"]');
                
                modalTriggers.forEach(trigger => {
                    // Remove existing event listeners to prevent conflicts
                    const newTrigger = trigger.cloneNode(true);
                    if (trigger.parentNode) {
                        trigger.parentNode.replaceChild(newTrigger, trigger);
                    }
                    
                    // Add safe event listener
                    newTrigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('data-tw-target');
                        if (!targetId) {
                            console.warn('No target specified for modal trigger');
                            return;
                        }
                        
                        const modal = document.querySelector(targetId);
                        if (!modal) {
                            console.warn('Modal not found:', targetId);
                            return;
                        }
                        
                        try {
                            // Show modal safely
                            modal.style.display = 'flex';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                            
                            // Add backdrop if not exists
                            let backdrop = document.querySelector('.modal-backdrop');
                            if (!backdrop) {
                                backdrop = document.createElement('div');
                                backdrop.className = 'modal-backdrop fade show';
                                document.body.appendChild(backdrop);
                            }
                            
                            // Focus management
                            const firstInput = modal.querySelector('input, select, textarea, button');
                            if (firstInput) {
                                setTimeout(() => firstInput.focus(), 100);
                            }
                            
                            console.log('✅ Modal opened successfully:', targetId);
                        } catch (error) {
                            console.error('Error opening modal:', error);
                        }
                    });
                });
                
                // Fix modal close buttons
                const closeButtons = document.querySelectorAll('[data-tw-dismiss="modal"]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const modal = this.closest('.modal');
                        if (modal) {
                            try {
                                modal.style.display = 'none';
                                modal.classList.remove('show');
                                document.body.classList.remove('modal-open');
                                
                                // Remove backdrop
                                const backdrop = document.querySelector('.modal-backdrop');
                                if (backdrop) {
                                    backdrop.remove();
                                }
                                
                                console.log('✅ Modal closed successfully');
                            } catch (error) {
                                console.error('Error closing modal:', error);
                            }
                        }
                    });
                });
                
            } catch (error) {
                console.error('Error fixing modal initialization:', error);
            }
        }, 500);
    }

    // Apply all fixes
    fixModalFunctions();
    fixModalEvents();
    fixModalInit();

    // Fix for Bootstrap modal if it exists
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const originalModalShow = bootstrap.Modal.prototype.show;
        bootstrap.Modal.prototype.show = function() {
            try {
                return originalModalShow.call(this);
            } catch (error) {
                console.error('Bootstrap modal show error:', error);
                // Fallback to simple show
                if (this._element) {
                    this._element.style.display = 'flex';
                    this._element.classList.add('show');
                }
            }
        };
    }

    // Add CSS fixes for modals
    const style = document.createElement('style');
    style.textContent = `
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
        }
        
        .modal.show {
            display: flex !important;
        }
        
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-open {
            overflow: hidden;
        }
        
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 0.5rem;
            pointer-events: none;
        }
        
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
        }
        
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto;
            }
        }
    `;
    document.head.appendChild(style);

    console.log('✅ Modal fixes loaded successfully');
});

// Export for use in other scripts
window.modalFixes = {
    safeDispatchEvent: window.safeDispatchEvent,
    getScrollbarWidth: window.getScrollbarWidth
};
