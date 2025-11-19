<?php

namespace App\Models\CRM;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $table = 'crm_files';

    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'related_type',
        'related_id',
        'uploaded_by',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
