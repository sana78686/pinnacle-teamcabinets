
@extends('layouts.light.master')

@section('title', tenant('id'))

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>{{ ucfirst(tenant('id')) }}
     <span>Menu </span></h2>
@endsection

@section('breadcrumb-items')
    {{-- <li class="breadcrumb-item">Starter Kit</li>
    <li class="breadcrumb-item">Menu Options</li>
    <li class="breadcrumb-item active">Vertical Menu</li> --}}
@endsection

@section('content')
@endsection

@section('script')
@endsection
