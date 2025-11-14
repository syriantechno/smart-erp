<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMailAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_username',
        'smtp_password',
        'incoming_protocol',
        'incoming_host',
        'incoming_port',
        'incoming_encryption',
        'incoming_username',
        'incoming_password',
        'from_name',
        'from_email',
        'is_default',
        'is_active',
        'last_successful_connection_at',
        'failed_attempts',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'last_successful_connection_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
