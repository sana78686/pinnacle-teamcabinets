@extends('layouts.tenant.master')
@section('title', 'Quote Details')

@section('breadcrumb-title')
    <h2>Quote<span> Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_quotes_index') }}">Quotes</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
    @include('tenants.quotes.partials.quote-workspace-show', $quoteView)
@endsection
