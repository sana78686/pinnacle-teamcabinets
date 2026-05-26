@extends('layouts.tenant.settings')
@section('title', 'Paytrace')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees') }}">Tax &amp; Fees</a></li>
    <li class="breadcrumb-item active">Paytrace</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

@php
    $paytraceEnv = old('paytrace_env', $values['paytrace_env'] ?? 'production');
@endphp

<p class="text-muted small mb-3">
    Configure Paytrace for <strong>this tenant only</strong>. Use a Paytrace <strong>API user</strong> (not your web login email).
    Leave API base URL blank to use the default for the selected environment.
    Leave password blank when saving to keep the current password.
</p>

<form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_paytrace_store') }}" method="post">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <div class="tc-field">
                <label for="paytrace_env">Environment <span class="text-danger">*</span></label>
                <select name="paytrace_env" id="paytrace_env" class="form-control" required>
                    <option value="sandbox" @selected($paytraceEnv === 'sandbox')>Sandbox (testing)</option>
                    <option value="production" @selected($paytraceEnv === 'production')>Production (live)</option>
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <div class="tc-field">
                <label for="paytrace_base_url">API base URL</label>
                <input type="url" class="form-control" name="paytrace_base_url" id="paytrace_base_url"
                    placeholder="https://api.sandbox.paytrace.com or https://api.paytrace.com"
                    value="{{ old('paytrace_base_url', $values['paytrace_base_url'] ?? '') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="paytrace_integrator_id">Integrator ID</label>
                <input type="text" class="form-control" name="paytrace_integrator_id" id="paytrace_integrator_id"
                    autocomplete="off" value="{{ old('paytrace_integrator_id', $values['paytrace_integrator_id'] ?? '') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="paytrace_username">API username</label>
                <input type="text" class="form-control" name="paytrace_username" id="paytrace_username"
                    autocomplete="off" value="{{ old('paytrace_username', $values['paytrace_username'] ?? '') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="paytrace_password">API password</label>
                <input type="password" class="form-control" name="paytrace_password" id="paytrace_password"
                    autocomplete="new-password" placeholder="{{ filled($values['paytrace_password'] ?? '') ? '••••••••' : '' }}">
            </div>
        </div>
    </div>
    <div class="tc-settings-form-actions mt-3">
        <button type="submit" class="btn btn-primary">Save Paytrace settings</button>
    </div>
</form>
@endsection
