# Electronic Mail System Documentation

## Overview
The Electronic Mail System provides a comprehensive email management solution within the ERP system, allowing users to send, receive, and manage emails with advanced features like attachments, templates, and search capabilities.

## Features

### 📧 Core Capabilities
- **Email Composition**: Rich text email composition
- **Attachment Support**: File attachments with size limits
- **Email Templates**: Pre-built email templates
- **Folder Organization**: Inbox, Sent, Draft, Archive folders
- **Advanced Search**: Full-text search and filtering
- **Email Threads**: Conversation threading

### 🔧 Advanced Features
- **Signature Management**: Custom email signatures
- **Priority Levels**: High, Normal, Low priority
- **Email Scheduling**: Schedule emails for later sending
- **Read Receipts**: Track email read status
- **Email Encryption**: Secure email transmission
- **Spam Filtering**: Automatic spam detection

## Technical Implementation

### Database Schema
```sql
-- Electronic Mails Table
CREATE TABLE electronic_mails (
    id BIGINT PRIMARY KEY,
    code VARCHAR(255) UNIQUE,
    subject VARCHAR(255),
    content TEXT,
    type ENUM('incoming', 'outgoing') DEFAULT 'incoming',
    status ENUM('draft', 'sent', 'received', 'read', 'archived') DEFAULT 'draft',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    sender_name VARCHAR(255) NULL,
    sender_email VARCHAR(255) NULL,
    sender_user_id BIGINT NULL,
    recipient_name VARCHAR(255) NULL,
    recipient_email VARCHAR(255) NULL,
    recipient_user_id BIGINT NULL,
    attachments JSON NULL,
    cc JSON NULL,
    bcc JSON NULL,
    parent_id BIGINT NULL,
    is_starred BOOLEAN DEFAULT FALSE,
    is_read BOOLEAN DEFAULT FALSE,
    department_id BIGINT NULL,
    company_id BIGINT NULL,
    sent_at TIMESTAMP NULL,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Email Templates Table
CREATE TABLE email_templates (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    subject VARCHAR(255),
    content TEXT,
    category VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Email Signatures Table
CREATE TABLE email_signatures (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    content TEXT,
    user_id BIGINT,
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Models

#### ElectronicMail Model
```php
class ElectronicMail extends Model
{
    protected $fillable = [
        'code', 'subject', 'content', 'type', 'status', 'priority',
        'sender_name', 'sender_email', 'sender_user_id',
        'recipient_name', 'recipient_email', 'recipient_user_id',
        'attachments', 'cc', 'bcc', 'parent_id', 'is_starred', 'is_read',
        'department_id', 'company_id', 'sent_at', 'read_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'is_starred' => 'boolean',
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
        'read_at' => 'datetime'
    ];

    // Relationships
    public function sender() { return $this->belongsTo(User::class, 'sender_user_id'); }
    public function recipient() { return $this->belongsTo(User::class, 'recipient_user_id'); }
    public function department() { return $this->belongsTo(Department::class); }
    public function company() { return $this->belongsTo(Company::class); }
    public function replies() { return $this->hasMany(ElectronicMail::class, 'parent_id'); }

    // Scopes
    public function scopeInbox($query, $userId) {
        return $query->where('recipient_user_id', $userId)
                    ->where('type', 'incoming');
    }

    public function scopeSent($query, $userId) {
        return $query->where('sender_user_id', $userId)
                    ->where('type', 'outgoing');
    }

    public function scopeStarred($query, $userId) {
        return $query->where('is_starred', true)
                    ->where(function ($q) use ($userId) {
                        $q->where('sender_user_id', $userId)
                          ->orWhere('recipient_user_id', $userId);
                    });
    }

    // Methods
    public function markAsRead() {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
                'status' => 'read'
            ]);
        }
    }

    public function toggleStar() {
        $this->update(['is_starred' => !$this->is_starred]);
    }
}
```

## Configuration

### Email Configuration
```php
// config/mail.php
return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
        ],
        'internal' => [
            'transport' => 'internal',
        ],
    ],
];
```

### Email System Settings
```php
// config/email.php
return [
    'max_attachment_size' => env('EMAIL_MAX_ATTACHMENT_SIZE', 10240), // KB
    'allowed_extensions' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'jpg', 'jpeg', 'png', 'gif'],
    'max_recipients' => env('EMAIL_MAX_RECIPIENTS', 50),
    'enable_read_receipts' => env('EMAIL_READ_RECEIPTS', true),
    'auto_archive_days' => env('EMAIL_AUTO_ARCHIVE_DAYS', 365),

    'templates' => [
        'welcome' => 'Welcome to our system',
        'notification' => 'System Notification',
        'approval' => 'Approval Request',
        'rejection' => 'Request Rejected',
    ],

    'folders' => [
        'inbox' => 'Inbox',
        'sent' => 'Sent',
        'draft' => 'Draft',
        'archive' => 'Archive',
        'trash' => 'Trash',
        'starred' => 'Starred',
    ]
];
```

### Environment Variables
```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Email System Settings
EMAIL_MAX_ATTACHMENT_SIZE=10240
EMAIL_MAX_RECIPIENTS=50
EMAIL_READ_RECEIPTS=true
EMAIL_AUTO_ARCHIVE_DAYS=365
```

## API Endpoints

### Email Management
```http
GET    /electronic-mail              # List emails with folders
POST   /electronic-mail              # Send new email
GET    /electronic-mail/compose      # Compose email form
GET    /electronic-mail/{id}         # View email details
PUT    /electronic-mail/{id}         # Update email (draft)
DELETE /electronic-mail/{id}         # Delete email
```

### Email Actions
```http
POST   /electronic-mail/{id}/star    # Star/unstar email
POST   /electronic-mail/{id}/read    # Mark as read
POST   /electronic-mail/{id}/archive # Archive email
POST   /electronic-mail/{id}/reply   # Reply to email
```

### Email Features
```http
GET    /electronic-mail/search       # Search emails
GET    /electronic-mail/templates    # Get email templates
POST   /electronic-mail/draft        # Save as draft
POST   /electronic-mail/schedule     # Schedule email
```

## Email Composition

### Rich Text Editor
```javascript
// Initialize TinyMCE or similar rich text editor
tinymce.init({
    selector: '#email-content',
    plugins: 'lists link image code',
    toolbar: 'bold italic underline | bullist numlist | link image | code',
    height: 300,
    menubar: false
});
```

### Attachment Handling
```javascript
function handleFileAttachment(files) {
    const maxSize = {{ config('email.max_attachment_size') }} * 1024; // Convert to bytes
    const allowedTypes = {{ json_encode(config('email.allowed_extensions')) }};

    for (let file of files) {
        // Validate file size
        if (file.size > maxSize) {
            showError(`File ${file.name} is too large. Maximum size is ${maxSize / 1024}MB`);
            continue;
        }

        // Validate file type
        const extension = file.name.split('.').pop().toLowerCase();
        if (!allowedTypes.includes(extension)) {
            showError(`File type ${extension} is not allowed`);
            continue;
        }

        // Add to attachment list
        addAttachment(file);
    }
}
```

### Email Sending Process
```php
public function sendEmail(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
        'recipients' => 'required|array|min:1',
        'recipients.*' => 'email',
        'cc' => 'nullable|array',
        'bcc' => 'nullable|array',
        'attachments.*' => 'nullable|file|max:10240',
        'priority' => 'nullable|in:low,normal,high,urgent',
        'scheduled_at' => 'nullable|date|after:now'
    ]);

    try {
        DB::beginTransaction();

        $email = ElectronicMail::create([
            'code' => $this->codeGenerator->generate('electronic_mails'),
            'subject' => $request->subject,
            'content' => $request->content,
            'type' => 'outgoing',
            'status' => $request->scheduled_at ? 'draft' : 'sent',
            'priority' => $request->priority ?? 'normal',
            'sender_name' => auth()->user()->name,
            'sender_email' => auth()->user()->email,
            'sender_user_id' => auth()->id(),
            'sent_at' => $request->scheduled_at ? null : now(),
        ]);

        // Handle recipients
        $this->processRecipients($email, $request->recipients, $request->cc, $request->bcc);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            $this->processAttachments($email, $request->file('attachments'));
        }

        // Send email or schedule
        if ($request->scheduled_at) {
            $this->scheduleEmail($email, $request->scheduled_at);
        } else {
            $this->deliverEmail($email);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => $request->scheduled_at ? 'Email scheduled successfully' : 'Email sent successfully',
            'email' => $email
        ]);

    } catch (Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to send email: ' . $e->getMessage()
        ], 500);
    }
}
```

## Folder Management

### Email Folders Implementation
```php
public function getEmailsByFolder($folder, $userId)
{
    switch ($folder) {
        case 'inbox':
            return ElectronicMail::inbox($userId)
                                ->where('status', '!=', 'archived')
                                ->orderBy('created_at', 'desc');

        case 'sent':
            return ElectronicMail::sent($userId)
                                ->where('status', 'sent')
                                ->orderBy('sent_at', 'desc');

        case 'draft':
            return ElectronicMail::where('sender_user_id', $userId)
                                ->where('status', 'draft')
                                ->orderBy('updated_at', 'desc');

        case 'starred':
            return ElectronicMail::starred($userId)
                                ->orderBy('created_at', 'desc');

        case 'archived':
            return ElectronicMail::where(function ($q) use ($userId) {
                $q->where('sender_user_id', $userId)
                  ->orWhere('recipient_user_id', $userId);
            })
            ->where('status', 'archived')
            ->orderBy('updated_at', 'desc');

        default:
            return collect();
    }
}
```

## Search and Filtering

### Advanced Search Implementation
```php
public function searchEmails(Request $request, $userId)
{
    $query = ElectronicMail::where(function ($q) use ($userId) {
        $q->where('sender_user_id', $userId)
          ->orWhere('recipient_user_id', $userId);
    });

    // Text search
    if ($request->filled('q')) {
        $searchTerm = $request->q;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('subject', 'like', "%{$searchTerm}%")
              ->orWhere('content', 'like', "%{$searchTerm}%")
              ->orWhere('sender_name', 'like', "%{$searchTerm}%")
              ->orWhere('recipient_name', 'like', "%{$searchTerm}%");
        });
    }

    // Date range
    if ($request->filled('date_from')) {
        $query->where('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->where('created_at', '<=', $request->date_to);
    }

    // Sender filter
    if ($request->filled('sender')) {
        $query->where('sender_email', 'like', "%{$request->sender}%");
    }

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Priority filter
    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }

    // Has attachments
    if ($request->boolean('has_attachments')) {
        $query->whereNotNull('attachments');
    }

    return $query->orderBy('created_at', 'desc')->paginate(25);
}
```

## Email Templates

### Template Management
```php
public function createTemplate(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'nullable|string|max:100'
    ]);

    $template = EmailTemplate::create([
        'name' => $request->name,
        'subject' => $request->subject,
        'content' => $request->content,
        'category' => $request->category,
        'created_by' => auth()->id()
    ]);

    return response()->json([
        'success' => true,
        'template' => $template
    ]);
}

public function applyTemplate($templateId)
{
    $template = EmailTemplate::findOrFail($templateId);

    return response()->json([
        'subject' => $template->subject,
        'content' => $template->content
    ]);
}
```

## Email Signatures

### Signature Management
```php
public function createSignature(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'content' => 'required|string',
        'is_default' => 'boolean'
    ]);

    // If setting as default, unset other defaults
    if ($request->boolean('is_default')) {
        EmailSignature::where('user_id', auth()->id())
                     ->update(['is_default' => false]);
    }

    $signature = EmailSignature::create([
        'name' => $request->name,
        'content' => $request->content,
        'user_id' => auth()->id(),
        'is_default' => $request->boolean('is_default')
    ]);

    return response()->json([
        'success' => true,
        'signature' => $signature
    ]);
}

public function getDefaultSignature()
{
    return EmailSignature::where('user_id', auth()->id())
                        ->where('is_default', true)
                        ->first();
}
```

## Security Implementation

### Email Encryption
```php
// Encrypt email content before storage
$email->content = encrypt($email->content);

// Decrypt when displaying
$email->content = decrypt($email->content);
```

### Attachment Security
```php
public function validateAttachment($file)
{
    // Check file size
    if ($file->getSize() > config('email.max_attachment_size') * 1024) {
        throw new Exception('File size exceeds limit');
    }

    // Check file type
    $extension = strtolower($file->getClientOriginalExtension());
    if (!in_array($extension, config('email.allowed_extensions'))) {
        throw new Exception('File type not allowed');
    }

    // Scan for viruses (if antivirus is configured)
    if (config('email.antivirus_enabled')) {
        $this->scanForViruses($file);
    }
}
```

### Access Control
```php
public function canAccessEmail($email, $user)
{
    // User is sender or recipient
    if ($email->sender_user_id === $user->id || $email->recipient_user_id === $user->id) {
        return true;
    }

    // User is in CC or BCC
    if (in_array($user->email, $email->cc ?? []) || in_array($user->email, $email->bcc ?? [])) {
        return true;
    }

    // User has admin privileges
    if ($user->hasRole('admin')) {
        return true;
    }

    return false;
}
```

## Performance Optimization

### Database Indexing
```sql
-- Optimize email queries
CREATE INDEX idx_electronic_mails_sender_recipient ON electronic_mails (sender_user_id, recipient_user_id);
CREATE INDEX idx_electronic_mails_status_type ON electronic_mails (status, type);
CREATE INDEX idx_electronic_mails_created_at ON electronic_mails (created_at);
CREATE INDEX idx_electronic_mails_starred ON electronic_mails (is_starred) WHERE is_starred = true;
```

### Email Pagination
```php
public function getEmailsPaginated($folder, $userId, $perPage = 25)
{
    return $this->getEmailsByFolder($folder, $userId)
                ->with(['sender:id,name,email', 'recipient:id,name,email'])
                ->select(['id', 'code', 'subject', 'sender_name', 'recipient_name', 'status', 'priority', 'is_starred', 'is_read', 'created_at', 'sent_at'])
                ->paginate($perPage);
}
```

### Caching Strategy
```php
// Cache user's email folders count
Cache::remember("email_counts_{$userId}", 300, function () use ($userId) {
    return [
        'inbox' => ElectronicMail::inbox($userId)->where('is_read', false)->count(),
        'sent' => ElectronicMail::sent($userId)->count(),
        'draft' => ElectronicMail::where('sender_user_id', $userId)->where('status', 'draft')->count(),
        'starred' => ElectronicMail::starred($userId)->count(),
    ];
});
```

## Integration Features

### External Email Providers
```php
// Sync with Gmail, Outlook, etc.
public function syncExternalEmails()
{
    $provider = config('email.external_provider');

    switch ($provider) {
        case 'gmail':
            return $this->syncGmail();
        case 'outlook':
            return $this->syncOutlook();
        default:
            return [];
    }
}

private function syncGmail()
{
    // Use Gmail API to fetch emails
    $client = new Google_Client();
    $client->setAuthConfig(config('services.gmail'));
    $client->addScope(Gmail::GMAIL_READONLY);

    $service = new Gmail($client);

    // Fetch and process emails
    $messages = $service->users_messages->listUsersMessages('me');
    // ... process messages
}
```

### Notification Integration
```php
public function sendEmailNotification($email)
{
    // Send browser notification
    Notification::create([
        'user_id' => $email->recipient_user_id,
        'type' => 'email_received',
        'title' => 'New Email',
        'message' => "You received an email: {$email->subject}",
        'data' => ['email_id' => $email->id]
    ]);

    // Send email notification if configured
    if (config('email.notifications.enabled')) {
        Mail::to($email->recipient->email)->send(new NewEmailNotification($email));
    }
}
```

## Future Enhancements

### Planned Features
- **Email Threads**: Conversation threading
- **Email Templates**: Advanced template builder
- **Email Scheduling**: Send emails at specific times
- **Email Analytics**: Open rates, click tracking
- **Email Signatures**: HTML signature builder
- **Email Rules**: Automatic sorting and tagging

### Advanced Features
- **Email Encryption**: End-to-end encryption
- **Digital Signatures**: Electronic signature integration
- **Email Campaigns**: Bulk email sending
- **Email Tracking**: Pixel tracking and analytics
- **Mobile App**: Mobile email client
- **Voice-to-Text**: Voice message transcription

## Troubleshooting

### Common Issues
1. **Emails Not Sending**: Check SMTP configuration and credentials
2. **Attachments Not Uploading**: Verify file permissions and PHP limits
3. **Search Not Working**: Check database full-text search configuration
4. **Slow Loading**: Optimize queries and add database indexes

### Debug Mode
```env
MAIL_DEBUG=true
EMAIL_DEBUG=true
LOG_LEVEL=debug
```

### Email Logs
```php
// Log email operations
Log::info('Email sent', [
    'email_id' => $email->id,
    'sender_id' => $email->sender_user_id,
    'recipient_count' => count($email->recipients ?? []),
    'attachment_count' => count($email->attachments ?? [])
]);
```

### Support Resources
- [Laravel Mail](https://laravel.com/docs/mail)
- [Email Security Best Practices](https://tools.ietf.org/html/rfc5321)
- [SMTP Configuration](https://en.wikipedia.org/wiki/Simple_Mail_Transfer_Protocol)

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
