@extends('layouts.tenant.settings')
@section('title', 'Credit Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Credit/Debit/Ach Charges<span>Details</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"> Setting</li>
    <li class="breadcrumb-item">Credit </li>
    <li class="breadcrumb-item active">Show</li>
@endsection

@section('setting_content')


<div class="container-fluid">
    <div class="row g-3 tc-settings-form-row">

        <!-- Personal Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Credit Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Credit Card Charges</th>
                        <td>Header Section</td>
                    </tr>
                    <tr>
                        <th>ACH Charges</th>
                        <td>1618864739TEAMSL.zip</td>
                    </tr>
                    <tr>
                        <th>Debit Card Charges</th>
                        <td>1618864739TEAMSL.zip</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Product Catalog Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Credit Catalog Information</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

