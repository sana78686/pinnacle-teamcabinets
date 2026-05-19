@extends('layouts.tenant.master')
@section('title', 'Coming-Soon')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<!-- Maintenance start-->
<div class="error-wrapper maintenance-bg p-0 m-0">
   <div class="">
      <ul class="maintenance-icons">
         {{-- <li><i class="fa fa-cog"></i></li>
         <li><i class="fa fa-cog"></i></li>
         <li><i class="fa fa-cog"></i></li> --}}
      </ul>
      <div class="maintenance-heading mt-0">
         <h2 class="headline">Coming Soon</h2>
      </div>
      <h4 class="sub-content">Our Site is Currently under maintenance We will be back Shortly<br>                Thank You For Patience</h4>
      <div><a class="btn btn-info-gradien btn-lg text-light" href="{{ route('tenant_dashboard') }}">BACK TO HOME PAGE</a></div>
   </div>
</div>
<!-- Maintenance end-->
@endsection

@section('script')
@endsection
