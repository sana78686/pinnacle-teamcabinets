@extends('pinnacle.legal._layout')

@section('title', 'Cookie Policy')

@section('legal_title', 'Cookie Policy')

@section('legal_body')
<p><strong>Effective date:</strong> {{ date('F j, Y') }}</p>
<p>This Cookie Policy explains how {{ config('pinnacle.name') }} (“we”, “us”) uses cookies and similar technologies on the central Pinnacle website (marketing, registration, login, and contact pages).</p>

<h2>1. What are cookies?</h2>
<p>Cookies are small text files stored on your device when you visit a website. They help remember preferences, keep you signed in, and understand how pages are used. Similar technologies include local storage and session identifiers.</p>

<h2>2. Cookies we use on Pinnacle central</h2>
<table style="width:100%;border-collapse:collapse;font-size:0.875rem;margin:1rem 0">
    <thead>
        <tr style="background:var(--pn-cream);text-align:left">
            <th style="padding:0.5rem;border:1px solid var(--pn-border)">Type</th>
            <th style="padding:0.5rem;border:1px solid var(--pn-border)">Purpose</th>
            <th style="padding:0.5rem;border:1px solid var(--pn-border)">Duration</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)"><strong>Essential</strong></td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Session management, CSRF protection, security</td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Session / short-term</td>
        </tr>
        <tr>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)"><strong>Functional</strong></td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Remember form inputs and UI preferences</td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Up to 12 months</td>
        </tr>
        <tr>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)"><strong>Analytics</strong></td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Understand traffic and improve the site (if enabled)</td>
            <td style="padding:0.5rem;border:1px solid var(--pn-border)">Varies</td>
        </tr>
    </tbody>
</table>

<h2>3. Tenant websites</h2>
<p>After registration, your branded tenant site (e.g. Team Cabinets on your subdomain) may set additional cookies for dealer login, shopping carts, and preferences. Those are controlled by your tenant settings and your own privacy disclosures.</p>

<h2>4. Third-party content</h2>
<p>Embedded maps (Google Maps) or fonts may set cookies governed by those providers. Review their policies for details.</p>

<h2>5. Managing cookies</h2>
<p>You can control cookies through browser settings. Blocking essential cookies may prevent registration, login, or secure form submission. To opt out of analytics where offered, use browser controls or contact us.</p>

<h2>6. Updates</h2>
<p>We may update this policy as our practices change. The effective date at the top will reflect the latest version.</p>

<h2>7. Contact</h2>
<p><a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a></p>
@endsection
