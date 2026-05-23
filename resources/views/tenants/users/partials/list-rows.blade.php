@forelse ($users as $user)
    @php
        $statusSkin = tenant_user_status_skin($user->status);
        $isVerified = (bool) $user->is_verified_by_admin;
    @endphp
    <tr class="{{ tenant_admin_unviewed_row_class($user) }}">
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
        <td>{{ $user->created_at->format('d-m-Y') ?? 'N/A' }}</td>
        <td class="tc-admin-datatable__actions">
            <a href="{{ route('tenant_user_show', $user->id) }}" class="tc-admin-datatable__edit"
                data-toggle="tooltip" title="View details of this user">Show</a>
            @unless (tenant_user_has_admin_role($user))
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
            @else
                <span class="text-muted small ms-1" data-toggle="tooltip"
                    title="Admin accounts are updated from Settings → Profile">Profile only</span>
            @endunless
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted py-4">
            @if (($search ?? '') !== '')
                No users match your search.
            @else
                No users found.
            @endif
        </td>
    </tr>
@endforelse
