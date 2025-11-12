<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'document_type',
        'status',
        'access_level',
        'category_id',
        'company_id',
        'department_id',
        'uploaded_by',
        'version',
        'parent_document_id',
        'tags',
        'metadata',
        'expiry_date',
        'requires_signature',
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'expiry_date' => 'date',
        'requires_signature' => 'boolean',
        'file_size' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function parentDocument(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'parent_document_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(DocumentShare::class);
    }

    public function sharedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_shares', 'document_id', 'shared_with_user_id')
                    ->withPivot('permission', 'expires_at')
                    ->withTimestamps();
    }

    public function sharedDepartments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'document_shares', 'document_id', 'shared_with_department_id')
                    ->withPivot('permission', 'expires_at')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeForDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('file_name', 'like', "%{$search}%");
        });
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('expiry_date')
                    ->where('expiry_date', '<=', now()->addDays($days))
                    ->where('expiry_date', '>', now());
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return asset('storage/documents/' . $this->file_path);
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getTypeIconAttribute()
    {
        return match($this->document_type) {
            'contract' => 'file-text',
            'invoice' => 'receipt',
            'report' => 'bar-chart-3',
            'certificate' => 'award',
            'license' => 'shield',
            'agreement' => 'handshake',
            'policy' => 'book-open',
            'manual' => 'book',
            default => 'file',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-700',
            'archived' => 'bg-yellow-100 text-yellow-700',
            'deleted' => 'bg-red-100 text-red-700',
        };
    }

    public function getAccessLevelBadgeClassAttribute()
    {
        return match($this->access_level) {
            'public' => 'bg-blue-100 text-blue-700',
            'internal' => 'bg-green-100 text-green-700',
            'confidential' => 'bg-yellow-100 text-yellow-700',
            'restricted' => 'bg-red-100 text-red-700',
        };
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->expiry_date) return null;

        return now()->diffInDays($this->expiry_date, false);
    }

    // Methods
    public function canBeAccessedBy($user)
    {
        // Public documents
        if ($this->access_level === 'public') {
            return true;
        }

        // Company documents - check if user belongs to company
        if ($this->company_id && $user->company_id !== $this->company_id) {
            return false;
        }

        // Department documents - check if user belongs to department
        if ($this->department_id && $user->department_id !== $this->department_id) {
            return false;
        }

        // Restricted documents - only uploader and shared users
        if ($this->access_level === 'restricted') {
            if ($this->uploaded_by === $user->id) return true;

            return $this->sharedUsers()->where('user_id', $user->id)->exists();
        }

        // Confidential documents - department level access
        if ($this->access_level === 'confidential') {
            if ($this->uploaded_by === $user->id) return true;
            if ($this->department_id && $user->department_id === $this->department_id) return true;

            return $this->sharedUsers()->where('user_id', $user->id)->exists();
        }

        // Internal documents - company level access
        return true;
    }

    public function shareWithUser($userId, $permission = 'view', $expiresAt = null)
    {
        return $this->shares()->create([
            'shared_with_user_id' => $userId,
            'share_type' => 'user',
            'permission' => $permission,
            'expires_at' => $expiresAt,
            'shared_by' => auth()->id(),
        ]);
    }

    public function shareWithDepartment($departmentId, $permission = 'view', $expiresAt = null)
    {
        return $this->shares()->create([
            'shared_with_department_id' => $departmentId,
            'share_type' => 'department',
            'permission' => $permission,
            'expires_at' => $expiresAt,
            'shared_by' => auth()->id(),
        ]);
    }

    public function createVersion($file, $changeNotes = null)
    {
        // Increment version number
        $versionParts = explode('.', $this->version);
        $versionParts[count($versionParts) - 1] = (int)$versionParts[count($versionParts) - 1] + 1;
        $newVersion = implode('.', $versionParts);

        // Store new file
        $path = $file->store('documents', 'public');

        // Create version record
        $this->versions()->create([
            'version' => $newVersion,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => basename($path),
            'file_size' => $file->getSize(),
            'change_notes' => $changeNotes,
            'created_by' => auth()->id(),
        ]);

        // Update document
        $this->update([
            'version' => $newVersion,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => basename($path),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ]);

        return $newVersion;
    }

    public function deleteFile()
    {
        if (\Storage::disk('public')->exists('documents/' . $this->file_path)) {
            \Storage::disk('public')->delete('documents/' . $this->file_path);
        }
    }
}
