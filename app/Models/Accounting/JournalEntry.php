<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    protected $fillable = [
        'reference_number',
        'entry_date',
        'description',
        'status',
        'created_by',
        'total_debit',
        'total_credit'
    ];

    protected $casts = [
        'entry_date' => 'date',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2'
    ];

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('entry_date', [$startDate, $endDate]);
    }

    /**
     * Generate unique reference number
     */
    public static function generateReferenceNumber()
    {
        $attempts = 0;
        $maxAttempts = 100;

        do {
            if ($attempts >= $maxAttempts) {
                return 'JE-' . date('Y-m-d') . '-' . time();
            }

            $reference = 'JE-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $attempts++;
        } while (self::where('reference_number', $reference)->exists());

        return $reference;
    }

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function journalEntryLines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'posted' => 'green',
            'voided' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'posted' => 'Posted',
            'voided' => 'Voided',
            default => 'Unknown'
        };
    }

    /**
     * Check if entry is balanced
     */
    public function getIsBalancedAttribute()
    {
        return abs($this->total_debit - $this->total_credit) < 0.01; // Allow for rounding errors
    }

    /**
     * Get formatted total debit
     */
    public function getTotalDebitFormattedAttribute()
    {
        return '$' . number_format($this->total_debit, 2);
    }

    /**
     * Get formatted total credit
     */
    public function getTotalCreditFormattedAttribute()
    {
        return '$' . number_format($this->total_credit, 2);
    }

    /**
     * Check if entry can be posted
     */
    public function getCanBePostedAttribute()
    {
        return $this->status === 'draft' && $this->is_balanced && $this->journalEntryLines()->count() > 0;
    }

    /**
     * Check if entry can be voided
     */
    public function getCanBeVoidedAttribute()
    {
        return $this->status === 'posted';
    }
}
