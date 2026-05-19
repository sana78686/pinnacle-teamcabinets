@extends('layouts.tenant.settings')
@section('title', 'Home Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Home Setting<span>Details</span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">setting</li>
    <li class="breadcrumb-item">Home</li>
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
                        <th colspan="2">Product Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Section Name</th>
                        <td>Header Section</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- Product Catalog Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Product Catalog Information</th>
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
