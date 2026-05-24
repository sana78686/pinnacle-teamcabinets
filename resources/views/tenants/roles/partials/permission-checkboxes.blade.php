@php
    $permissions = $permissions ?? collect();
    $rolePermissions = $rolePermissions ?? [];
    $modulesMeta = config('tenant_permissions.modules', []);
@endphp

<div class="tc-role-permissions">
    <h5 class="mb-3">Permissions</h5>
    <p class="text-muted small mb-3">Users with this role can only access modules and actions that are checked below.</p>

    @foreach ($permissions as $module => $permissionsGroup)
        @php
            $moduleLabel = $modulesMeta[$module]['label'] ?? ucwords(str_replace('_', ' ', $module));
        @endphp
        <div class="tc-role-permissions__module mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                <h6 class="mb-0">{{ $moduleLabel }}</h6>
                <label class="mb-0 small">
                    <input type="checkbox" class="select-all-checkbox" data-module="{{ $module }}">
                    Select all
                </label>
            </div>
            <div class="row g-2">
                @foreach ($permissionsGroup as $permission)
                    <div class="col-6 col-md-4 col-lg-3">
                        <label class="tc-role-permissions__item">
                            <input type="checkbox"
                                name="permission[{{ $permission->id }}]"
                                value="{{ $permission->id }}"
                                class="permission-checkbox"
                                data-module="{{ $module }}"
                                @checked(in_array($permission->id, $rolePermissions, true))>
                            <span>{{ str_replace($module.'-', '', $permission->name) }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
