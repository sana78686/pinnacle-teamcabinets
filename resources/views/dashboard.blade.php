@extends('layouts.mega.master')
@section('style')
<style>
.card-body{
    padding: 30px !important;
}

</style>

@endsection

@section('content')
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

   <div class="container-fluid general-widget">
    <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6">
        <div class="card gradient-primary o-hidden">
          <div class="b-r-4 card-body">
            <div class="d-flex static-top-widget">
              <div class="align-self-center text-center"><i data-feather="database"></i></div>
              <div class="flex-grow-1"><span class="m-0 text-white">Total Tenants</span>
                <h4 class="mb-0 counter">{{ $tenantCount ?? 0 }}</h4><i class="icon-bg" data-feather="database"></i>
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
              <div class="flex-grow-1"><span class="m-0 text-white">Representatives</span>
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

    </div>
</div>

@endsection
