<p>Dear {{ $tenant->name ?? 'User' }},</p>
<p>Your tenant account <strong>{{ $tenant->company_name ?? $tenant->name }}</strong> has been created on {{ config('pinnacle.name', 'Pinnacle') }}.</p>
<p>You can sign in here:</p>
<p><a href="{{ $loginUrl }}">{{ $loginUrl }}</a></p>
<p>If you did not request this account, please contact support.</p>
