<!-- Expiry Notifications Settings -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center justify-between border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <div>
            <h2 class="text-base font-medium flex items-center">
                <x-base.lucide icon="calendar-clock" class="w-5 h-5 mr-2 text-orange-500" />
                Expiry Notifications Settings
            </h2>
            <p class="text-sm text-slate-500 mt-1">Configure automatic notifications for expiring items</p>
        </div>
    </div>

    <div class="p-5">
        @php
            $expirySettings = \App\Models\Setting\ExpiryNotificationSetting::all();
            $roles = \Spatie\Permission\Models\Role::all();
        @endphp

        <div class="space-y-4">
            @foreach($expirySettings as $setting)
                <div class="expiry-setting-card p-5 rounded-lg border border-slate-200 dark:border-darkmode-400 hover:shadow-md transition-shadow" data-setting-id="{{ $setting->id }}">
                    <div class="flex flex-col lg:flex-row lg:items-start gap-4">
                        <!-- Left: Info & Toggle -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @php
                                    $typeIcons = [
                                        'employee_documents' => 'id-card',
                                        'company_documents' => 'file-text',
                                        'tasks' => 'clipboard-list',
                                        'projects' => 'folder-kanban',
                                        'contracts' => 'file-signature',
                                    ];
                                    $typeColors = [
                                        'employee_documents' => 'text-blue-500 bg-blue-100',
                                        'company_documents' => 'text-green-500 bg-green-100',
                                        'tasks' => 'text-purple-500 bg-purple-100',
                                        'projects' => 'text-orange-500 bg-orange-100',
                                        'contracts' => 'text-red-500 bg-red-100',
                                    ];
                                @endphp
                                <div class="w-10 h-10 rounded-full {{ $typeColors[$setting->type] ?? 'text-slate-500 bg-slate-100' }} flex items-center justify-center">
                                    <x-base.lucide icon="{{ $typeIcons[$setting->type] ?? 'bell' }}" class="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ $setting->label }}</h3>
                                    <p class="text-xs text-slate-500">{{ $setting->description }}</p>
                                </div>
                                <div class="ml-auto">
                                    <label class="inline-flex cursor-pointer items-center">
                                        <input type="checkbox" class="sr-only peer setting-enabled" data-setting-id="{{ $setting->id }}" {{ $setting->enabled ? 'checked' : '' }} />
                                        <div class="relative w-11 h-6 rounded-full bg-slate-200 transition-colors duration-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 dark:bg-darkmode-600 peer-checked:bg-green-500 after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow after:transition-all after:duration-200 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Settings -->
                        <div class="flex flex-wrap gap-4 lg:w-2/3">
                            <!-- Days Before -->
                            <div class="flex items-center gap-2">
                                <label class="text-sm text-slate-600 whitespace-nowrap">Notify</label>
                                <input type="number" min="1" max="365" value="{{ $setting->days_before }}" 
                                    class="w-16 text-center rounded-md border-slate-200 dark:border-darkmode-400 dark:bg-darkmode-800 text-sm days-before-input"
                                    data-setting-id="{{ $setting->id }}">
                                <label class="text-sm text-slate-600 whitespace-nowrap">days before</label>
                            </div>

                            <!-- Notify Roles -->
                            <div class="flex-1 min-w-[200px]">
                                <label class="text-sm text-slate-600 mb-1 block">Notify Roles:</label>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($roles as $role)
                                        @php
                                            $isSelected = in_array($role->id, $setting->notify_roles ?? []);
                                        @endphp
                                        <label class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs cursor-pointer transition-colors
                                            {{ $isSelected ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                            <input type="checkbox" class="hidden role-checkbox" 
                                                data-setting-id="{{ $setting->id }}" 
                                                data-role-id="{{ $role->id }}"
                                                {{ $isSelected ? 'checked' : '' }}>
                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Additional Options -->
                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                                    <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary notify-super-admin"
                                        data-setting-id="{{ $setting->id }}"
                                        {{ $setting->notify_super_admin ? 'checked' : '' }}>
                                    <span class="text-slate-600">Super Admin</span>
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                                    <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary notify-owner"
                                        data-setting-id="{{ $setting->id }}"
                                        {{ $setting->notify_owner ? 'checked' : '' }}>
                                    <span class="text-slate-600">Owner/Assignee</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Save Button -->
        <div class="flex justify-end mt-6 pt-4 border-t border-slate-200 dark:border-darkmode-400">
            <button type="button" id="save-expiry-settings" class="btn-royal btn-royal--gold btn-royal--sm w-48">
                <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                Save Settings
            </button>
        </div>

        <!-- Info Box -->
        <div class="mt-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
            <div class="flex items-start gap-3">
                <x-base.lucide icon="info" class="w-5 h-5 text-blue-500 mt-0.5" />
                <div class="text-sm text-blue-700 dark:text-blue-300">
                    <p class="font-medium mb-1">How it works:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-600 dark:text-blue-400">
                        <li>The system checks daily for items approaching their expiry/due date</li>
                        <li>Notifications are sent to selected roles and optionally to Super Admin and item owner</li>
                        <li>You can customize the number of days before expiry to send notifications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Role checkbox toggle styling
    document.querySelectorAll('.role-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const label = this.closest('label');
            if (this.checked) {
                label.classList.remove('bg-slate-100', 'text-slate-600', 'hover:bg-slate-200');
                label.classList.add('bg-primary', 'text-white');
            } else {
                label.classList.remove('bg-primary', 'text-white');
                label.classList.add('bg-slate-100', 'text-slate-600', 'hover:bg-slate-200');
            }
        });
    });

    // Save settings
    document.getElementById('save-expiry-settings')?.addEventListener('click', function() {
        const settings = [];
        
        document.querySelectorAll('.expiry-setting-card').forEach(card => {
            const settingId = card.dataset.settingId;
            const enabled = card.querySelector('.setting-enabled').checked;
            const daysBefore = card.querySelector('.days-before-input').value;
            const notifySuperAdmin = card.querySelector('.notify-super-admin').checked;
            const notifyOwner = card.querySelector('.notify-owner').checked;
            
            const selectedRoles = [];
            card.querySelectorAll('.role-checkbox:checked').forEach(cb => {
                selectedRoles.push(parseInt(cb.dataset.roleId));
            });

            settings.push({
                id: settingId,
                enabled: enabled,
                days_before: parseInt(daysBefore),
                notify_roles: selectedRoles,
                notify_super_admin: notifySuperAdmin,
                notify_owner: notifyOwner
            });
        });

        fetch('{{ route("settings.expiry-notifications.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ settings: settings })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
            } else {
                window.showError && showError(data.message || 'Failed to save settings');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to save settings');
        });
    });
});
</script>
@endpush
