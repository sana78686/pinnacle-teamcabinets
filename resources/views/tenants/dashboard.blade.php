@extends('layouts.tenant.master')

@section('title', tenant('id'))

@section('css')
@endsection

@section('style')
<style>
.card-body{
    padding: 30px !important;
}

</style>

@endsection

@section('breadcrumb-title')
<h2>{{ ucfirst(tenant('id')) }}
    <span>Menu </span>
</h2>
@endsection

@section('breadcrumb-items')
{{-- <li class="breadcrumb-item">Starter Kit</li>
<li class="breadcrumb-item">Menu Options</li>
<li class="breadcrumb-item active">Vertical Menu</li> --}}
@endsection

@section('content')
@include('tenants.partials.onboarding-checklist')
<div class="container-fluid general-widget">
    <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-primary o-hidden">
          <div class="b-r-4 card-body">
            <div class="d-flex static-top-widget">
              <div class="align-self-center text-center"><i data-feather="database"></i></div>
              <div class="flex-grow-1"><span class="m-0 text-white">Total Users</span>
                <h4 class="mb-0 counter">{{ $totalUsers ?? 0 }}</h4><i class="icon-bg" data-feather="database"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-secondary o-hidden">
          <div class="b-r-4 card-body">
            <div class="d-flex static-top-widget">
              <div class="align-self-center text-center"><i data-feather="shopping-bag"></i></div>
              <div class="flex-grow-1"><span class="m-0">Products</span>
                <h4 class="mb-0 counter">9856</h4><i class="icon-bg" data-feather="shopping-bag"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-warning o-hidden">
          <div class="b-r-4 card-body">
            <div class="d-flex static-top-widget">
              <div class="align-self-center text-center">
                <div class="text-white i" data-feather="message-circle"></div>
              </div>
              <div class="flex-grow-1"><span class="m-0 text-white">Total Representatives</span>
                <h4 class="mb-0 counter text-white">{{ $representativeCount ?? 0 }}</h4><i class="icon-bg" data-feather="message-circle"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-info o-hidden">
          <div class="b-r-4 card-body">
            <div class="d-flex static-top-widget">
              <div class="align-self-center text-center">
                <div class="text-white i" data-feather="user-plus"></div>
              </div>
              <div class="flex-grow-1"><span class="m-0 text-white">New User</span>
                <h4 class="mb-0 counter text-white">45631</h4><i class="icon-bg" data-feather="user-plus"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-primary h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="fw-bold">{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-people-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}

        <!-- Total Tenants -->
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-success h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Tenants</h5>
                        <h2 class="fw-bold">{{ $tenantCount ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-building fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}

        <!-- Total Representatives -->
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-secondary h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Representatives</h5>
                        <h2 class="fw-bold">{{ $representativeCount ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-person-badge fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}

        <!-- Total Dealers -->
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-warning h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Dealers</h5>
                        <h2 class="fw-bold">{{ $dealerCount ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-briefcase-fill fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}

        <!-- Total Distributors -->
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-danger h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Distributors</h5>
                        <h2 class="fw-bold">{{ $distributorCount ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-truck fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}

        <!-- Total Showrooms -->
        {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card text-white bg-info h-100 shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Showrooms</h5>
                        <h2 class="fw-bold">{{ $showroomCount ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-shop fs-1 opacity-75"></i>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@section('script')
@endsection
