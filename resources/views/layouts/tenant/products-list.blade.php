@extends('layouts.tenant.master')

@section('breadcrumb-title')
    <h2>Products</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="container-fluid tc-products-page pl-0">
        <div class="tc-products-hub mb-0">
            @hasSection('products_title')
                <h3 class="tc-products-page-title mb-2">@yield('products_title')</h3>
            @endif
            @include('layouts.tenant.partials.products-list-tabs')
            <div class="tc-products-panel mt-3">
                @include('partial.message')
                @yield('products_content')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection
