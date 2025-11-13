<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'employee_id',
        'document_type',
        'document_name',
        'document_number',
        'issue_date',
        'expiry_date',
        'notes',
        'file_path',
        'file_name',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the employee that owns the document.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the file URL.
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    /**
     * Get formatted document type.
     */
    public function getDocumentTypeFormattedAttribute()
    {
        return match($this->document_type) {
            'passport' => '🛂 Passport',
            'visa' => '✈️ Visa',
            'id_card' => '🆔 ID Card',
            'license' => '🚗 License',
            'certificate' => '🎓 Certificate',
            'other' => '📄 Other',
            default => ucfirst($this->document_type)
        };
    }

    /**
     * Check if document is expired.
     */
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if document is expiring soon (within 30 days).
     */
    public function getIsExpiringSoonAttribute()
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now()) <= 30 && !$this->is_expired;
    }

    /**
     * Scope active documents.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by document type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    /**
     * Scope expired documents.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /**
     * Scope documents expiring soon.
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('expiry_date', '>=', now())
                    ->where('expiry_date', '<=', now()->addDays(30));
    }
}
