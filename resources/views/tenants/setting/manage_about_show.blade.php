@extends('layouts.tenant.settings')
@section('title', 'About-us Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>About Us<span> Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">About</li>
    <li class="breadcrumb-item active">Us</li>
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
                        <th colspan="2">About Us Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>Contact Us</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>Team Cabinets</td>
                    </tr>
                    <tr>
                        <th>Meta Title</th>
                        <td>cabinetry</td>
                    </tr>

                    <tr>
                        <th>Meta Keyword</th>
                        <td>Team Cabinets</td>
                    </tr>

                    <tr>
                        <th>Meta Description</th>
                        <td>President</td>
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

