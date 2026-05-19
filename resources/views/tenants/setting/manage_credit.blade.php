@extends('layouts.tenant.settings')
@section('title', 'Credit Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Create<span>Credit/Debit/Ach Charges </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Create</li>
    <li class="breadcrumb-item active">Credit</li>
@endsection

@section('setting_content')


<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Credit Card Charges(%) &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="Credit Card Charges" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>ACH Charges &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="ACH Charges " required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Debit Card Charges &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" id="" type="text" placeholder="Debit Card Charges" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
           Create Credit/Debit/Ach Charges</button>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

