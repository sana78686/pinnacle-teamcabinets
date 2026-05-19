@extends('layouts.tenant.settings')
@section('title', 'Fuel Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Edit<span> Fuel Charges</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item">Create</li>
    <li class="breadcrumb-item active">Fuel Charges</li>
@endsection

@section('setting_content')


<div class="row g-3 tc-settings-form-row">

    <div class="col-md-4 ">
        <div class="form-group">
            <strong>Fuel Charges(%) &nbsp;<span class="txt-danger">*</span></strong>
            <input class="form-control" name="" value="Fuel Charges" id="" type="text" placeholder="Fuel Charges" required autofocus>
        </div>
    </div>
    <div class="col-12 tc-settings-form-actions">
        <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
            Update Fuel Charges</button>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

