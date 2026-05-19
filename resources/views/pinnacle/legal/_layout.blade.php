@extends('pinnacle.layouts.app')

@section('content')
<section class="pn-section pn-section--white">
    <div class="pn-container pn-legal">
        <h1>@yield('legal_title')</h1>
        <p class="pn-legal-meta">Last updated: {{ date('F j, Y') }}</p>
        <div>@yield('legal_body')</div>
    </div>
</section>
@endsection
