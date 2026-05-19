@extends('layouts.tenant.settings')
@section('title', 'STMP Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Create<span>STMP</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">Create</li>
    <li class="breadcrumb-item active">STMP</li>
@endsection

@section('setting_content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form class="tc-settings-form" action="{{ route('tenant_setting_manage_stmp_create') }}" method="post">
    @csrf
<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>SMTP Host &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="SMTP Host" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>SMTP Username &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="SMTP Username " required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>SMTP Password &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="SMTP Password" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>From Email &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="From Email" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>SMTP Port &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="SMTP Port " required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>SMTP Encryption &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="SMTP Encryption" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
           Create STMP</button>
    </div>
</div>
</form>
@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

