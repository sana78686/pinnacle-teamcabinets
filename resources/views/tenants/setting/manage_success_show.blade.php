@extends('layouts.tenant.settings')
@section('title', 'Success Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Success/Error Content<span>Details </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Setting</li>
    <li class="breadcrumb-item active">Success Error Content</li>
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
                        <th colspan="2">Success Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Pages</th>
                        <td>Thank You Page</td>
                    </tr>

                </tbody>
            </table>
        </div>
        <!-- Product Catalog Information -->
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Success Catalog Information</th>
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

