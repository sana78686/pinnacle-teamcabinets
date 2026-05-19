@extends('layouts.tenant.settings')
@section('title', 'Term-Condition Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Term & Conditionn<span>Details </span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item active">Term & Conditionn</li>
    <li class="breadcrumb-item">Show</li>
@endsection
@section('setting_content')


<div class="container-fluid">
    <div class="row g-3 tc-settings-form-row">

        <!-- Personal Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Term & Condition Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>	Description</th>
                        <td>smtp.office365.com</td>
                    </tr>
                    <tr>
                        <th>Description For Shipping Quote</th>
                        <td>Claims@teamcabinets.com</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- Product Catalog Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">STMP Catalog Information</th>
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

