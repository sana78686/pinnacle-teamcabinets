@extends('pinnacle.legal._layout')

@section('title', 'Subscription Terms')

@section('legal_title', 'Subscription Terms')

@section('legal_body')
<p><strong>Effective date:</strong> {{ date('F j, Y') }}</p>
<p>These Subscription Terms apply when you register for a tenant on {{ config('pinnacle.name') }} (including Team Cabinets). They supplement our <a href="{{ route('pinnacle.terms') }}">Terms of Service</a> and <a href="{{ route('pinnacle.privacy') }}">Privacy Policy</a>.</p>

<h2>1. Free trial</h2>
<p>New tenants receive a <strong>{{ config('pinnacle.trial_days') }}-day free trial</strong> with access to platform features described on our <a href="{{ route('pinnacle.services') }}">Services</a> page. Unless stated otherwise at signup, no payment is required to start the trial.</p>

<h2>2. What is included</h2>
<ul>
    <li>Provisioned tenant subdomain with public website and management panel</li>
    <li>Dedicated tenant data isolation</li>
    <li>Dealer portal, product catalog, orders, quotes, shipping quotes, stock checks</li>
    <li>Claims, bulletins, commission tools, and configurable site content</li>
    <li>QuickBooks integration setup (your QuickBooks account required)</li>
    <li>Standard transactional email for account events</li>
</ul>

<h2>3. Subdomain and branding</h2>
<p>Your tenant URL is generated from your company name (for example, <code>your-company.{{ tenant_base_domain() }}</code>). Custom domains are not selected during self-service registration; contact us for enterprise domain options.</p>

<h2>4. After the trial</h2>
<p>When the trial ends, continued access requires an active paid subscription. If you do not subscribe, we may suspend or delete the tenant after reasonable notice. Export any data you need before suspension.</p>

<h2>5. Fees and billing</h2>
<p>Pricing, billing cycle, and payment method are confirmed at checkout or in your order form. Fees are generally non-refundable except where required by law or explicitly stated in writing. Taxes may apply based on your location.</p>

<h2>6. Cancellation</h2>
<p>You may cancel per instructions in your account or by contacting support. Cancellation stops future charges; access typically continues through the end of the paid period unless otherwise agreed.</p>

<h2>7. Service levels</h2>
<p>We aim for high availability but do not guarantee uninterrupted service. Planned maintenance will be communicated when practicable.</p>

<h2>8. Support</h2>
<p>Support is available via <a href="{{ route('pinnacle.contact') }}">contact form</a> and {{ config('pinnacle.support_email') }}. Response times may vary by plan.</p>

<h2>9. Data on termination</h2>
<p>Upon termination you are responsible for exporting orders, users, and catalog data you require. We may delete tenant databases after the retention period in our privacy policy.</p>

<h2>10. Changes to plans</h2>
<p>We may modify features or pricing with notice before they apply to renewal. Existing subscribers will be notified of material changes.</p>

<h2>11. Agreement</h2>
<p>By clicking “Create account” or completing registration, you accept these Subscription Terms.</p>

<h2>12. Contact</h2>
<p><a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a> · <a href="{{ route('registeration') }}">Register</a></p>
@endsection
