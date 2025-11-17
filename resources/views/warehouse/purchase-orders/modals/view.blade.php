<x-base.dialog id="view-po-modal" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title>
            <h2 class="text-lg font-medium">Purchase Order Details</h2>
            <button type="button" class="text-slate-400" data-tw-dismiss="modal">
                <x-base.lucide icon="X" class="w-4 h-4" />
            </button>
        </x-base.dialog.title>

        <x-base.dialog.description class="p-5">
            <div id="po-details-content">
                <!-- Content will be loaded here -->
                <div class="flex items-center justify-center py-10">
                    <div class="text-center">
                        <i data-lucide="loader" class="w-8 h-8 animate-spin mx-auto text-primary"></i>
                        <p class="mt-2 text-slate-500">Loading...</p>
                    </div>
                </div>
            </div>
        </x-base.dialog.description>
    </x-base.dialog.panel>
</x-base.dialog>

<script>
function viewPurchaseOrder(id) {
    const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#view-po-modal'));
    modal.show();
    
    const jq = window.jQuery || window.$;
    if (!jq) return;

    // Load PO details
    jq.get('{{ route("warehouse.purchase-orders.show", ":id") }}'.replace(':id', id))
        .done(function(response) {
            if (response.success && response.purchase_order) {
                const po = response.purchase_order;
                renderPODetails(po);
            }
        })
        .fail(function() {
            jq('#po-details-content').html(`
                <div class="text-center py-10">
                    <i data-lucide="alert-circle" class="w-12 h-12 mx-auto text-danger"></i>
                    <p class="mt-2 text-slate-500">Failed to load purchase order details</p>
                </div>
            `);
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
}

function renderPODetails(po) {
    const jq = window.jQuery || window.$;
    
    const html = `
        <!-- Approval Wizard -->
        ${po.approval_request ? renderApprovalWizard(po.approval_request) : ''}
        
        <!-- PO Information -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Purchase Order Information
            </h3>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-600">Code</label>
                    <p class="text-slate-800 font-semibold">${po.code}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-600">Title</label>
                    <p class="text-slate-800">${po.title}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-600">Status</label>
                    <p>
                        <span class="px-2 py-1 text-xs font-medium rounded-full ${getStatusClass(po.status)}">
                            ${po.status.toUpperCase()}
                        </span>
                    </p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-600">Total Amount</label>
                    <p class="text-slate-800 font-semibold">${po.total_amount} USD</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-600">Order Date</label>
                    <p class="text-slate-800">${po.order_date}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-slate-600">Created By</label>
                    <p class="text-slate-800">${po.created_by?.name || 'N/A'}</p>
                </div>
                
                ${po.description ? `
                <div class="col-span-2">
                    <label class="text-sm font-medium text-slate-600">Description</label>
                    <p class="text-slate-800">${po.description}</p>
                </div>
                ` : ''}
            </div>
        </div>
        
        <!-- Approval Actions -->
        ${po.approval_request && po.approval_request.status === 'pending' && po.approval_request.current_approver_id === {{ auth()->id() }} ? `
        <div class="mt-6 pt-6 border-t">
            <div class="flex gap-3 justify-end">
                <button 
                    onclick="rejectApproval(${po.approval_request.id})"
                    class="btn btn-danger"
                >
                    <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                    Reject
                </button>
                <button 
                    onclick="approveApproval(${po.approval_request.id})"
                    class="btn btn-success"
                >
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    Approve
                </button>
            </div>
        </div>
        ` : ''}
    `;
    
    jq('#po-details-content').html(html);
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function renderApprovalWizard(approvalRequest) {
    const levels = approvalRequest.approval_levels || [];
    const currentLevel = approvalRequest.current_level || 1;
    const status = approvalRequest.status;
    
    let stepsHtml = '';
    levels.forEach((level, index) => {
        const levelNum = index + 1;
        const isCompleted = levelNum < currentLevel || status === 'approved';
        const isCurrent = levelNum === currentLevel && status === 'pending';
        const isRejected = status === 'rejected' && levelNum === currentLevel;
        
        let statusIcon = '';
        let statusClass = '';
        
        if (isCompleted) {
            statusIcon = '<i data-lucide="check-circle" class="w-5 h-5 text-success"></i>';
            statusClass = 'border-success bg-success/10';
        } else if (isCurrent) {
            statusIcon = '<i data-lucide="clock" class="w-5 h-5 text-warning"></i>';
            statusClass = 'border-warning bg-warning/10';
        } else if (isRejected) {
            statusIcon = '<i data-lucide="x-circle" class="w-5 h-5 text-danger"></i>';
            statusClass = 'border-danger bg-danger/10';
        } else {
            statusIcon = '<i data-lucide="circle" class="w-5 h-5 text-slate-300"></i>';
            statusClass = 'border-slate-300 bg-slate-50';
        }
        
        stepsHtml += `
            <div class="flex items-center ${index < levels.length - 1 ? 'flex-1' : ''}">
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 ${statusClass}">
                        ${statusIcon}
                    </div>
                    <p class="mt-2 text-sm font-medium text-slate-700">${level.name}</p>
                    <p class="text-xs text-slate-500">Level ${levelNum}</p>
                </div>
                ${index < levels.length - 1 ? `
                <div class="flex-1 h-0.5 mx-4 ${isCompleted ? 'bg-success' : 'bg-slate-200'}"></div>
                ` : ''}
            </div>
        `;
    });
    
    return `
        <div class="bg-slate-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <i data-lucide="git-branch" class="w-5 h-5"></i>
                Approval Workflow
            </h3>
            <div class="flex items-center justify-between">
                ${stepsHtml}
            </div>
            
            ${status === 'approved' ? `
            <div class="mt-4 p-3 bg-success/10 border border-success rounded-lg">
                <p class="text-success font-medium flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Fully Approved
                </p>
            </div>
            ` : ''}
            
            ${status === 'rejected' ? `
            <div class="mt-4 p-3 bg-danger/10 border border-danger rounded-lg">
                <p class="text-danger font-medium flex items-center gap-2">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    Rejected: ${approvalRequest.rejection_reason || 'No reason provided'}
                </p>
            </div>
            ` : ''}
        </div>
    `;
}

function getStatusClass(status) {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-700',
        'approved': 'bg-green-100 text-green-700',
        'shipped': 'bg-blue-100 text-blue-700',
        'delivered': 'bg-purple-100 text-purple-700',
        'cancelled': 'bg-red-100 text-red-700'
    };
    return classes[status] || 'bg-gray-100 text-gray-700';
}

function approveApproval(approvalRequestId) {
    Swal.fire({
        title: 'Approve Request',
        input: 'textarea',
        inputLabel: 'Comments (optional)',
        inputPlaceholder: 'Add your comments...',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        confirmButtonColor: '#10b981'
    }).then((result) => {
        if (result.isConfirmed) {
            const jq = window.jQuery || window.$;
            jq.post('{{ route("approval-system.approve", ":id") }}'.replace(':id', approvalRequestId), {
                comments: result.value,
                _token: jq('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                if (response.success) {
                    Swal.fire('Approved!', response.message, 'success');
                    jq('[data-tw-dismiss="modal"]').click();
                    if (purchaseOrdersTable) {
                        purchaseOrdersTable.ajax.reload();
                    }
                }
            })
            .fail(function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to approve', 'error');
            });
        }
    });
}

function rejectApproval(approvalRequestId) {
    Swal.fire({
        title: 'Reject Request',
        input: 'textarea',
        inputLabel: 'Reason for rejection',
        inputPlaceholder: 'Please provide a reason...',
        inputValidator: (value) => {
            if (!value) {
                return 'You need to provide a reason!'
            }
        },
        showCancelButton: true,
        confirmButtonText: 'Reject',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            const jq = window.jQuery || window.$;
            jq.post('{{ route("approval-system.reject", ":id") }}'.replace(':id', approvalRequestId), {
                reason: result.value,
                _token: jq('meta[name="csrf-token"]').attr('content')
            })
            .done(function(response) {
                if (response.success) {
                    Swal.fire('Rejected!', response.message, 'success');
                    jq('[data-tw-dismiss="modal"]').click();
                    if (purchaseOrdersTable) {
                        purchaseOrdersTable.ajax.reload();
                    }
                }
            })
            .fail(function(xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to reject', 'error');
            });
        }
    });
}
</script>
