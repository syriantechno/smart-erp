/**
 * Purchase Orders Modal Enhancement
 * Specific fixes for purchase orders modal issues
 */

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        initializePurchaseOrderModal();
    }, 500);
});

function initializePurchaseOrderModal() {
    const modal = document.getElementById('create-po-modal');
    if (!modal || typeof tailwind === 'undefined' || !tailwind.Modal) {
        console.warn('Purchase order modal or tailwind modal plugin not available.');
        return;
    }

    const modalInstance = tailwind.Modal.getOrCreateInstance(modal);

    document.querySelectorAll('[data-tw-target="#create-po-modal"]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            modalInstance.show();
        });
    });

    window.purchaseOrderModal = {
        show: () => modalInstance.show(),
        hide: () => modalInstance.hide(),
    };
}

console.log('✅ Purchase Orders modal script loaded');
