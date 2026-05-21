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
    <p class="text-muted">Commission is calculated from <strong>point factors</strong> (percentages). Set them when you approve or edit each dealer — not on this page.</p>

    <h5 class="mt-4">How it works (CI / Team Cabinets)</h5>
    <ul>
        <li><strong>Per user:</strong> assign product catalog visibility on the user form.</li>
        <li><strong>Per catalog + door style:</strong> enter door point factors for each visible catalog.</li>
        <li><strong>Taxable orders:</strong> use the &quot;Taxable user&quot; checkbox on the user record (<code>is_taxable_user</code>).</li>
        <li><strong>Formula:</strong> Commission = Gross sales × (Point factor ÷ 100)</li>
    </ul>

    <div class="alert alert-warning outline mt-3">
        Set point factors immediately after approving a user. Late changes affect commission reports.
    </div>

    <div class="tc-settings-form-actions">
        <a href="{{ route('tenant_user_index') }}" class="btn btn-primary">Manage users &amp; point factors</a>
        <a href="{{ route('tenant_commission_report_index') }}" class="btn btn-light">Commission reports</a>
    </div>
</div>
@endsection
