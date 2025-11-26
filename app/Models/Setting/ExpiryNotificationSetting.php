<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ExpiryNotificationSetting extends Model
{
    protected $fillable = [
        'type',
        'label',
        'description',
        'enabled',
        'days_before',
        'notify_roles',
        'notify_super_admin',
        'notify_owner',
        'frequency',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'notify_roles' => 'array',
        'notify_super_admin' => 'boolean',
        'notify_owner' => 'boolean',
        'days_before' => 'integer',
    ];

    /**
     * Get the roles to notify
     */
    public function getRolesToNotify(): array
    {
        $roleIds = $this->notify_roles ?? [];
        return Role::whereIn('id', $roleIds)->pluck('name')->toArray();
    }

    /**
     * Get all user IDs to notify based on settings
     */
    public function getRecipientUserIds(?int $ownerId = null): array
    {
        $userIds = [];

        // Add users from selected roles
        if (!empty($this->notify_roles)) {
            $roles = Role::whereIn('id', $this->notify_roles)->get();
            foreach ($roles as $role) {
                $roleUserIds = $role->users()->pluck('id')->toArray();
                $userIds = array_merge($userIds, $roleUserIds);
            }
        }

        // Add super admins
        if ($this->notify_super_admin) {
            $superAdminRole = Role::where('name', 'super-admin')->first();
            if ($superAdminRole) {
                $superAdminIds = $superAdminRole->users()->pluck('id')->toArray();
                $userIds = array_merge($userIds, $superAdminIds);
            }
        }

        // Add owner/assignee
        if ($this->notify_owner && $ownerId) {
            $userIds[] = $ownerId;
        }

        return array_unique($userIds);
    }

    /**
     * Scope for enabled settings
     */
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    /**
     * Get setting by type
     */
    public static function getByType(string $type): ?self
    {
        return static::where('type', $type)->first();
    }
}
