@extends('layouts.tenant.settings')
@section('title', 'Documentation Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Documentation<span> Setting Details</span></h2>
@endsection

@section('breadcrumb-items')

    <li class="breadcrumb-item active">Setting</li>
    <li class="breadcrumb-item">Documentation</li>

@endsection

@section('setting_content')

    <div class="p-2 mt-0 card-header no-border">
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="{{ route('tenant_setting_manage_documentation_list') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Document in the system">
            <i class="icofont icofont-plus"></i> Create Document Setting
        </a>

        <a href="{{ route('tenant_deleted_manage_document_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted Document">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Document Setting
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
                        <th scope="col">Select User Type</th>
                        <th scope="col">Document Name</th>
                        <th scope="col">	Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>
                            Header Section
                        </td>
                        <td>
                            1618864739TEAMSL.zip
                        </td>
                        <td>
                            <a href="{{ route('tenant_setting_manage_documentation_show', 1) }}" data-toggle="tooltip"
                                title="View details of this user">
                                Show |
                            </a>

                            <a class="" href="{{ route('tenant_setting_manage_documentation_edit', 1) }}"
                                data-toggle="tooltip" title="Edit this user's information">
                                Edit |
                            </a>


                            <a href="" type="button" data-toggle="tooltip" title="Delete this user"
                                onclick="confirmation(event,this.href)">

                                Delete
                            </a>


                        </td>


                    </tr>


                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Section Name</th>
                        <th scope="col">Document Name</th>
                        <th scope="col">Actions</th>
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
