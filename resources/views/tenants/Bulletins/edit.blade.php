@extends('layouts.tenant.master')
@section('title', 'Edit Bulletin')

@section('breadcrumb-title')
    <h2>Edit <span>Bulletin</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_bulletin_index') }}">Bulletins</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="card tc-bulletin-admin__card p-3 p-md-4">
        @include('tenants.Bulletins.partials.form', [
            'bulletin' => $bulletin,
            'formAction' => route('tenant_bulletin_update', $bulletin->id),
            'submitLabel' => 'Update Bulletin',
        ])
    </div>
@endsection

@section('script')
    @include('tenants.Bulletins.partials.form-script')
@endsection
