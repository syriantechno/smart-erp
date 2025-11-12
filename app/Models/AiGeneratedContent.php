<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiGeneratedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'content_title',
        'generated_content',
        'parameters_used',
        'quality_rating',
        'user_feedback',
        'interaction_id',
        'user_id',
    ];

    protected $casts = [
        'parameters_used' => 'array',
    ];

    // Relationships
    public function interaction(): BelongsTo
    {
        return $this->belongsTo(AiInteraction::class, 'interaction_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('content_type', $type);
    }

    public function scopeRated($query)
    {
        return $query->whereNotNull('quality_rating');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return match($this->content_type) {
            'email' => 'Email',
            'report' => 'Report',
            'task' => 'Task',
            'analysis' => 'Analysis',
            'document' => 'Document',
            'code' => 'Code',
            'other' => 'Other',
        };
    }

    public function getRatingLabelAttribute()
    {
        return $this->quality_rating ? ucfirst($this->quality_rating) : 'Not Rated';
    }
}
