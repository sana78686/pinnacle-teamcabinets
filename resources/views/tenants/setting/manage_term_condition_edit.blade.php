@extends('layouts.tenant.settings')
@section('title', 'Term-Condition Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Edit<span> Term & Conditionn Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item active">Term & Conditionn </li>
@endsection
@section('setting_content')


<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Description &nbsp;<span class="txt-danger"></span></strong>
            <input value="Description" class="form-control" name="" id="" type="text" placeholder="Description" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Description For Shipping Quote &nbsp;<span class="txt-danger"></span></strong>
            <input value="Description For Shipping Quote" class="form-control" name="" id="" type="text" placeholder="Description For Shipping Quote" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
            Update Term & Condition</button>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

