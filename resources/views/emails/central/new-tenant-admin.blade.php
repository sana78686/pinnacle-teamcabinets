<p>Hello,</p>
<p>A new tenant has been registered on {{ config('pinnacle.name', 'Pinnacle') }}.</p>
<ul>
    <li><strong>Company:</strong> {{ $tenant->company_name ?? $tenant->name }}</li>
    <li><strong>Contact:</strong> {{ $tenant->name }}</li>
    <li><strong>Email:</strong> {{ $tenant->email }}</li>
    <li><strong>Domain:</strong> {{ $tenant->domain_name ?? tenant_url($tenant->id) }}</li>
    <li><strong>Tenant ID:</strong> {{ $tenant->id }}</li>
</ul>
<p>Please review the tenant in the Pinnacle admin panel.</p>
