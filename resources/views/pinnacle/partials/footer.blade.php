@php $pinnacle = $pinnacle ?? config('pinnacle'); @endphp
<footer class="pn-footer">
    <div class="pn-container">
        <div class="pn-footer__grid">
            <div class="pn-footer__brand">
                <img src="{{ asset('assets/logo/pinnacle.png') }}" alt="{{ $pinnacle['name'] }}">
                <p>{{ $pinnacle['tagline'] }}. Website, dealer portal, orders, and QuickBooks — everything you need to run your cabinets business online.</p>
            </div>
            <div>
                <h4>Platform</h4>
                <ul>
                    <li><a href="{{ route('pinnacle.services') }}">Services</a></li>
                    <li><a href="{{ route('pinnacle.team-cabinets') }}">Team Cabinets</a></li>
                    <li><a href="{{ route('pinnacle.find-tenant') }}">Find tenant</a></li>
                    <li><a href="{{ route('registeration') }}">Get started</a></li>
                </ul>
            </div>
            <div>
                <h4>Legal</h4>
                <ul>
                    <li><a href="{{ route('pinnacle.privacy') }}">Privacy</a></li>
                    <li><a href="{{ route('pinnacle.terms') }}">Terms</a></li>
                    <li><a href="{{ route('pinnacle.cookies') }}">Cookies</a></li>
                    <li><a href="{{ route('pinnacle.subscription-terms') }}">Subscription terms</a></li>
                </ul>
            </div>
            <div>
                <h4>Contact</h4>
                <ul>
                    <li><a href="{{ route('pinnacle.contact') }}">Contact us</a></li>
                    <li><a href="mailto:{{ $pinnacle['support_email'] }}">{{ $pinnacle['support_email'] }}</a></li>
                    <li><a href="{{ route('auth_login') }}">Admin login</a></li>
                </ul>
            </div>
        </div>
        <div class="pn-footer__bottom">&copy; {{ now()->year }} {{ $pinnacle['name'] }}. All rights reserved.</div>
    </div>
</footer>
