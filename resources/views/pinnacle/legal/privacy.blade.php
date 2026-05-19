@extends('pinnacle.legal._layout')

@section('title', 'Privacy Policy')

@section('legal_title', 'Privacy Policy')

@section('legal_body')
<p><strong>Effective date:</strong> {{ date('F j, Y') }}</p>
<p>{{ config('pinnacle.name') }} (“Pinnacle”, “we”, “us”) operates the central multi-tenant platform at which cabinet distributors register and receive a dedicated tenant environment (for example, Team Cabinets). This Privacy Policy explains how we collect, use, and protect information when you visit our marketing site, register a tenant, or contact us.</p>

<h2>1. Who this policy applies to</h2>
<ul>
    <li>Visitors to Pinnacle central domains (marketing, registration, contact)</li>
    <li>Tenant owners and administrators who register through Pinnacle</li>
    <li>Users whose data is stored within a specific tenant environment (dealers, affiliates, staff)</li>
</ul>
<p>Each tenant may publish its own privacy practices on its branded website; those practices apply to activity on that tenant’s domain.</p>

<h2>2. Information we collect</h2>
<p><strong>Information you provide</strong></p>
<ul>
    <li>Registration: company name, username, contact name, email, phone, address, city, state, zip, password</li>
    <li>Contact form: name, email, phone, inquiry type, message</li>
    <li>Find tenant: email address used to locate your tenant record</li>
    <li>Support correspondence and account communications</li>
</ul>
<p><strong>Information collected automatically</strong></p>
<ul>
    <li>IP address, browser type, device information, pages viewed, and referring URLs</li>
    <li>Session and security logs for fraud prevention and platform stability</li>
    <li>Cookies and similar technologies (see our <a href="{{ route('pinnacle.cookies') }}">Cookie Policy</a>)</li>
</ul>
<p><strong>Tenant business data</strong></p>
<p>Orders, quotes, dealer accounts, product catalogs, and QuickBooks-related identifiers are stored in tenant-scoped systems as part of the service.</p>

<h2>3. How we use information</h2>
<ul>
    <li>Provision and maintain your tenant (website, admin panel, subdomain)</li>
    <li>Authenticate users and enforce access controls</li>
    <li>Process orders, quotes, and dealer workflows within the platform</li>
    <li>Send service, security, and account-related communications</li>
    <li>Respond to contact and support requests</li>
    <li>Improve performance, security, and product features</li>
    <li>Comply with legal obligations and enforce our terms</li>
</ul>

<h2>4. Legal bases (where applicable)</h2>
<p>Depending on your location, we rely on contract performance, legitimate interests (security, improvement), consent (where required), and legal obligation.</p>

<h2>5. Sharing of information</h2>
<p>We do not sell your personal information. We may share data with:</p>
<ul>
    <li>Hosting and infrastructure providers</li>
    <li>Email delivery services</li>
    <li>Payment processors (when you subscribe)</li>
    <li>QuickBooks or other integrations you enable in your tenant</li>
    <li>Professional advisers or authorities when required by law</li>
</ul>

<h2>6. Data retention</h2>
<p>We retain account and tenant data while your subscription is active and for a reasonable period afterward for backups, disputes, and legal compliance. You may request deletion subject to technical and legal limits.</p>

<h2>7. Security</h2>
<p>We use administrative, technical, and organizational measures including encryption in transit, access controls, and isolated tenant data environments. No system is completely secure; please use strong passwords and protect your credentials.</p>

<h2>8. Your rights</h2>
<p>Depending on applicable law, you may request access, correction, deletion, restriction, or portability of your personal data. Contact <a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a>.</p>

<h2>9. Children</h2>
<p>Our services are intended for businesses and are not directed to children under 16.</p>

<h2>10. International transfers</h2>
<p>Data may be processed in countries where we or our providers operate. We take steps to ensure appropriate safeguards where required.</p>

<h2>11. Changes</h2>
<p>We may update this policy. Material changes will be posted on this page with an updated effective date.</p>

<h2>12. Contact</h2>
<p>Email: <a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a><br>
<a href="{{ route('pinnacle.contact') }}">Contact form</a></p>
@endsection
