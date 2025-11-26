<!-- Roles & Permissions Settings -->
<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center justify-between border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="text-base font-medium flex items-center">
            <x-base.lucide icon="shield-check" class="w-5 h-5 mr-2 text-primary" />
            Roles & Permissions Management
        </h2>
        <button type="button" id="add-role-btn" class="btn-royal btn-royal--sm btn-royal--gold">
            <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
            Add New Role
        </button>
    </div>

    <div class="p-5">
        <!-- Roles List -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center">
                <x-base.lucide icon="users" class="w-4 h-4 mr-2 text-primary" />
                System Roles
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="roles-container">
                @php
                    $roles = \Spatie\Permission\Models\Role::withCount('permissions')->get();
                @endphp
                
                @foreach($roles as $role)
                    <div class="role-card p-4 rounded-lg border border-slate-200 dark:border-darkmode-400 hover:shadow-md transition-shadow cursor-pointer" data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                @php
                                    $roleIcons = [
                                        'super-admin' => 'crown',
                                        'admin' => 'shield',
                                        'hr-manager' => 'users',
                                        'project-manager' => 'briefcase',
                                        'team-leader' => 'user-check',
                                        'accountant' => 'calculator',
                                        'warehouse-manager' => 'warehouse',
                                        'employee' => 'user',
                                    ];
                                    $roleColors = [
                                        'super-admin' => 'text-yellow-500',
                                        'admin' => 'text-red-500',
                                        'hr-manager' => 'text-blue-500',
                                        'project-manager' => 'text-green-500',
                                        'team-leader' => 'text-purple-500',
                                        'accountant' => 'text-orange-500',
                                        'warehouse-manager' => 'text-cyan-500',
                                        'employee' => 'text-slate-500',
                                    ];
                                @endphp
                                <x-base.lucide icon="{{ $roleIcons[$role->name] ?? 'user' }}" class="w-5 h-5 {{ $roleColors[$role->name] ?? 'text-slate-500' }}" />
                                <span class="font-medium text-slate-800 dark:text-slate-100">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                            </div>
                            @if($role->name !== 'super-admin')
                                <button type="button" class="edit-role-btn text-slate-400 hover:text-primary" data-role-id="{{ $role->id }}">
                                    <x-base.lucide icon="settings" class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">{{ $role->permissions_count }} permissions</span>
                            <span class="text-xs px-2 py-1 rounded-full {{ $role->name === 'super-admin' ? 'bg-yellow-100 text-yellow-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $role->users()->count() }} users
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Users by Role Table -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center">
                <x-base.lucide icon="users-round" class="w-4 h-4 mr-2 text-primary" />
                Users by Role
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-darkmode-700">
                            <th class="px-4 py-3 text-left font-medium text-slate-700 dark:text-slate-300">User</th>
                            <th class="px-4 py-3 text-left font-medium text-slate-700 dark:text-slate-300">Email</th>
                            <th class="px-4 py-3 text-left font-medium text-slate-700 dark:text-slate-300">Roles</th>
                            <th class="px-4 py-3 text-center font-medium text-slate-700 dark:text-slate-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-darkmode-400">
                        @php
                            $users = \App\Models\User::with('roles')->orderBy('name')->get();
                        @endphp
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-darkmode-700">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                            <span class="text-xs font-medium text-primary">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($user->roles as $userRole)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $userRole->name === 'super-admin' ? 'bg-yellow-100 text-yellow-700' : 
                                                   ($userRole->name === 'admin' ? 'bg-red-100 text-red-700' : 
                                                   ($userRole->name === 'hr-manager' ? 'bg-blue-100 text-blue-700' : 
                                                   ($userRole->name === 'project-manager' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700'))) }}">
                                                {{ ucwords(str_replace('-', ' ', $userRole->name)) }}
                                            </span>
                                        @empty
                                            <span class="text-slate-400 text-xs">No roles</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="assign-role-btn text-primary hover:text-primary/80" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-roles="{{ $user->roles->pluck('id')->join(',') }}">
                                        <x-base.lucide icon="user-cog" class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permissions by Module -->
        <div>
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-4 flex items-center">
                <x-base.lucide icon="key" class="w-4 h-4 mr-2 text-primary" />
                Permissions by Module
            </h3>

            @php
                $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function($permission) {
                    $parts = explode(' ', $permission->name);
                    return end($parts);
                });
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($permissions as $module => $modulePermissions)
                    <div class="p-4 rounded-lg border border-slate-200 dark:border-darkmode-400 bg-slate-50 dark:bg-darkmode-700">
                        <h4 class="font-medium text-slate-800 dark:text-slate-100 mb-3 capitalize flex items-center">
                            @php
                                $moduleIcons = [
                                    'users' => 'users',
                                    'roles' => 'shield',
                                    'permissions' => 'key',
                                    'departments' => 'building',
                                    'employees' => 'user-check',
                                    'attendance' => 'clock',
                                    'leave' => 'calendar-off',
                                    'payroll' => 'banknote',
                                    'accounting' => 'calculator',
                                    'projects' => 'folder-kanban',
                                    'tasks' => 'clipboard-list',
                                    'documents' => 'file-text',
                                    'emails' => 'mail',
                                    'chat' => 'message-circle',
                                    'recruitment' => 'user-plus',
                                    'settings' => 'settings',
                                    'manufacturing' => 'factory',
                                ];
                            @endphp
                            <x-base.lucide icon="{{ $moduleIcons[$module] ?? 'box' }}" class="w-4 h-4 mr-2 text-primary" />
                            {{ ucfirst($module) }}
                            <span class="ml-auto text-xs text-slate-500">({{ $modulePermissions->count() }})</span>
                        </h4>
                        <div class="space-y-1">
                            @foreach($modulePermissions as $permission)
                                <div class="text-xs text-slate-600 dark:text-slate-400 flex items-center gap-1">
                                    <x-base.lucide icon="check" class="w-3 h-3 text-green-500" />
                                    {{ $permission->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<x-base.dialog id="edit-role-modal" size="xl">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-gradient-to-r from-primary to-primary/70 text-white">
            <h2 class="text-lg font-semibold" id="edit-role-title">Edit Role Permissions</h2>
            <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>
        <form id="edit-role-form" method="POST">
            @csrf
            <input type="hidden" id="edit-role-id" name="role_id">
            <x-base.dialog.description class="p-6 max-h-[60vh] overflow-y-auto">
                <div id="role-permissions-container">
                    <!-- Permissions will be loaded here -->
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                    Cancel
                </button>
                <button type="submit" class="btn-royal btn-royal--gold">
                    <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                    Save Permissions
                </button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<!-- Add Role Modal -->
<x-base.dialog id="add-role-modal">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-gradient-to-r from-green-600 to-green-500 text-white">
            <h2 class="text-lg font-semibold">Add New Role</h2>
            <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>
        <form id="add-role-form" method="POST" action="{{ route('settings.roles.store') }}">
            @csrf
            <x-base.dialog.description class="p-6">
                <div class="mb-4">
                    <x-base.form-label for="role-name">Role Name</x-base.form-label>
                    <x-base.form-input type="text" id="role-name" name="name" placeholder="e.g. sales-manager" required class="w-full" />
                    <p class="text-xs text-slate-500 mt-1">Use lowercase with hyphens (e.g. sales-manager)</p>
                </div>
                <div>
                    <x-base.form-label>Copy Permissions From</x-base.form-label>
                    <select name="copy_from" class="w-full rounded-md border-slate-200 dark:border-darkmode-400 dark:bg-darkmode-800">
                        <option value="">-- Start with no permissions --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucwords(str_replace('-', ' ', $role->name)) }} ({{ $role->permissions_count }} permissions)</option>
                        @endforeach
                    </select>
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                    Cancel
                </button>
                <button type="submit" class="btn-royal btn-royal--gold">
                    <x-base.lucide icon="plus" class="w-4 h-4 mr-2" />
                    Create Role
                </button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

<!-- Assign Role to User Modal -->
<x-base.dialog id="assign-role-modal">
    <x-base.dialog.panel>
        <x-base.dialog.title class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
            <h2 class="text-lg font-semibold" id="assign-role-title">Assign Roles to User</h2>
            <button type="button" data-tw-dismiss="modal" class="text-white/80 hover:text-white">
                <x-base.lucide icon="x" class="w-5 h-5" />
            </button>
        </x-base.dialog.title>
        <form id="assign-role-form">
            <input type="hidden" id="assign-user-id" name="user_id">
            <x-base.dialog.description class="p-6">
                <p class="text-sm text-slate-600 mb-4">Select roles to assign to <strong id="assign-user-name"></strong>:</p>
                <div class="space-y-2" id="assign-roles-list">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-darkmode-400 hover:bg-slate-50 dark:hover:bg-darkmode-700 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="rounded border-slate-300 text-primary focus:ring-primary user-role-checkbox">
                            <div class="flex items-center gap-2">
                                @php
                                    $roleIcons = [
                                        'super-admin' => 'crown',
                                        'admin' => 'shield',
                                        'hr-manager' => 'users',
                                        'project-manager' => 'briefcase',
                                        'team-leader' => 'user-check',
                                        'accountant' => 'calculator',
                                        'warehouse-manager' => 'warehouse',
                                        'employee' => 'user',
                                    ];
                                @endphp
                                <x-base.lucide icon="{{ $roleIcons[$role->name] ?? 'user' }}" class="w-4 h-4 text-primary" />
                                <span class="font-medium">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                                <span class="text-xs text-slate-500">({{ $role->permissions_count }} permissions)</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="bg-slate-50 dark:bg-darkmode-600">
                <button type="button" data-tw-dismiss="modal" class="btn-royal btn-royal--outline">
                    Cancel
                </button>
                <button type="submit" class="btn-royal btn-royal--gold">
                    <x-base.lucide icon="save" class="w-4 h-4 mr-2" />
                    Save Roles
                </button>
            </x-base.dialog.footer>
        </form>
    </x-base.dialog.panel>
</x-base.dialog>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Add Role Button
    document.getElementById('add-role-btn')?.addEventListener('click', function() {
        const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('add-role-modal'));
        modal.show();
    });

    // Edit Role Button
    document.querySelectorAll('.edit-role-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const roleId = this.dataset.roleId;
            loadRolePermissions(roleId);
        });
    });

    // Role Card Click
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', function() {
            const roleId = this.dataset.roleId;
            const roleName = this.dataset.roleName;
            if (roleName !== 'super-admin') {
                loadRolePermissions(roleId);
            }
        });
    });

    function loadRolePermissions(roleId) {
        fetch(`{{ url('settings/roles') }}/${roleId}/permissions`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit-role-id').value = roleId;
                document.getElementById('edit-role-title').textContent = `Edit ${data.role.name} Permissions`;
                
                let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                
                for (const [module, permissions] of Object.entries(data.permissions_grouped)) {
                    html += `
                        <div class="p-3 rounded-lg border border-slate-200 dark:border-darkmode-400">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-sm capitalize">${module}</h4>
                                <label class="text-xs text-primary cursor-pointer select-all-module" data-module="${module}">Select All</label>
                            </div>
                            <div class="space-y-1">
                    `;
                    
                    permissions.forEach(perm => {
                        const checked = data.role_permissions.includes(perm.id) ? 'checked' : '';
                        html += `
                            <label class="flex items-center gap-2 text-xs cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="${perm.id}" ${checked} class="rounded border-slate-300 text-primary focus:ring-primary perm-checkbox" data-module="${module}">
                                ${perm.name}
                            </label>
                        `;
                    });
                    
                    html += '</div></div>';
                }
                
                html += '</div>';
                document.getElementById('role-permissions-container').innerHTML = html;
                
                // Select All functionality
                document.querySelectorAll('.select-all-module').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const module = this.dataset.module;
                        const checkboxes = document.querySelectorAll(`.perm-checkbox[data-module="${module}"]`);
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        checkboxes.forEach(cb => cb.checked = !allChecked);
                        this.textContent = allChecked ? 'Select All' : 'Deselect All';
                    });
                });
                
                const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('edit-role-modal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to load role permissions');
        });
    }

    // Save Role Permissions
    document.getElementById('edit-role-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const roleId = document.getElementById('edit-role-id').value;
        const formData = new FormData(this);
        
        fetch(`{{ url('settings/roles') }}/${roleId}/permissions`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getOrCreateInstance(document.getElementById('edit-role-modal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                window.showError && showError(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to save permissions');
        });
    });

    // Add Role Form
    document.getElementById('add-role-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getOrCreateInstance(document.getElementById('add-role-modal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                window.showError && showError(data.message || 'Failed to create role');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to create role');
        });
    });

    // Assign Role Button
    document.querySelectorAll('.assign-role-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const userRoles = this.dataset.userRoles ? this.dataset.userRoles.split(',').map(Number) : [];
            
            document.getElementById('assign-user-id').value = userId;
            document.getElementById('assign-user-name').textContent = userName;
            
            // Reset all checkboxes and check user's current roles
            document.querySelectorAll('.user-role-checkbox').forEach(cb => {
                cb.checked = userRoles.includes(parseInt(cb.value));
            });
            
            const modal = tailwind.Modal.getOrCreateInstance(document.getElementById('assign-role-modal'));
            modal.show();
        });
    });

    // Assign Role Form Submit
    document.getElementById('assign-role-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const userId = document.getElementById('assign-user-id').value;
        const formData = new FormData(this);
        
        fetch(`{{ url('settings/users') }}/${userId}/roles`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showSuccess && showSuccess(data.message);
                tailwind.Modal.getOrCreateInstance(document.getElementById('assign-role-modal')).hide();
                setTimeout(() => location.reload(), 1000);
            } else {
                window.showError && showError(data.message || 'Failed to assign roles');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showError && showError('Failed to assign roles');
        });
    });
});
</script>
@endpush
