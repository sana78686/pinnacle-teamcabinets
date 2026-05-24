@extends('layouts.tenant.master')
@section('title', 'Support Chat')

@section('breadcrumb-title')
    <h2>Support<span>Chat</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Support</li>
    <li class="breadcrumb-item">Chat</li>
@endsection

@section('content')
    @include('partial.message')
    @include('tenants.support_chat.vue-app')
@endsection

@section('script')
    @include('tenants.support_chat.scripts', ['vueConfig' => $vueConfig])
@endsection
