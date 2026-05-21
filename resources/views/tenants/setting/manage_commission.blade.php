@extends('layouts.tenant.settings')
@section('title', 'Commission & Point Factors')

@section('breadcrumb-title')
    <h2>Commission <span>&amp; Point Factors</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Commission</li>
@endsection

@section('setting_content')
<div class="tc-settings-panel-content">
    @include('partial.message')

    <p class="text-muted">Commission is calculated from <strong>door point factors</strong> (decimals, e.g. <code>0.24</code> = 24%). Configure role defaults here; assign per-user factors on the user form.</p>

    <h5 class="mt-4">How it works</h5>
    <ul>
        <li><strong>This page:</strong> default point factor per role (used by &quot;Apply default for role&quot; on Create User).</li>
        <li><strong>Users → Create/Edit:</strong> catalog visibility + door point factor per catalog and door style.</li>
        <li><strong>Formula:</strong> Commission = Gross sales × (Point factor ÷ 100) when factor is stored as a decimal.</li>
    </ul>

    <h5 class="mt-4">Default point factors by role</h5>
    @if ($roles->isEmpty())
        <div class="alert alert-warning outline">No assignable roles found. Configure roles under <strong>Settings → Roles</strong> first.</div>
    @else
        <form method="POST" action="{{ route('tenant_setting_commission_store') }}" class="tc-settings-form">
            @csrf
            <div class="table-responsive">
                <table class="table table-sm table-bordered tc-settings-table">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Point factor (decimal)</th>
                            <th>As %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            @php
                                $key = Str::slug(strtolower($role->name), '-');
                                $value = $defaults[$key] ?? $defaults[str_replace('-', '_', $key)] ?? null;
                            @endphp
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <input type="number" step="0.0001" min="0" max="1"
                                        name="defaults[{{ $key }}]"
                                        class="form-control form-control-sm"
                                        value="{{ $value !== null ? (string) $value : '' }}"
                                        placeholder="e.g. 0.24">
                                </td>
                                <td class="text-muted small">
                                    @if ($value !== null)
                                        {{ number_format((float) $value * 100, 2) }}%
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tc-settings-form-actions mt-3">
                <button type="submit" class="btn btn-primary">Save default door factors</button>
            </div>
        </form>
    @endif

    <div class="tc-settings-form-actions mt-4">
        <a href="{{ route('tenant_user_index') }}" class="btn btn-light">User list</a>
        <a href="{{ route('tenant_user_create') }}" class="btn btn-outline-primary">Create user (per-user factors)</a>
        <a href="{{ route('tenant_commission_report_index') }}" class="btn btn-light">Commission reports</a>
    </div>
</div>
@endsection
