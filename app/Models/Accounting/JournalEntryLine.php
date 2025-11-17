<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalEntryLine extends Model
{
    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'debit',
        'credit',
        'memo'
    ];

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2'
    ];

    // Relationships
    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'account_id');
    }

    /**
     * Get formatted debit
     */
    public function getDebitFormattedAttribute()
    {
        return $this->debit > 0 ? '$' . number_format($this->debit, 2) : '';
    }

    /**
     * Get formatted credit
     */
    public function getCreditFormattedAttribute()
    {
        return $this->credit > 0 ? '$' . number_format($this->credit, 2) : '';
    }

    /**
     * Get amount (whichever is greater)
     */
    public function getAmountAttribute()
    {
        return max($this->debit, $this->credit);
    }

    /**
     * Get formatted amount
     */
    public function getAmountFormattedAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    /**
     * Check if this is a debit entry
     */
    public function getIsDebitAttribute()
    {
        return $this->debit > 0;
    }

    /**
     * Check if this is a credit entry
     */
    public function getIsCreditAttribute()
    {
        return $this->credit > 0;
    }
}
