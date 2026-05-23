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
<div class="tc-settings-panel-content" data-tc-commission-settings
    data-patch-base="{{ url('setting/manage_commission') }}/">
    @include('partial.message')

    <p class="text-muted">Commission is calculated from <strong>point factors</strong> (decimals, e.g. <code>0.24</code> = 24%). Changes save automatically when you leave each field.</p>

    <h5 class="mt-4">How it works</h5>
    <ul class="small">
        <li><strong>This page:</strong> default point factor per role (auto-fills Create User).</li>
        <li><strong>Users → Create/Edit:</strong> catalog visibility + door point factor per catalog and door style.</li>
        <li><strong>Formula:</strong> Commission ≈ Gross sales × point factor (when stored as decimal).</li>
    </ul>

    <h5 class="mt-4">Default point factors by role</h5>
    @if ($roles->isEmpty())
        <div class="alert alert-warning outline">No assignable roles found. Configure roles under <strong>Settings → Roles</strong> first.</div>
    @else
        <div class="table-responsive">
            <table class="table table-sm table-bordered tc-settings-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th style="min-width:160px">Point factor (decimal)</th>
                        <th>As %</th>
                        <th style="width:90px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        @php
                            $key = tenant_role_factor_key($role->name);
                            $value = $defaultsByRole[$role->name] ?? null;
                        @endphp
                        <tr data-tc-commission-role="{{ $key }}">
                            <td>{{ $role->name }}</td>
                            <td>
                                <input type="number" step="0.0001" min="0" max="1"
                                    data-tc-commission-input
                                    class="form-control form-control-sm"
                                    value="{{ $value !== null ? (string) $value : '' }}"
                                    placeholder="e.g. 0.24">
                            </td>
                            <td class="text-muted small" data-tc-commission-pct>
                                @if ($value !== null)
                                    {{ number_format((float) $value * 100, 2) }}%
                                @else
                                    —
                                @endif
                            </td>
                            <td class="small text-muted">Auto-save</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-muted small mb-0">Tip: use <strong>Save all</strong> below if you prefer a single submit instead of inline saves.</p>
        <form method="POST" action="{{ route('tenant_setting_commission_store') }}" class="tc-settings-form mt-3">
            @csrf
            @foreach ($roles as $role)
                @php
                    $key = tenant_role_factor_key($role->name);
                    $value = $defaultsByRole[$role->name] ?? null;
                @endphp
                <input type="hidden" name="defaults[{{ $key }}]" value="{{ $value !== null ? (string) $value : '' }}"
                    data-sync-from-role="{{ $key }}">
            @endforeach
            <button type="submit" class="btn btn-light btn-sm">Save all (page reload)</button>
        </form>
    @endif

    <div class="tc-settings-form-actions mt-4">
        <a href="{{ route('tenant_user_index') }}" class="btn btn-light">User list</a>
        <a href="{{ route('tenant_user_create') }}" class="btn btn-outline-primary">Create user</a>
        <a href="{{ route('tenant_commission_report_index') }}" class="btn btn-light">Commission reports</a>
    </div>
</div>
@endsection

@section('script')
<script src="{{ tenant_panel_asset('js/tenant-commission-settings.js') }}?v=1"></script>
@endsection
