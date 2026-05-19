@extends('layouts.tenant.settings')
@section('title', 'Credit Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Edit<span>Credit/Debit/Ach Charges</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Edit</li>
    <li class="breadcrumb-item active">STMP</li>
@endsection

@section('setting_content')


<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Credit Card Charges(%) &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" value="Credit Card Charges" name="" id="" type="text" placeholder="Credit Card Charges" required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>ACH Charges &nbsp;<span class="txt-danger">*</span></strong>
            <input value="ACH Charges" class="form-control" name="" id="" type="text" placeholder="ACH Charges " required autofocus>
        </div>
    </div>
    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Debit Card Charges &nbsp;<span class="txt-danger">*</span></strong>
            <input value="Debit Card Charges" class="form-control" name="" id="" type="text" placeholder="Debit Card Charges" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
          Update Credit/Debit/Ach Charges</button>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

