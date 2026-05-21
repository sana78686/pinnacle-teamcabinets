@extends('layouts.tenant.settings')
@section('title', 'QuickBooks')

@section('breadcrumb-title')
    <h2>QuickBooks <span>Integration</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">QuickBooks</li>
@endsection

@section('setting_content')
@if($setting?->isConnected())
    <div class="alert alert-success outline">
        <strong>Connected</strong> — Realm ID: <code>{{ $setting->realm_id }}</code>
        @if($setting->connected_at)
            · since {{ $setting->connected_at->format('M j, Y g:i A') }}
        @endif
        · Environment: {{ $setting->environment }}
    </div>
    <form action="{{ route('tenant_quickbooks_disconnect') }}" method="post" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Disconnect QuickBooks?')">Disconnect</button>
    </form>
@else
    <div class="alert alert-warning outline">
        QuickBooks is not connected. Connect to sync customers, items, invoices, and sales tax by city.
    </div>
@endif

@if(!$configured)
    <p class="text-muted small">Server credentials are missing. Add to <code>.env</code>:</p>
    <ul class="small text-muted">
        <li><code>QUICKBOOKS_CLIENT_ID</code></li>
        <li><code>QUICKBOOKS_CLIENT_SECRET</code></li>
        <li><code>QUICKBOOKS_REDIRECT_URI</code> (must match Intuit app redirect URL, e.g. https://your-tenant.test/quickbooks/callback)</li>
    </ul>
@else
    <p class="text-muted small mb-3">You will be redirected to Intuit to authorize this tenant.</p>
    <a href="{{ route('tenant_quickbooks_connect') }}" class="btn btn-success">Connect QuickBooks</a>
@endif

<p class="mt-4 small text-muted mb-0">Order checkout and product sync to QuickBooks will use these tokens in a later phase; this step stores OAuth credentials per tenant.</p>
@endsection
