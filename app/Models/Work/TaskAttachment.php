<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TaskAttachment extends BaseModel
{
    protected $fillable = [
        'task_id',
        'uploaded_by',
        'filename',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
        'description',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * Get the task that owns this attachment.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who uploaded this attachment.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL of the attachment.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get human-readable file size.
     */
    public function getHumanFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if attachment is an image.
     */
    public function isImage(): bool
    {
        return in_array($this->file_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml']);
    }

    /**
     * Check if attachment is a document.
     */
    public function isDocument(): bool
    {
        return in_array($this->file_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Get icon based on file type.
     */
    public function getIconAttribute(): string
    {
        if ($this->isImage()) return 'image';
        if (str_contains($this->file_type, 'pdf')) return 'file-text';
        if (str_contains($this->file_type, 'word')) return 'file-text';
        if (str_contains($this->file_type, 'excel') || str_contains($this->file_type, 'spreadsheet')) return 'file-spreadsheet';
        if (str_contains($this->file_type, 'zip') || str_contains($this->file_type, 'rar')) return 'file-archive';
        return 'file';
    }
}
