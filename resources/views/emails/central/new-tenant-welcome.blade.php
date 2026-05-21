<p>Dear {{ $tenant->name ?? 'User' }},</p>
<p>Your dealer account <strong>{{ $tenant->company_name ?? $tenant->name }}</strong> has been created on {{ config('pinnacle.name', 'Pinnacle') }}.</p>
<p>{{ config('pinnacle.portal.registration_success_message') }}</p>
<p>You can sign in here:</p>
<p><a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
<p>Questions? Contact <a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a>.</p>
<p>If you did not request this account, please contact support.</p>
