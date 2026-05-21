@extends('layouts.tenant.settings')
@section('title', 'QuickBooks')

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
        · Environment: {{ $setting->qb_environment ?? $setting->environment }}
    </div>
    <form action="{{ route('tenant_quickbooks_disconnect') }}" method="post" class="d-inline mb-3">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Disconnect QuickBooks?')">Disconnect</button>
    </form>
@else
    <div class="alert alert-warning outline">
        QuickBooks is not connected. Save your Intuit app credentials below, then connect to sync customers, items, invoices, and sales tax.
    </div>
@endif

<section class="tc-settings-section">
    <h3 class="tc-settings-section__title">Intuit app credentials (this tenant)</h3>
    <p class="text-muted small mb-3">From your Intuit Developer app. Redirect URI must match exactly what you register at developer.intuit.com.</p>

    <form class="tc-settings-form" method="POST" action="{{ route('tenant_quickbooks_store_credentials') }}" id="tc-qb-credentials-form">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="client_id">Client ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="client_id" id="client_id" required
                        value="{{ old('client_id', $setting?->client_id) }}" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="qb_environment">Environment <span class="text-danger">*</span></label>
                    <select class="form-control" name="qb_environment" id="qb_environment" required>
                        @foreach (['sandbox' => 'Sandbox (testing)', 'production' => 'Production'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('qb_environment', $setting?->qb_environment ?? 'sandbox') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="client_secret">Client Secret <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="client_secret" id="client_secret" required
                        value="{{ old('client_secret', $setting?->client_secret) }}" autocomplete="new-password">
                </div>
            </div>
            <div class="col-12">
                <div class="tc-field">
                    <label for="redirect_uri">Redirect URI <span class="text-danger">*</span></label>
                    <input type="url" class="form-control" name="redirect_uri" id="redirect_uri" required
                        value="{{ old('redirect_uri', $setting?->redirect_uri ?: $defaultRedirectUri) }}">
                    <span class="tc-field-hint">Suggested: <code>{{ $defaultRedirectUri }}</code></span>
                </div>
            </div>
        </div>
        <div class="tc-settings-form-actions mt-3 d-flex flex-wrap gap-2 align-items-center">
            <button type="submit" class="btn btn-primary">Save credentials</button>
            <button type="button" class="btn btn-outline-secondary" id="tc-qb-test-btn">Test connection</button>
            @if($configured)
                <a href="{{ route('tenant_quickbooks_connect') }}" class="btn btn-success">Connect QuickBooks</a>
            @endif
        </div>
    </form>
    <div id="tc-qb-test-result" class="mt-2 small" hidden></div>
</section>

<p class="mt-3 small text-muted mb-0">Order checkout and product sync use these tokens after OAuth connect.</p>
@endsection

@section('setting_script')
<script>
(function () {
    var btn = document.getElementById('tc-qb-test-btn');
    var box = document.getElementById('tc-qb-test-result');
    if (!btn || !box) return;

    btn.addEventListener('click', function () {
        box.hidden = false;
        box.className = 'mt-2 small text-muted';
        box.textContent = 'Testing…';

        fetch('{{ route('tenant_quickbooks_test') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        })
            .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
            .then(function (res) {
                box.className = 'mt-2 small alert outline ' + (res.data.ok ? 'alert-success' : 'alert-danger');
                box.textContent = res.data.message || (res.data.ok ? 'OK' : 'Failed');
            })
            .catch(function () {
                box.className = 'mt-2 small alert outline alert-danger';
                box.textContent = 'Test request failed.';
            });
    });
})();
</script>
@endsection
