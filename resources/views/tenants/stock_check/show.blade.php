@extends($isAdminView ?? false ? 'layouts.tenant.master' : 'layouts.tenant.role.master')
@section('title', 'Stock Check Request')

@section('content')
    @include('tenants.stock_check.partials.admin-show')
@endsection

@section('script')
    @if ($isAdminView ?? false)
        <script src="{{ tenant_static_asset('js/stock-check-admin.js') }}?v=3"></script>
    @else
        <script src="{{ tenant_static_asset('js/stock-check-user.js') }}?v=1"></script>
    @endif
@endsection
