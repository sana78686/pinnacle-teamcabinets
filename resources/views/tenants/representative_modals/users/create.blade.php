@extends('layouts.light.master')
@section('title', 'User Menu')

@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (no jQuery required) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
@endsection

@section('style')
    <style>
        /* Hide the <br> tag by default */
        .tablet-break {
            display: none;
        }

        /* Show the <br> tag only on tablet screens (max-width: 768px) */
        @media (max-width: 768px) {
            .tablet-break {
                display: block;
            }
        }
    </style>

@endsection

@section('breadcrumb-title')
    <h2>Create <span>Affliate </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Affliates</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')



    <div class="m-2 card-body">
        @include('partial.flashMessage')
        <form method="POST" action="{{ route('tenant_child_user_store') }}">
            @csrf
            <div class="m-2 row">
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>User Type:<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_role" name="role_id"
                            data-toggle="tooltip" title="Select the role of the user, such as Admin or Customer" autofocus>
                        </select>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>User Name &nbsp;<span class="txt-danger">*</span></strong>
                        <input class="form-control" name="username" id="" type="text"
                            placeholder="Enter a unique username" data-toggle="tooltip"
                            title="Provide a unique username for the user" autofocus>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Full Name &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="text" name="name" placeholder="Enter the full name" class="form-control"
                            data-toggle="tooltip" title="Provide the user's full legal name" autofocus>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cell Phone &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="text" name="phone" placeholder="Enter the cell phone number" class="form-control"
                            data-toggle="tooltip" title="Provide a valid mobile number, e.g., 1234567890" autofocus>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Email &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="email" name="email" placeholder="Enter a valid email address"
                            class="form-control" data-toggle="tooltip"
                            title="Provide a valid email, e.g., user@example.com" autofocus>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Password &nbsp;</strong>
                        <input type="password" name="password" placeholder="Create a strong password"
                            class="form-control" data-toggle="tooltip"
                            title="Enter a secure password with at least 8 characters">
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Country &nbsp;<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_country"
                            name="country_id" data-toggle="tooltip" title="Select the country where the user resides"
                            autofocus>
                            <!-- Options -->
                        </select>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>State &nbsp;<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_state"
                            name="state_id" data-toggle="tooltip" title="Select the state of residence" autofocus>
                            <!-- Options -->
                        </select>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>City &nbsp;<span class="txt-danger">*</span></strong>

                        <input type="text" name="city_name" placeholder="Enter Your City" class="form-control"
                        data-toggle="tooltip" title="Provide User's City" autofocus>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>County</strong>
                        <input type="text" name="county_name" placeholder="Enter Your County" class="form-control"
                        data-toggle="tooltip" title="Provide user's County" autofocus>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Zip &nbsp;</strong>
                        <input type="text" name="zip_code" placeholder="Enter the ZIP code" class="form-control"
                            data-toggle="tooltip" title="Provide the postal code for the user's address" autofocus>
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>
                            Status <span class="txt-danger">*</span>
                        </strong>
                        <select class="form-select status-dropdown" name="status">
                            <option value="approved">Approved
                            </option>
                            <option value="un-approved">
                                Unapproved
                            </option>
                            <option value="block">Block</option>
                        </select>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <strong>Address &nbsp;</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea4" rows="2" placeholder="Enter the full address"
                            data-toggle="tooltip" title="Provide the complete residential address" name="address"></textarea>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <strong>Note &nbsp;</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea4" rows="2" placeholder="Type something about this user."
                            name="note"></textarea>
                    </div>
                </div>

                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"> Create User</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    {{-- <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var role_path = "{{ route('tenant_child_role_autocomplete') }}";
            var country_path = "{{ route('tenant_country_autocomplete') }}";
            var state_path = "{{ route('tenant_state_autocomplete') }}";
            var city_path = "{{ route('tenant_city_autocomplete') }}";
            var county_path = "{{ route('tenant_county_autocomplete') }}";
            $('#search_role').select2({
                placeholder: 'Select User Type',
                allowClear: true,
                ajax: {
                    url: role_path,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Send the search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            // $('#search_country').select2({
            //     placeholder: '--- Select Country ---',
            //     allowClear: true,
            //     ajax: {
            //         url: country_path,
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function(data) {
            //             return {
            //                 results: $.map(data, function(item) {
            //                     return {
            //                         text: item.name,
            //                         id: item.id
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });

            // $('#search_state').select2({
            //     placeholder: '--- Select State ---',
            //     allowClear: true,
            //     ajax: {
            //         url: state_path,
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function(data) {
            //             return {
            //                 results: $.map(data, function(item) {
            //                     return {
            //                         text: item.name,
            //                         id: item.id
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });
            // $('#search_city').select2({
            //     placeholder: '--- Select City ---',
            //     allowClear: true,
            //     ajax: {
            //         url: city_path,
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function(data) {
            //             return {
            //                 results: $.map(data, function(item) {
            //                     return {
            //                         text: item.name,
            //                         id: item.id
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });
            $('#search_country').select2({
                placeholder: '--- Select Country ---',
                allowClear: true,
                ajax: {
                    url: country_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
            }).on('change', function() {
                const countryId = $(this).val();
                $('#search_state').val(null).trigger('change'); // Clear state dropdown
                $('#search_city').val(null).trigger('change'); // Clear city dropdown

                if (countryId) {
                    $('#search_state').select2({
                        placeholder: '--- Select State ---',
                        allowClear: true,
                        ajax: {
                            url: state_path,
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term, // Search query
                                    country_id: countryId, // Pass selected country ID
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.name,
                                            id: item.id,
                                        };
                                    }),
                                };
                            },
                            cache: true,
                        },
                    });
                }
            });

            $('#search_state').on('change', function() {
                const stateId = $(this).val();
                $('#search_city').val(null).trigger('change'); // Clear city dropdown

                if (stateId) {
                    $('#search_city').select2({
                        placeholder: '--- Select City ---',
                        allowClear: true,
                        ajax: {
                            url: city_path,
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term, // Search query
                                    state_id: stateId, // Pass selected state ID
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.name,
                                            id: item.id,
                                        };
                                    }),
                                };
                            },
                            cache: true,
                        },
                    });
                }
            });

            $('#search_county').select2({
                placeholder: '--- Select County ---',
                allowClear: true,
                ajax: {
                    url: county_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const catalogCheckboxes = document.querySelectorAll('.product-catalog-checkbox');
            const doorColorsContainer = document.getElementById('door-colors-container');

            catalogCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const catalogId = this.dataset.catalogId;
                    const doorColorDivs = doorColorsContainer.querySelectorAll(
                        `.catalog-door-colors[data-catalog-id="${catalogId}"]`
                    );

                    if (this.checked) {
                        doorColorDivs.forEach(div => {
                            div.style.display = 'block';
                        });
                    } else {
                        doorColorDivs.forEach(div => {
                            div.style.display = 'none';
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".btn-import").click(function() {
                $('#importModal').modal('show');
            });
        });
    </script>

    <script>
        // Show/Hide door factors for selected catalogs
        document.addEventListener("DOMContentLoaded", function() {
            const catalogCheckboxes = document.querySelectorAll(".product-catalog-checkbox");

            catalogCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    const catalogId = this.dataset.catalogId;
                    const doorColorsContainer = document.querySelector(
                        `.door-colors-container[data-catalog-id='${catalogId}']`);

                    if (this.checked) {
                        doorColorsContainer.style.display = "block";
                    } else {
                        doorColorsContainer.style.display = "none";
                        // Clear input values when hiding
                        doorColorsContainer.querySelectorAll("input").forEach(input => input.value =
                            "");
                    }
                });
            });
        });
    </script>
@endsection
