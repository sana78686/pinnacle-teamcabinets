@extends('layouts.tenant.settings')
@section('title', 'Contact-us Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Edit<span>Contact Us Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Contact</li>
    <li class="breadcrumb-item active">Us</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('setting_content')

    <div class="row g-3 tc-settings-form-row">

        <div class="col-md-4 ">
            <div class="form-group">
                <strong>Meta Title  &nbsp;<span class="txt-danger">*</span></strong>
                <input value="Meta Title" class="form-control" name="" id="" type="text" placeholder="" required autofocus>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <strong>Meta Keywords &nbsp;<span class="txt-danger">*</span></strong>
                <input value="Meta Keywords" class="form-control" name="" id="" type="text" placeholder="" required autofocus>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <strong>Meta Description &nbsp;<span class="txt-danger">*</span></strong>
                <input value="Meta Description" type="text" name="name" placeholder="Name" class="form-control" required autofocus>
            </div>
        </div>

        <div class="col-12 tc-settings-form-actions">
            <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
            Update Contact us</button>
        </div>
    </div>
@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection
