<div class="bg-white dark:bg-darkmode-600 rounded-lg shadow-sm border border-slate-200/60 dark:border-darkmode-400 mt-5">
    <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
        <h2 class="mr-auto text-base font-medium flex items-center gap-2">
            <x-base.lucide icon="Shield" class="w-5 h-5" />
            Roles & Permissions
        </h2>
    </div>

    <form class="p-5">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-6">
                <h3 class="text-base font-semibold mb-3">Roles</h3>
                <div class="space-y-4">
                    @foreach ($roles as $role)
                        <div class="border rounded-lg p-4 bg-slate-50 dark:bg-darkmode-700/50">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <div class="font-semibold text-slate-800 dark:text-slate-100">{{ $role->name }}</div>
                                    <div class="text-xs text-slate-500">ID: {{ $role->id }}</div>
                                </div>
                            </div>
                            <form class="role-permissions-form space-y-3" data-role-id="{{ $role->id }}">
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border rounded-md p-2 bg-white dark:bg-darkmode-600">
                                    @foreach ($permissions as $permission)
                                        <label class="flex items-center space-x-2 text-sm">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                @if ($role->permissions->contains('id', $permission->id)) checked @endif
                                                class="border-slate-300 rounded"
                                            >
                                            <span>{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn-royal btn-royal--gold btn-royal--sm">
                                        Save Permissions
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-span-12 xl:col-span-6">
                <h3 class="text-base font-semibold mb-3">All Permissions</h3>
                <div class="border rounded-lg p-4 max-h-[500px] overflow-y-auto bg-slate-50 dark:bg-darkmode-700/50">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 text-left">Permission</th>
                                <th class="py-2 text-left">ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr class="border-b last:border-b-0">
                                    <td class="py-1">{{ $permission->name }}</td>
                                    <td class="py-1 text-xs text-slate-500">{{ $permission->id }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
