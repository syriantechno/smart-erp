# Approval System Documentation

## Overview
The Approval System provides a comprehensive workflow management solution for handling various types of requests within the ERP system. It supports multi-level approval processes, document generation, and automated notifications.

## Features

### ✅ Core Capabilities
- **Multi-level Approvals**: Configurable approval hierarchies
- **Request Types**: Support for various request categories
- **Document Generation**: Automatic document creation
- **Workflow Tracking**: Complete audit trail
- **Automated Notifications**: Email and in-system notifications
- **Dashboard Analytics**: Request tracking and reporting

### 🔄 Workflow Types
1. **Sequential Approval**: One level at a time
2. **Parallel Approval**: Multiple approvers simultaneously
3. **Conditional Approval**: Based on request parameters
4. **Escalation**: Automatic escalation if no response

## Technical Implementation

### Database Schema
```sql
-- Approval Requests Table
CREATE TABLE approval_requests (
    id BIGINT PRIMARY KEY,
    code VARCHAR(255) UNIQUE,
    title VARCHAR(255),
    description TEXT,
    type ENUM('leave_request', 'purchase_request', 'expense_claim', 'loan_request', 'overtime_request', 'training_request', 'equipment_request', 'other'),
    status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    request_data JSON NULL,
    amount DECIMAL(15,2) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    duration_days INT NULL,
    requester_id BIGINT,
    current_approver_id BIGINT NULL,
    department_id BIGINT NULL,
    company_id BIGINT NULL,
    approval_levels JSON NULL,
    current_level INT DEFAULT 1,
    rejection_reason TEXT NULL,
    attachments JSON NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Approval Logs Table
CREATE TABLE approval_logs (
    id BIGINT PRIMARY KEY,
    approval_request_id BIGINT,
    action ENUM('submitted', 'approved', 'rejected', 'commented', 'forwarded'),
    comments TEXT NULL,
    user_id BIGINT,
    level INT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Models

#### ApprovalRequest Model
```php
class ApprovalRequest extends Model
{
    protected $fillable = [
        'code', 'title', 'description', 'type', 'status', 'priority',
        'request_data', 'amount', 'start_date', 'end_date', 'duration_days',
        'requester_id', 'current_approver_id', 'department_id', 'company_id',
        'approval_levels', 'current_level', 'rejection_reason', 'attachments'
    ];

    protected $casts = [
        'request_data' => 'array',
        'approval_levels' => 'array',
        'attachments' => 'array',
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // Relationships
    public function requester() { return $this->belongsTo(User::class, 'requester_id'); }
    public function currentApprover() { return $this->belongsTo(User::class, 'current_approver_id'); }
    public function department() { return $this->belongsTo(Department::class); }
    public function company() { return $this->belongsTo(Company::class); }
    public function logs() { return $this->hasMany(ApprovalLog::class); }

    // Scopes
    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
    public function scopeRejected($query) { return $query->where('status', 'rejected'); }
    public function scopeForUser($query, $userId) { return $query->where('requester_id', $userId); }
    public function scopePendingMyApproval($query, $userId) { return $query->where('current_approver_id', $userId)->where('status', 'pending'); }

    // Methods
    public function approve($userId, $comments = null) { /* Implementation */ }
    public function reject($userId, $reason, $comments = null) { /* Implementation */ }
    public function canBeApprovedBy($userId) { /* Implementation */ }
}
```

#### ApprovalLog Model
```php
class ApprovalLog extends Model
{
    protected $fillable = [
        'approval_request_id', 'action', 'comments', 'user_id', 'level'
    ];

    // Relationships
    public function approvalRequest() { return $this->belongsTo(ApprovalRequest::class); }
    public function user() { return $this->belongsTo(User::class); }

    // Accessors
    public function getActionLabelAttribute() { /* Implementation */ }
    public function getFormattedDateAttribute() { /* Implementation */ }
}
```

## Configuration

### Approval Workflows Configuration
```php
// config/approvals.php
return [
    'workflows' => [
        'leave_request' => [
            'levels' => [
                ['role' => 'supervisor', 'condition' => 'days <= 3'],
                ['role' => 'manager', 'condition' => 'days > 3'],
                ['role' => 'hr_director', 'condition' => 'days > 14']
            ],
            'auto_approve' => [
                'condition' => 'days <= 1',
                'notify' => true
            ]
        ],
        'purchase_request' => [
            'levels' => [
                ['role' => 'department_head', 'condition' => 'amount <= 1000'],
                ['role' => 'finance_manager', 'condition' => 'amount <= 10000'],
                ['role' => 'ceo', 'condition' => 'amount > 10000']
            ]
        ],
        'expense_claim' => [
            'levels' => [
                ['role' => 'supervisor', 'condition' => 'amount <= 500'],
                ['role' => 'finance_manager', 'condition' => 'amount > 500']
            ]
        ]
    ],

    'escalation' => [
        'enabled' => true,
        'days_without_action' => 3,
        'escalate_to' => 'manager'
    ],

    'notifications' => [
        'email_enabled' => true,
        'in_app_enabled' => true,
        'reminder_days' => [1, 3, 7]
    ]
];
```

### Environment Variables
```env
# Approval System Settings
APPROVAL_AUTO_ESCALATION=true
APPROVAL_ESCALATION_DAYS=3
APPROVAL_EMAIL_NOTIFICATIONS=true
APPROVAL_REMINDER_DAYS=1,3,7
APPROVAL_MAX_ATTACHMENT_SIZE=5120
```

## API Endpoints

### Request Management
```http
GET    /approval-system              # List requests with tabs
POST   /approval-system              # Create new request
GET    /approval-system/{id}         # Get request details
PUT    /approval-system/{id}         # Update request
DELETE /approval-system/{id}         # Delete request (if allowed)
```

### Approval Actions
```http
POST   /approval-system/{id}/approve # Approve request
POST   /approval-system/{id}/reject  # Reject request
POST   /approval-system/{id}/forward # Forward to another approver
```

### Analytics
```http
GET    /approval-system/stats        # Get approval statistics
GET    /approval-system/analytics    # Detailed analytics
GET    /approval-system/datatable    # DataTable for requests
```

## Workflow Implementation

### Sequential Approval Process
```php
public function setupApprovalLevels($type, $amount, $departmentId)
{
    $levels = [];
    $workflow = config("approvals.workflows.{$type}");

    if (!$workflow) {
        // Default approval - department manager
        if ($departmentId) {
            $department = Department::find($departmentId);
            if ($department && $department->manager_id) {
                $levels[] = [
                    'level' => 1,
                    'approver_id' => $department->manager_id,
                    'role' => 'Department Manager'
                ];
            }
        }
        return $levels;
    }

    foreach ($workflow['levels'] as $index => $level) {
        // Evaluate conditions and assign approvers
        if ($this->evaluateCondition($level['condition'] ?? null, $amount, $departmentId)) {
            $approverId = $this->resolveApprover($level['role'], $departmentId);
            if ($approverId) {
                $levels[] = [
                    'level' => $index + 1,
                    'approver_id' => $approverId,
                    'role' => $level['role']
                ];
            }
        }
    }

    return $levels;
}

private function evaluateCondition($condition, $amount, $departmentId)
{
    if (!$condition) return true;

    // Simple condition evaluation
    if (str_contains($condition, 'amount')) {
        return eval("return {$amount} {$condition};");
    }

    if (str_contains($condition, 'days')) {
        $days = $this->duration_days ?? 0;
        return eval("return {$days} {$condition};");
    }

    return true;
}

private function resolveApprover($role, $departmentId)
{
    switch ($role) {
        case 'supervisor':
        case 'department_head':
            $department = Department::find($departmentId);
            return $department?->manager_id;

        case 'manager':
            // Find department manager or higher
            return $this->findHigherApprover($departmentId, 'manager');

        case 'finance_manager':
            return User::where('department_id', 1) // Finance department
                      ->whereHas('roles', fn($q) => $q->where('name', 'manager'))
                      ->first()?->id;

        case 'hr_director':
            return User::whereHas('roles', fn($q) => $q->where('name', 'hr_director'))
                      ->first()?->id;

        case 'ceo':
            return User::whereHas('roles', fn($q) => $q->where('name', 'ceo'))
                      ->first()?->id;

        default:
            return null;
    }
}
```

### Auto-approval Logic
```php
public function checkAutoApproval()
{
    $workflow = config("approvals.workflows.{$this->type}");

    if (isset($workflow['auto_approve'])) {
        $condition = $workflow['auto_approve']['condition'];

        if ($this->evaluateCondition($condition, $this->amount, $this->department_id)) {
            $this->update(['status' => 'approved']);

            // Log auto-approval
            $this->logs()->create([
                'action' => 'approved',
                'comments' => 'Auto-approved based on workflow rules',
                'user_id' => 1, // System user
                'level' => 0
            ]);

            // Send notification if configured
            if ($workflow['auto_approve']['notify'] ?? false) {
                $this->sendApprovalNotification();
            }

            return true;
        }
    }

    return false;
}
```

## Notification System

### Email Notifications
```php
public function sendApprovalNotification()
{
    $approver = $this->currentApprover;

    if (!$approver) return;

    Mail::to($approver->email)->send(new ApprovalRequestNotification($this));
}

public function sendRejectionNotification()
{
    $requester = $this->requester;

    Mail::to($requester->email)->send(new RequestRejectedNotification($this));
}
```

### In-App Notifications
```php
public function createInAppNotification($userId, $type, $message)
{
    Notification::create([
        'user_id' => $userId,
        'type' => $type,
        'title' => 'Approval Request Update',
        'message' => $message,
        'data' => ['request_id' => $this->id],
        'read_at' => null
    ]);
}
```

## Frontend Implementation

### Request Creation Form
```javascript
function submitApprovalRequest() {
    const formData = new FormData();
    formData.append('title', $('#request-title').val());
    formData.append('description', $('#request-description').val());
    formData.append('type', $('#request-type').val());
    formData.append('priority', $('#request-priority').val());

    // Add conditional fields
    if ($('#request-type').val() === 'leave_request') {
        formData.append('start_date', $('#start-date').val());
        formData.append('end_date', $('#end-date').val());
    }

    if ($('#request-amount').val()) {
        formData.append('amount', $('#request-amount').val());
    }

    // Add attachments
    const files = $('#attachments')[0].files;
    for (let i = 0; i < files.length; i++) {
        formData.append('attachments[]', files[i]);
    }

    fetch('/approval-system', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Request submitted successfully');
            $('#create-request-modal').modal('hide');
            refreshRequests();
        } else {
            showErrors(data.errors);
        }
    });
}
```

### Approval Actions
```javascript
function approveRequest(requestId) {
    Swal.fire({
        title: 'Approve Request',
        input: 'textarea',
        inputPlaceholder: 'Add approval comments (optional)',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/approval-system/${requestId}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    comments: result.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Request approved successfully');
                    refreshRequests();
                } else {
                    showError(data.message);
                }
            });
        }
    });
}

function rejectRequest(requestId) {
    Swal.fire({
        title: 'Reject Request',
        html: `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason *</label>
                <textarea id="rejection-reason" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3" placeholder="Please provide the reason for rejection"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Comments</label>
                <textarea id="rejection-comments" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="2" placeholder="Additional comments (optional)"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Reject Request',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const reason = document.getElementById('rejection-reason').value;
            const comments = document.getElementById('rejection-comments').value;

            if (!reason.trim()) {
                Swal.showValidationMessage('Rejection reason is required');
                return false;
            }

            return { reason, comments };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/approval-system/${requestId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess('Request rejected successfully');
                    refreshRequests();
                } else {
                    showError(data.message);
                }
            });
        }
    });
}
```

## Dashboard Analytics

### Statistics Cards
```php
public function getStats(): JsonResponse
{
    $userId = auth()->id();

    $stats = [
        'my_requests' => ApprovalRequest::forUser($userId)->count(),
        'pending_approval' => ApprovalRequest::pendingMyApproval($userId)->count(),
        'approved' => ApprovalRequest::approved()->where('requester_id', $userId)->count(),
        'rejected' => ApprovalRequest::rejected()->where('requester_id', $userId)->count(),
        'total_pending' => ApprovalRequest::pending()->count(),
        'avg_approval_time' => $this->calculateAverageApprovalTime(),
        'approval_rate' => $this->calculateApprovalRate(),
    ];

    return response()->json(['success' => true, 'stats' => $stats]);
}

private function calculateAverageApprovalTime()
{
    return ApprovalRequest::approved()
        ->where('updated_at', '>', now()->subDays(30))
        ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
        ->first()
        ->avg_hours ?? 0;
}

private function calculateApprovalRate()
{
    $total = ApprovalRequest::where('created_at', '>', now()->subDays(30))->count();
    $approved = ApprovalRequest::approved()->where('created_at', '>', now()->subDays(30))->count();

    return $total > 0 ? round(($approved / $total) * 100, 1) : 0;
}
```

## Security Implementation

### Access Control
```php
// Check if user can approve request
public function canBeApprovedBy($userId): bool
{
    return $this->status === 'pending' &&
           $this->current_approver_id == $userId;
}

// Check if user can view request
public function canBeViewedBy($userId): bool
{
    return $this->requester_id === $userId ||
           $this->current_approver_id === $userId ||
           $this->logs()->where('user_id', $userId)->exists();
}
```

### Audit Trail
```php
public function logAction($action, $userId, $comments = null, $level = null)
{
    $this->logs()->create([
        'action' => $action,
        'comments' => $comments,
        'user_id' => $userId,
        'level' => $level
    ]);

    // Log to system audit
    Log::info('Approval action', [
        'request_id' => $this->id,
        'action' => $action,
        'user_id' => $userId,
        'level' => $level
    ]);
}
```

## Performance Optimization

### Database Indexing
```sql
-- Optimize approval queries
CREATE INDEX idx_approval_requests_status_approver ON approval_requests (status, current_approver_id);
CREATE INDEX idx_approval_requests_requester ON approval_requests (requester_id);
CREATE INDEX idx_approval_requests_type_status ON approval_requests (type, status);
CREATE INDEX idx_approval_logs_request_action ON approval_logs (approval_request_id, action);
```

### Query Optimization
```php
// Optimized dashboard query
$requests = ApprovalRequest::with(['requester:id,name', 'currentApprover:id,name'])
    ->select(['id', 'code', 'title', 'type', 'status', 'priority', 'requester_id', 'current_approver_id', 'created_at'])
    ->when($status, fn($q) => $q->where('status', $status))
    ->when($type, fn($q) => $q->where('type', $type))
    ->orderBy('created_at', 'desc')
    ->paginate(25);
```

### Caching Strategy
```php
// Cache approval statistics
Cache::remember('approval_stats_' . $userId, 300, function () use ($userId) {
    return [
        'pending_count' => ApprovalRequest::pendingMyApproval($userId)->count(),
        'my_requests' => ApprovalRequest::forUser($userId)->count(),
        // ... other stats
    ];
});
```

## Error Handling

### Validation Errors
```php
$validator = Validator::make($request->all(), [
    'title' => 'required|string|max:255',
    'type' => 'required|in:leave_request,purchase_request,expense_claim,loan_request,overtime_request,training_request,equipment_request,other',
    'amount' => 'nullable|numeric|min:0',
    'start_date' => 'nullable|date',
    'end_date' => 'nullable|date|after:start_date',
    'attachments.*' => 'nullable|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png'
]);

if ($validator->fails()) {
    return response()->json([
        'success' => false,
        'errors' => $validator->errors()
    ], 422);
}
```

### Exception Handling
```php
try {
    DB::beginTransaction();

    // Approval logic
    $request->approve(auth()->id(), $request->comments);

    DB::commit();

    return response()->json(['success' => true]);

} catch (Exception $e) {
    DB::rollBack();

    Log::error('Approval failed', [
        'request_id' => $request->id,
        'user_id' => auth()->id(),
        'error' => $e->getMessage()
    ]);

    return response()->json([
        'success' => false,
        'message' => 'Failed to process approval'
    ], 500);
}
```

## Integration with Other Systems

### Email Integration
```php
// Send approval request email
Notification::route('mail', $approver->email)
    ->notify(new ApprovalRequestNotification($this));

// Integration with external systems
event(new ApprovalProcessed($this));
```

### Document Generation
```php
// Generate approval document
$document = $this->generateApprovalDocument();
$this->attachDocument($document);
```

### Workflow Automation
```php
// Trigger automated workflows
if ($this->status === 'approved') {
    $this->triggerPostApprovalWorkflow();
}
```

## Future Enhancements

### Planned Features
- **Advanced Workflows**: Conditional routing and parallel approvals
- **Mobile App**: Mobile approval interface
- **Digital Signatures**: Electronic signature integration
- **SLA Tracking**: Service level agreement monitoring
- **Bulk Approvals**: Approve multiple requests at once
- **Delegation**: Delegate approval authority

### API Extensions
- **Webhook Support**: Real-time notifications to external systems
- **REST API**: Full CRUD operations via API
- **GraphQL Support**: Flexible query interface
- **Third-party Integrations**: Connect with external approval systems

## Monitoring & Analytics

### Key Metrics
- **Approval Rate**: Percentage of approved requests
- **Average Approval Time**: Time from submission to approval
- **Request Volume**: Number of requests by type and period
- **User Activity**: Most active approvers and requesters
- **Bottleneck Analysis**: Identify slow approval processes

### Performance Dashboard
```php
public function getAnalytics()
{
    return [
        'approval_trends' => $this->getApprovalTrends(),
        'bottlenecks' => $this->identifyBottlenecks(),
        'efficiency_metrics' => $this->calculateEfficiencyMetrics(),
        'user_performance' => $this->getUserPerformanceStats()
    ];
}
```

## Troubleshooting

### Common Issues
1. **Approval Stuck**: Check workflow configuration and approver assignments
2. **Notification Failures**: Verify email settings and templates
3. **Permission Errors**: Check user roles and department assignments
4. **Slow Performance**: Optimize database queries and add caching

### Debug Mode
```env
APPROVAL_DEBUG=true
LOG_LEVEL=debug
```

### Support Resources
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Workflow Best Practices](https://en.wikipedia.org/wiki/Business_process_management)
- [Approval System Patterns](https://martinfowler.com/eaaCatalog/)

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
