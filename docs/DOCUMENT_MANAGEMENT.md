# Document Management System Documentation

## Overview
The Document Management System provides a comprehensive solution for organizing, storing, and managing documents within the ERP system. It features hierarchical categorization, advanced access controls, version control, and sharing capabilities.

## Features

### 📁 Core Capabilities
- **Hierarchical Categories**: Unlimited nested document categories
- **File Upload & Storage**: Secure file storage with type validation
- **Access Control**: Multi-level permission system
- **Version Control**: Track document changes and versions
- **Sharing System**: Share documents with users or departments
- **Search & Filter**: Advanced search and filtering options

### 🔐 Security Features
- **File Type Validation**: Restrict allowed file types
- **Size Limits**: Configurable upload size limits
- **Access Levels**: Public, Internal, Confidential, Restricted
- **Audit Trail**: Track all document operations
- **Encryption**: Secure file storage

## Technical Implementation

### Database Schema
```sql
-- Document Categories Table
CREATE TABLE document_categories (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT NULL,
    color VARCHAR(7) DEFAULT '#3b82f6',
    icon VARCHAR(50) DEFAULT 'folder',
    parent_id BIGINT NULL,
    company_id BIGINT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Documents Table
CREATE TABLE documents (
    id BIGINT PRIMARY KEY,
    code VARCHAR(255) UNIQUE,
    title VARCHAR(255),
    description TEXT NULL,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    file_type VARCHAR(255),
    file_size INT,
    mime_type VARCHAR(255),
    document_type ENUM('contract', 'invoice', 'report', 'certificate', 'license', 'agreement', 'policy', 'manual', 'other'),
    status ENUM('active', 'archived', 'deleted') DEFAULT 'active',
    access_level ENUM('public', 'internal', 'confidential', 'restricted') DEFAULT 'internal',
    category_id BIGINT NULL,
    company_id BIGINT NULL,
    department_id BIGINT NULL,
    uploaded_by BIGINT,
    version VARCHAR(255) DEFAULT '1.0',
    parent_document_id BIGINT NULL,
    tags JSON NULL,
    metadata JSON NULL,
    expiry_date DATE NULL,
    requires_signature BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Document Shares Table
CREATE TABLE document_shares (
    id BIGINT PRIMARY KEY,
    document_id BIGINT,
    shared_with_user_id BIGINT NULL,
    shared_with_department_id BIGINT NULL,
    share_type ENUM('user', 'department') DEFAULT 'user',
    permission ENUM('view', 'download', 'edit') DEFAULT 'view',
    expires_at TIMESTAMP NULL,
    shared_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Document Versions Table
CREATE TABLE document_versions (
    id BIGINT PRIMARY KEY,
    document_id BIGINT,
    version VARCHAR(255),
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    file_size INT,
    change_notes TEXT NULL,
    created_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Models

#### DocumentCategory Model
```php
class DocumentCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'color', 'icon', 'parent_id',
        'company_id', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function parent() { return $this->belongsTo(DocumentCategory::class, 'parent_id'); }
    public function children() { return $this->hasMany(DocumentCategory::class, 'parent_id'); }
    public function company() { return $this->belongsTo(Company::class); }
    public function documents() { return $this->hasMany(Document::class, 'category_id'); }

    // Accessors
    public function getFullPathAttribute() { /* Implementation */ }
    public function getDocumentCountAttribute() { /* Implementation */ }
}
```

#### Document Model
```php
class Document extends Model
{
    protected $fillable = [
        'code', 'title', 'description', 'file_name', 'file_path',
        'file_type', 'file_size', 'mime_type', 'document_type',
        'status', 'access_level', 'category_id', 'company_id',
        'department_id', 'uploaded_by', 'version', 'parent_document_id',
        'tags', 'metadata', 'expiry_date', 'requires_signature'
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'expiry_date' => 'date',
        'requires_signature' => 'boolean',
        'file_size' => 'integer'
    ];

    // Relationships
    public function category() { return $this->belongsTo(DocumentCategory::class, 'category_id'); }
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
    public function versions() { return $this->hasMany(DocumentVersion::class); }
    public function shares() { return $this->hasMany(DocumentShare::class); }

    // Methods
    public function canBeAccessedBy($user) { /* Implementation */ }
    public function shareWithUser($userId, $permission = 'view', $expiresAt = null) { /* Implementation */ }
    public function createVersion($file, $changeNotes = null) { /* Implementation */ }
}
```

## Configuration

### File Storage Configuration
```php
// config/filesystems.php
'disks' => [
    'documents' => [
        'driver' => 'local',
        'root' => storage_path('app/documents'),
        'url' => env('APP_URL').'/storage/documents',
        'visibility' => 'private',
    ],
]
```

### Upload Configuration
```php
// config/documents.php
return [
    'max_file_size' => 51200, // 50MB in KB
    'allowed_extensions' => [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt',
        'jpg', 'jpeg', 'png', 'gif', 'bmp'
    ],
    'allowed_mime_types' => [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        // ... more mime types
    ],
    'category_colors' => [
        'contracts' => '#ef4444',
        'financial' => '#22c55e',
        'hr' => '#3b82f6',
        'reports' => '#f59e0b',
        'legal' => '#8b5cf6',
        'technical' => '#06b6d4',
    ]
];
```

## API Endpoints

### Document Management
```http
GET    /documents              # List documents with pagination
POST   /documents              # Upload new document
GET    /documents/{id}         # Get document details
PUT    /documents/{id}         # Update document metadata
DELETE /documents/{id}         # Delete document
GET    /documents/datatable    # DataTable endpoint
```

### Category Management
```http
GET    /documents/categories          # List all categories
POST   /documents/categories          # Create new category
PUT    /documents/categories/{id}     # Update category
DELETE /documents/categories/{id}     # Delete category
```

### File Operations
```http
GET    /documents/{id}/download       # Download document
GET    /documents/{id}/preview        # Preview document (if supported)
POST   /documents/{id}/version        # Create new version
GET    /documents/{id}/versions       # List document versions
```

### Sharing
```http
POST   /documents/{id}/share/user     # Share with user
POST   /documents/{id}/share/department # Share with department
DELETE /documents/{id}/share/{shareId} # Remove share
```

## Usage Examples

### Uploading Documents
```javascript
const formData = new FormData();
formData.append('file', fileInput.files[0]);
formData.append('title', 'Document Title');
formData.append('description', 'Document description');
formData.append('document_type', 'contract');
formData.append('access_level', 'internal');
formData.append('category_id', selectedCategoryId);

fetch('/documents', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Document uploaded:', data.document);
    }
});
```

### Creating Categories
```javascript
fetch('/documents/categories', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        name: 'New Category',
        description: 'Category description',
        color: '#3b82f6',
        icon: 'folder',
        parent_id: null
    })
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        console.log('Category created:', data.category);
    }
});
```

### Searching Documents
```javascript
fetch('/documents/datatable?' + new URLSearchParams({
    search: 'contract',
    category_id: categoryId,
    type_filter: 'contract',
    access_filter: 'internal'
}))
.then(response => response.json())
.then(data => {
    // Handle search results
    displayDocuments(data.data);
});
```

## File Organization

### Directory Structure
```
storage/app/
├── documents/
│   ├── contracts/
│   │   ├── client_contracts/
│   │   └── vendor_agreements/
│   ├── financial/
│   │   ├── invoices/
│   │   └── receipts/
│   ├── hr/
│   │   ├── policies/
│   │   └── handbooks/
│   └── reports/
│       ├── monthly/
│       └── quarterly/
└── temp/          # Temporary upload files
```

### Naming Convention
- **Files**: `{document_code}_{version}_{timestamp}.{extension}`
- **Directories**: Lowercase with underscores
- **Categories**: Hierarchical path structure

## Security Implementation

### Access Control Levels

#### Public Access
- **Visibility**: All authenticated users
- **Permissions**: View and download
- **Use Case**: Company policies, public documents

#### Internal Access
- **Visibility**: Company employees only
- **Permissions**: View and download
- **Use Case**: Internal procedures, guidelines

#### Confidential Access
- **Visibility**: Department members only
- **Permissions**: View and download (department level)
- **Use Case**: Department reports, sensitive data

#### Restricted Access
- **Visibility**: Specific users only
- **Permissions**: Configurable per user
- **Use Case**: Legal documents, HR records

### File Security
```php
// File validation
$validator = Validator::make($request->all(), [
    'file' => 'required|file|max:51200|mimes:pdf,doc,docx,xls,xlsx,txt,jpg,jpeg,png,gif'
]);

// Access check
if (!$document->canBeAccessedBy(auth()->user())) {
    abort(403, 'Access denied');
}

// Secure download
if ($document->access_level === 'restricted') {
    // Log access for audit
    Log::info('Document accessed', [
        'document_id' => $document->id,
        'user_id' => auth()->id(),
        'ip_address' => request()->ip()
    ]);
}
```

## Performance Optimization

### Database Indexing
```sql
-- Key indexes for performance
CREATE INDEX idx_documents_category_status ON documents (category_id, status);
CREATE INDEX idx_documents_company_department ON documents (company_id, department_id);
CREATE INDEX idx_documents_type ON documents (document_type);
CREATE INDEX idx_documents_access_level ON documents (access_level);
CREATE INDEX idx_documents_uploaded_by ON documents (uploaded_by);
```

### File Storage Optimization
- **Chunked Uploads**: For large files
- **CDN Integration**: For faster access
- **Compression**: Automatic file compression
- **Cleanup**: Automatic temp file cleanup

### Caching Strategy
```php
// Cache category tree
Cache::remember('document_categories_' . $companyId, 3600, function () use ($companyId) {
    return DocumentCategory::forCompany($companyId)
                          ->with('children')
                          ->root()
                          ->get();
});

// Cache user permissions
Cache::remember("user_document_permissions_{$userId}", 1800, function () use ($userId) {
    return Document::forUser($userId)->pluck('id')->toArray();
});
```

## Error Handling

### Common Errors
- **File Too Large**: "File size exceeds maximum limit of 50MB"
- **Invalid File Type**: "File type not allowed. Allowed types: PDF, DOC, XLS, JPG"
- **Access Denied**: "You don't have permission to access this document"
- **Category Not Found**: "Selected category does not exist"
- **Storage Full**: "Insufficient storage space"

### Error Response Format
```json
{
    "success": false,
    "message": "File upload failed",
    "errors": {
        "file": ["File size exceeds maximum limit of 50MB"]
    }
}
```

## Monitoring & Analytics

### Key Metrics
- **Upload Count**: Total documents uploaded
- **Storage Usage**: Total storage consumed
- **Download Count**: Document access frequency
- **Category Usage**: Most used categories
- **User Activity**: Upload/download patterns

### Audit Logging
```php
// Log document operations
Log::info('Document uploaded', [
    'document_id' => $document->id,
    'user_id' => auth()->id(),
    'file_size' => $document->file_size,
    'category' => $document->category?->name
]);

// Log access attempts
Log::warning('Unauthorized document access attempt', [
    'document_id' => $documentId,
    'user_id' => auth()->id(),
    'ip_address' => request()->ip()
]);
```

## Backup & Recovery

### Automated Backups
```bash
# Daily backup script
#!/bin/bash
DATE=$(date +%Y%m%d)
mysqldump -u username -p database > backup_$DATE.sql
tar -czf documents_$DATE.tar.gz storage/app/documents/
```

### Recovery Procedures
1. **Database Recovery**: Restore from SQL backup
2. **File Recovery**: Restore from compressed archives
3. **Integrity Check**: Verify file-database consistency
4. **Permission Restore**: Reapply access permissions

## Integration Points

### External Systems
- **Google Drive**: File synchronization
- **Dropbox**: Cloud storage integration
- **SharePoint**: Enterprise document management
- **Email Systems**: Document attachments

### API Integrations
```php
// Webhook for document events
Route::post('/webhooks/document-uploaded', function (Request $request) {
    // Process webhook from external system
    $document = Document::find($request->document_id);
    // Send notifications, update indexes, etc.
});
```

## Future Enhancements

### Planned Features
- **OCR Integration**: Text extraction from images
- **Document AI**: Intelligent document processing
- **Workflow Integration**: Document approval workflows
- **Digital Signatures**: Electronic signature support
- **Mobile App**: Mobile document access

### Advanced Features
- **Full-text Search**: Elasticsearch integration
- **Document Comparison**: Version diff functionality
- **Bulk Operations**: Mass upload/download
- **Template System**: Document templates
- **Retention Policies**: Automatic document cleanup

## Troubleshooting

### Debug Information
Enable debug mode in `.env`:
```env
APP_DEBUG=true
DOCUMENT_DEBUG=true
```

### Common Issues
1. **Upload Fails**: Check file permissions and PHP limits
2. **Slow Loading**: Optimize database queries and add caching
3. **Access Issues**: Verify user permissions and roles
4. **Storage Errors**: Check disk space and file system permissions

### Support Resources
- [Laravel File Storage](https://laravel.com/docs/filesystem)
- [File Upload Security](https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload)
- [Document Management Best Practices](https://en.wikipedia.org/wiki/Document_management_system)

---

**Last Updated:** November 12, 2024
**Version:** 1.0.0
