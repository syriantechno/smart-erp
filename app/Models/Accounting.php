<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accounting extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'category',
        'parent_id',
        'is_active',
        'level'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer'
    ];

    /**
     * Scope a query to only include active accounts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Generate unique code for account
     */
    public static function generateUniqueCode()
    {
        $attempts = 0;
        $maxAttempts = 100;

        do {
            if ($attempts >= $maxAttempts) {
                return 'ACC-' . date('Y') . '-' . time();
            }

            $code = 'ACC-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $attempts++;
        } while (self::where('code', $code)->exists());

        return $code;
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Accounting::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Accounting::class, 'parent_id');
    }

    public function journalEntryLines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class, 'account_id');
    }

    /**
     * Get type color
     */
    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'asset' => 'green',
            'liability' => 'red',
            'equity' => 'blue',
            'income' => 'purple',
            'expense' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'asset' => 'Asset',
            'liability' => 'Liability',
            'equity' => 'Equity',
            'income' => 'Income',
            'expense' => 'Expense',
            default => 'Unknown'
        };
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'current_asset' => 'Current Asset',
            'fixed_asset' => 'Fixed Asset',
            'current_liability' => 'Current Liability',
            'long_term_liability' => 'Long-term Liability',
            'owner_equity' => 'Owner Equity',
            'retained_earnings' => 'Retained Earnings',
            'operating_income' => 'Operating Income',
            'other_income' => 'Other Income',
            'cost_of_goods_sold' => 'Cost of Goods Sold',
            'operating_expense' => 'Operating Expense',
            'other_expense' => 'Other Expense',
            default => 'Unknown'
        };
    }

    /**
     * Get account balance (simplified - would need more complex logic in real system)
     */
    public function getBalanceAttribute()
    {
        $debit = $this->journalEntryLines()->sum('debit');
        $credit = $this->journalEntryLines()->sum('credit');

        // For assets and expenses: debit - credit
        // For liabilities, equity, and income: credit - debit
        if (in_array($this->type, ['asset', 'expense'])) {
            return $debit - $credit;
        } else {
            return $credit - $debit;
        }
    }

    /**
     * Get formatted balance
     */
    public function getBalanceFormattedAttribute()
    {
        $balance = $this->balance;
        return '$' . number_format(abs($balance), 2) . ($balance < 0 ? ' (DR)' : ' (CR)');
    }

    /**
     * Check if account has children
     */
    public function getHasChildrenAttribute()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get full account path
     */
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }
}
