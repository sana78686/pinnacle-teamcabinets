@extends('layouts.tenant.settings')
@section('title', 'Doocument Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Create<span> Document</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">Create</li>
    <li class="breadcrumb-item active">Document</li>
@endsection

@section('setting_content')


<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Select User Type  &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="Select User Type" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Select File &nbsp;<span class="txt-danger"> *</span></strong>
            <input class="form-control" name="" id="" type="file" placeholder="Select File" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
           Create Document</button>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

