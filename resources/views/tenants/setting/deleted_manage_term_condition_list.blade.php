@extends('layouts.tenant.settings')
@section('title', 'Term-Condition Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Term & Condition<span>Details </span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Setting</li>
    <li class="breadcrumb-item">Term & Condition</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('setting_content')
<div class="p-2 mt-0 card-header no-border">
    @if (session('success'))
        <div class=" txt-danger" role="alert">
            <h4 class="alert-heading">Note!</h4>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- <h5>Best Selling Product</h5> --}}
    <a href="{{ route('tenant_setting_manage_home_list') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
        title="Create a new home setting in the system">
        <i class="icofont icofont-plus"></i> Create Term & Condition Setting
    </a>

    <a href="" class="btn btn-success btn-sm" data-toggle="tooltip" title="Restore a previously deleted user">
        <i class="icofont icofont-listing-number"></i> Term & Condition Setting List
    </a>
    <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
        <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
    </a>

    <div class=" pull-right">
        <!-- Import & Export Buttons -->
        <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Export user data to a file">
            <i class="text-white icofont icofont-upload-alt"></i> Export
        </button>

        <button class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import user data from a file">
            <i class="text-white icofont icofont-download-alt"></i> Import
        </button>
    </div>
</div>

<div class="pt-0 card-body">
    <div class="table-responsive table-sm">
        <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description </th>
                    <th scope="col">Description For Shipping Quote</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>1</td>
                    <td>
                        smtp.office365.com
                    </td>
                    <td>
                        587
                    </td>


                    <td>
                        <a href="{{ route('tenant_manage_term_condition_restore', 1) }}"
                            data-toggle="tooltip"
                            title="View details of this product" >
                            Restore
                        </a>


                    </td>


                </tr>


            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SMTP Host</th>
                    <th scope="col">SMTP Username</th>
                    <th scope="col">Action</th>

                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@section('setting_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection

