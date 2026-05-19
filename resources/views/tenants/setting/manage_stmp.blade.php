@extends('layouts.tenant.settings')
@section('title', 'SMTP Settings')

@section('breadcrumb-title')
    <h2>SMTP <span>Settings</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">SMTP</li>
@endsection

@section('setting_content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($smtp?->is_verified)
    <div class="alert alert-success mb-3">
        <i class="fa-solid fa-circle-check"></i> SMTP verified
        @if($smtp->verified_at)
            — last tested {{ $smtp->verified_at->diffForHumans() }}
        @endif
    </div>
@else
    <div class="alert alert-warning mb-3">
        Configure SMTP below, then click <strong>Test connection</strong> before sending order or customer emails.
    </div>
@endif

<p class="text-muted small mb-3">
    Outgoing mail to your customers uses this mailbox. Admin alerts (contact form, orders) go to emails set under
    <a href="{{ route('tenant_site_setting') }}">Site Settings</a>.
</p>

<form id="smtpForm" class="tc-settings-form" action="{{ route('tenant_setting_manage_stmp_create') }}" method="post">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <div class="tc-field">
                <label for="smtp_host">SMTP host <span class="text-danger">*</span></label>
                <input class="form-control" name="smtp_host" id="smtp_host" type="text" placeholder="smtp.gmail.com"
                    value="{{ old('smtp_host', $smtp->smtp_host ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="smtp_port">Port <span class="text-danger">*</span></label>
                <input class="form-control" name="smtp_port" id="smtp_port" type="number" placeholder="587"
                    value="{{ old('smtp_port', $smtp->smtp_port ?? 587) }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="smtp_encryption">Encryption <span class="text-danger">*</span></label>
                <select class="form-control" name="smtp_encryption" id="smtp_encryption" required>
                    @foreach(['tls' => 'TLS (587)', 'ssl' => 'SSL (465)', 'none' => 'None'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('smtp_encryption', $smtp->smtp_encryption ?? 'tls') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="smtp_username">Username <span class="text-danger">*</span></label>
                <input class="form-control" name="smtp_username" id="smtp_username" type="text"
                    value="{{ old('smtp_username', $smtp->smtp_username ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="smtp_password">Password @if(!$smtp)<span class="text-danger">*</span>@else<span class="text-muted">(leave blank to keep)</span>@endif</label>
                <input class="form-control" name="smtp_password" id="smtp_password" type="password" autocomplete="new-password"
                    @if(!$smtp) required @endif>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="from_email">From email <span class="text-danger">*</span></label>
                <input class="form-control" name="from_email" id="from_email" type="email"
                    value="{{ old('from_email', $smtp->from_email ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="from_name">From name</label>
                <input class="form-control" name="from_name" id="from_name" type="text"
                    value="{{ old('from_name', $smtp->from_name ?? tenant('company_name') ?? tenant('name')) }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="tc-field">
                <label for="test_recipient">Test send to (optional)</label>
                <input class="form-control" name="test_recipient" id="test_recipient" type="email"
                    placeholder="Defaults to From email">
            </div>
        </div>
    </div>

    <div class="tc-settings-form-actions d-flex flex-wrap gap-2 mt-3">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-floppy-disk"></i> Save SMTP
        </button>
        <button type="button" id="btnTestSmtp" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-plug"></i> Test connection
        </button>
    </div>
    <div id="smtpTestResult" class="mt-2 small" aria-live="polite"></div>
</form>
@endsection

@section('setting_script')
<script>
document.getElementById('btnTestSmtp')?.addEventListener('click', function () {
    const btn = this;
    const result = document.getElementById('smtpTestResult');
    const form = document.getElementById('smtpForm');
    const data = new FormData(form);

    btn.disabled = true;
    result.textContent = 'Testing connection…';
    result.className = 'mt-2 small text-muted';

    fetch('{{ route('tenant_setting_test_smtp') }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: data
    })
    .then(r => r.json())
    .then(json => {
        result.textContent = json.message || (json.success ? 'Connected.' : 'Failed.');
        result.className = 'mt-2 small ' + (json.success ? 'text-success' : 'text-danger');
        if (json.success) {
            setTimeout(() => window.location.reload(), 1500);
        }
    })
    .catch(() => {
        result.textContent = 'Request failed. Check your network and try again.';
        result.className = 'mt-2 small text-danger';
    })
    .finally(() => { btn.disabled = false; });
});
</script>
@endsection
