@forelse ($users as $user)
    @php
        $statusSkin = tenant_user_status_skin($user->status);
        $isVerified = (bool) $user->is_verified_by_admin;
        $isAdminUser = tenant_user_has_admin_role($user);
    @endphp
    <tr data-tc-user-row-id="{{ $user->id }}">
        <td>
            @if (!empty($user->getRoleNames()))
                @forelse ($user->getRoleNames() as $v)
                    <span class="tc-role-badge">{{ $v ?? 'N/A' }}</span>
                @empty
                    <label class="badge bg-warning">N/A</label>
                @endforelse
            @else
                <label class="badge bg-warning">N/A</label>
            @endif
        </td>
        <td>{{ $user->username ?? 'N/A' }}</td>
        <td>{{ $user->name ?? 'N/A' }}</td>
        <td>
            <span class="email-text" id="email-{{ $user->id }}">{{ $user->email ?? 'N/A' }}</span>
            <i class="fa fa-copy txt-large" id="copy-email-{{ $user->id }}" style="cursor: pointer;"></i>
        </td>
        <td>
            @if ($isAdminUser)
                <span class="tc-user-status-select tc-user-status-select--{{ $statusSkin['skin'] }} tc-user-status-select--readonly"
                    aria-label="Account status for {{ $user->name ?? $user->username }}">
                    {{ $statusSkin['label'] }}
                </span>
            @else
                <select
                    class="tc-user-status-select tc-user-status-select--{{ $statusSkin['skin'] }}"
                    data-tc-user-status-select
                    data-user-id="{{ $user->id }}"
                    data-current-status="{{ $user->status }}"
                    aria-label="Change account status for {{ $user->name ?? $user->username }}"
                >
                    @foreach (tenant_user_status_options() as $value => $label)
                        <option value="{{ $value }}" @selected($user->status === $value)>{{ $label }}</option>
                    @endforeach
                    @if ($user->status && ! array_key_exists($user->status, tenant_user_status_options()))
                        <option value="{{ $user->status }}" selected>{{ $statusSkin['label'] }}</option>
                    @endif
                </select>
            @endif
        </td>
        <td>
            @if ($isVerified)
                <span class="tc-verify-pill tc-verify-pill--verified" title="Verified by admin">
                    <span class="tc-verify-pill__dot" aria-hidden="true"></span>
                    <span class="tc-verify-pill__label">Verified</span>
                </span>
            @else
                <button
                    type="button"
                    class="tc-verify-pill tc-verify-pill--pending admin-verify-toggle"
                    data-user-id="{{ $user->id }}"
                    data-current-status="unverified"
                    title="Click to verify this user"
                >
                    <span class="tc-verify-pill__dot" aria-hidden="true"></span>
                    <span class="tc-verify-pill__label">Need verification</span>
                </button>
            @endif
        </td>
        <td data-tc-user-door-summary>
            @php
                $catalogs = (int) ($user->catalogs_configured ?? 0);
                $doors = (int) ($user->door_styles_configured ?? 0);
            @endphp
            @if ($catalogs > 0 || $doors > 0)
                <span class="tc-door-factor-summary" title="{{ $catalogs }} catalog(s), {{ $doors }} door style(s)">
                    {{ $catalogs }} catalog{{ $catalogs === 1 ? '' : 's' }}, {{ $doors }} door{{ $doors === 1 ? '' : 's' }}
                </span>
            @else
                <span class="text-muted small">Not configured</span>
            @endif
            @unless ($isAdminUser)
                <button type="button" class="btn btn-link btn-sm p-0 ms-1 align-baseline"
                    data-tc-user-catalog-setup data-user-id="{{ $user->id }}">
                    Set catalogs
                </button>
            @endunless
        </td>
        <td>{{ $user->created_at->format('d-m-Y') ?? 'N/A' }}</td>
        <td class="tc-admin-datatable__actions">
            <a href="{{ route('tenant_user_show', $user->id) }}" class="tc-admin-datatable__edit"
                data-toggle="tooltip" title="View details of this user">Show</a>
            @unless ($isAdminUser)
                <span class="text-muted mx-1">|</span>
                <a href="{{ route('tenant_user_edit', $user->id) }}" class="tc-admin-datatable__edit"
                    data-toggle="tooltip" title="Edit this user's information">Edit</a>
                <span class="text-muted mx-1">|</span>
                <a href="#" class="tc-admin-datatable__edit text-danger" data-toggle="tooltip"
                    title="Delete this user" onclick="deleteUser({{ $user->id }}); return false;">Delete</a>
                <form id="deleteForm{{ $user->id }}" method="POST"
                    action="{{ route('tenant_user_destroy', $user->id) }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endunless
        </td>
    </tr>
@empty
    @if (($search ?? '') !== '')
        @include('partials.tc-admin-datatable-empty', [
            'colspan' => 9,
            'icon' => 'icofont-search-1',
            'message' => 'No users match your search.',
        ])
    @else
        @include('partials.tc-admin-datatable-empty', [
            'colspan' => 9,
            'icon' => 'icofont-users',
            'message' => 'No users found.',
            'hint' => 'Add a user to get started.',
        ])
    @endif
@endforelse
