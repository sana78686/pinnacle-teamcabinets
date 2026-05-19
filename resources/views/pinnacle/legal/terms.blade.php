@extends('pinnacle.legal._layout')

@section('title', 'Terms of Service')

@section('legal_title', 'Terms of Service')

@section('legal_body')
<p><strong>Effective date:</strong> {{ date('F j, Y') }}</p>
<p>These Terms of Service (“Terms”) govern access to and use of the {{ config('pinnacle.name') }} central platform and related registration services. By using Pinnacle or registering a tenant, you agree to these Terms and our <a href="{{ route('pinnacle.privacy') }}">Privacy Policy</a>.</p>

<h2>1. The service</h2>
<p>Pinnacle provides a multi-tenant software platform for cabinet distributors and related businesses. Features may include public websites, dealer/affiliate portals, product catalogs, ordering, quotes, shipping quotes, stock checks, claims, bulletins, commission reporting, QuickBooks integration, and administrative tools. Team Cabinets is a reference implementation available as a tenant on the platform.</p>

<h2>2. Eligibility</h2>
<p>You must be at least 18 years old and authorized to bind your business. You represent that registration information is accurate and that you will keep it current.</p>

<h2>3. Accounts and security</h2>
<ul>
    <li>You are responsible for credentials and all activity under your account</li>
    <li>Notify us promptly of unauthorized access</li>
    <li>We may suspend accounts that violate these Terms or pose security risk</li>
</ul>

<h2>4. Acceptable use</h2>
<p>You agree not to:</p>
<ul>
    <li>Violate applicable laws or third-party rights</li>
    <li>Upload malware or attempt unauthorized access to other tenants or systems</li>
    <li>Interfere with platform availability or integrity</li>
    <li>Use the service for fraudulent orders or misrepresentation of products</li>
    <li>Scrape or reverse engineer the platform except as permitted by law</li>
</ul>

<h2>5. Tenant content and data</h2>
<p>You retain ownership of content you upload (catalogs, documents, branding). You grant us a license to host, process, and display that content solely to provide the service. You are responsible for accuracy of product, pricing, and tax information shown to your dealers.</p>

<h2>6. Third-party services</h2>
<p>Integrations such as QuickBooks, payment gateways, or email providers are subject to their own terms. We are not responsible for third-party outages or data handling outside our platform.</p>

<h2>7. Trial and subscription</h2>
<p>Trials and paid subscriptions are described in our <a href="{{ route('pinnacle.subscription-terms') }}">Subscription Terms</a>. Fees, renewal, and cancellation rules apply when you subscribe after a trial.</p>

<h2>8. Intellectual property</h2>
<p>Pinnacle software, branding, and documentation are our property or our licensors’. You may not copy or create derivative works except as allowed by these Terms or written permission.</p>

<h2>9. Disclaimer</h2>
<p>THE SERVICE IS PROVIDED “AS IS” AND “AS AVAILABLE.” TO THE MAXIMUM EXTENT PERMITTED BY LAW, WE DISCLAIM WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. We do not guarantee uninterrupted or error-free operation.</p>

<h2>10. Limitation of liability</h2>
<p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, WE ARE NOT LIABLE FOR INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES. OUR TOTAL LIABILITY FOR CLAIMS ARISING FROM THE SERVICE IS LIMITED TO THE AMOUNT YOU PAID US IN THE TWELVE (12) MONTHS BEFORE THE CLAIM.</p>

<h2>11. Indemnification</h2>
<p>You will defend and indemnify us against claims arising from your content, your dealers’ use, or your violation of these Terms, except to the extent caused by our gross negligence or willful misconduct.</p>

<h2>12. Termination</h2>
<p>You may stop using the service by cancelling per Subscription Terms. We may suspend or terminate access for breach, non-payment, or legal requirement. Provisions that by nature should survive will survive termination.</p>

<h2>13. Governing law</h2>
<p>These Terms are governed by the laws of the State of Texas, USA, without regard to conflict-of-law rules, unless mandatory local law requires otherwise. Disputes shall be resolved in courts located in Dallas County, Texas, unless otherwise agreed in writing.</p>

<h2>14. Changes</h2>
<p>We may modify these Terms. Continued use after notice constitutes acceptance. Check this page periodically.</p>

<h2>15. Contact</h2>
<p><a href="mailto:{{ config('pinnacle.support_email') }}">{{ config('pinnacle.support_email') }}</a> · <a href="{{ route('pinnacle.contact') }}">Contact us</a></p>
@endsection
