<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'interaction_type',
        'user_input',
        'ai_response',
        'metadata',
        'status',
        'model_used',
        'tokens_used',
        'cost',
        'user_id',
    ];

    protected $casts = [
        'metadata' => 'array',
        'tokens_used' => 'integer',
        'cost' => 'decimal:4',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function generatedContent(): HasMany
    {
        return $this->hasMany(AiGeneratedContent::class, 'interaction_id');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('interaction_type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function markAsCompleted($response, $metadata = [])
    {
        $this->update([
            'ai_response' => $response,
            'status' => 'completed',
            'metadata' => array_merge($this->metadata ?? [], $metadata),
        ]);
    }

    public function markAsFailed($error = null)
    {
        $this->update([
            'status' => 'failed',
            'metadata' => array_merge($this->metadata ?? [], ['error' => $error]),
        ]);
    }

    public function getFormattedCostAttribute()
    {
        return '$' . number_format($this->cost, 4);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i');
    }
}
