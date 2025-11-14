<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function aiInteractions()
    {
        return $this->hasMany(AiInteraction::class);
    }

    public function aiAutomations()
    {
        return $this->hasMany(AiAutomation::class, 'created_by');
    }

    public function aiGeneratedContent()
    {
        return $this->hasMany(AiGeneratedContent::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function approvalRequests()
    {
        return $this->hasMany(ApprovalRequest::class, 'requester_id');
    }

    public function approvalLogs()
    {
        return $this->hasMany(ApprovalLog::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function sharedDocuments()
    {
        return $this->belongsToMany(Document::class, 'document_shares', 'shared_with_user_id', 'document_id')
                    ->withPivot('permission', 'expires_at');
    }

    public function electronicMails()
    {
        return $this->hasMany(ElectronicMail::class, 'sender_user_id');
    }

    public function receivedEmails()
    {
        return $this->hasMany(ElectronicMail::class, 'recipient_user_id');
    }

    // Helper methods
    public function getUnreadConversationsCount()
    {
        return $this->conversations()
                   ->whereHas('messages', function ($query) {
                       $query->where('is_read', false)
                            ->where('sender_id', '!=', $this->id);
                   })
                   ->count();
    }

    public function getPendingApprovalsCount()
    {
        return ApprovalRequest::where('current_approver_id', $this->id)
                             ->where('status', 'pending')
                             ->count();
    }

    public function getUnreadEmailsCount()
    {
        return $this->receivedEmails()
                   ->where('is_read', false)
                   ->count();
    }

    public function mailAccounts()
    {
        return $this->hasMany(UserMailAccount::class);
    }

    public function defaultMailAccount()
    {
        return $this->hasOne(UserMailAccount::class)->where('is_default', true);
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
}
