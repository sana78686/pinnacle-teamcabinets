@extends('layouts.tenant.master')
@section('title', 'Bulletins Menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Update<span>Bulletins </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Bulletins</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="b-r-0 card">
                    <div class="card-body">
                        <form action="{{ route('tenant_bulletin_update', $bulletin->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                                    <div class="form-group">
                                        <label>Select User Send Option<span class="asterisk"> *</span></label>
                                        <select name="user_option"  id="select_user_send_option"
                                            class="select_user_send_option form-control">
                                            <option value="{{ $bulletin->user_option }}">{{ $bulletin->user_option }}</option>
                                            <option value="every_one">Every One</option>
                                            <option value="specific_user">Specific User</option>
                                        </select>
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Title<span class="asterisk"> *</span></label>
                                        <input value="{{ $bulletin->bulletin_title }}" name="bulletin_title" id="bulletin_title" type="text"
                                            class="form-control">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Description *<span class="asterisk"> *</span></label>
                                        <input value="{{ $bulletin->bulletin_description }}" name="bulletin_description" id="Description *" type="text"
                                            class="form-control">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    @include('layouts.tenant.partials.image-upload-field', [
                                        'name' => 'image',
                                        'id' => 'bulletin_file',
                                        'label' => 'Image or PDF',
                                        'currentPath' => $bulletin->image,
                                        'accept' => 'image/*,application/pdf',
                                        'wrapperClass' => 'form-group',
                                    ])
                                </div>
                                <div class="form-group">
                                    <input name="btn_submit" id="btnSubmit" type="submit" class="btn btn-info"
                                        value="Update Bulletins" style="margin: 15px;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.select.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/custom.js"></script>
@endsection
