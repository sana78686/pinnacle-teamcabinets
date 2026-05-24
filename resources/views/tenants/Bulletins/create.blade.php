@extends('layouts.tenant.master')
@section('title', 'Add Bulletin')

@section('breadcrumb-title')
    <h2>Add <span>Bulletin</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_bulletin_index') }}">Bulletins</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="card tc-bulletin-admin__card p-3 p-md-4">
        <p class="text-muted mb-3">Post a bulletin to the role-user dashboard. Choose <strong>Every One</strong> for all roles, or <strong>Specific User</strong> and pick a user type (same as the legacy CI panel).</p>
        @include('tenants.Bulletins.partials.form', [
            'submitLabel' => 'Create Bulletin',
        ])
    </div>
@endsection

@section('script')
    @include('tenants.Bulletins.partials.form-script')
@endsection
