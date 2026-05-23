@extends('layouts.tenant.role.master')

@section('title', 'Dashboard')

@section('breadcrumb-title')
    <h2>Dashboard</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card tc-dash-card">
            <div class="card-body">
                <p class="mb-0 text-muted">Welcome, {{ tenant_panel_display_name() }}.</p>
            </div>
        </div>
    </div>
@endsection
