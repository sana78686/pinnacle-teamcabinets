@extends('layouts.tenant.settings')
@section('title', 'About-us Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>About Us<span> Setting</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Setting</li>
    <li class="breadcrumb-item">About</li>
    <li class="breadcrumb-item active">Us</li>

@endsection

@section('setting_content')

<div class="p-2 mt-0 card-header no-border">
    {{-- <h5>Best Selling Product</h5> --}}
    <a href="{{ route('tenant_setting_manage_success_list') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
        title="Create a new user in the system">
        <i class="icofont icofont-plus"></i> Create About Us Setting
    </a>

    <a   href="{{ route('tenant_deleted_manage_success_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Restore a previously deleted user">
        <i class="icofont icofont-spinner-alt-3"></i> Restore  About Us Setting
    </a>
    <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
        <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
    </a>
    <div class=" pull-right">
        <!-- Import & Export Buttons -->
        <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Export user data to a file">
            <i class="text-white icofont icofont-upload-alt"></i> Export
        </button>

        <button class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import user data from a file">
            <i class="text-white icofont icofont-download-alt"></i> Import
        </button>
    </div>
</div>

    <div class="row g-3 tc-settings-form-row">

        <div class="col-md-4 ">
            <div class="form-group">
                <strong>Title &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control" name="" id="" type="text" placeholder="John Mahan" required autofocus>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <strong>Description &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control" name="" id="" type="text" placeholder="" required autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <strong>Meta Title &nbsp;<span class="txt-danger">*</span></strong>
                <input type="text" name="name" placeholder="Team Cabinets" class="form-control" required autofocus>
            </div>
        </div>


        <div class="col-md-4 ">
            <div class="form-group">
                <strong>Meta Keywords &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control" name="" id="" type="text" placeholder="cabinetry" required autofocus>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <strong>Meta Description &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control" name="" id="" type="text" placeholder="Team Cabinets" required autofocus>
            </div>
        </div>
        <div class="col-12 tc-settings-form-actions">
            <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
                About us</button>
        </div>
    </div>







@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

