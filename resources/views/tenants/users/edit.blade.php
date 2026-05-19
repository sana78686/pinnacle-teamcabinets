@extends('layouts.tenant.master')
@section('title', 'User Menu')

@section('css')
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
    <h2>Edit <span>User Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
@php
    $doorFactorValue = function ($catalogId, $doorColorId) use ($existing_factors) {
        $group = $existing_factors[$catalogId] ?? collect();
        $row = $group->first(fn ($f) => (string) $f->door_style === (string) $doorColorId);

        return $row->factor ?? '';
    };
@endphp

    <div class="m-2 card-body tc-form-page">
        @include('partial.message')

        <form method="POST" action="{{ route('tenant_user_update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Edit Product Catalog Visibility & Point Factors
                            </h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <!-- Left column: Catalog Checkboxes -->
                                    <div class="col-lg-4">
                                        <h6>Visibility To User</h6>
                                        <hr>
                                        <div class="form-group">
                                            <div class="checkbox-group">
                                                @forelse ($product_catalogs as $product_catalog)
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            name="catalog_visibility[{{ $product_catalog->id }}]"
                                                            id="checkbox-primary-{{ $product_catalog->id }}"
                                                            class="form-check-input product-catalog-checkbox"
                                                            data-catalog-id="{{ $product_catalog->id }}"
                                                            value="{{ $product_catalog->id }}"
                                                            {{ isset($selected_catalogs) && in_array($product_catalog->id, $selected_catalogs) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="checkbox-primary-{{ $product_catalog->id }}">
                                                            {{ $product_catalog->name }}
                                                        </label>
                                                    </div>
                                                @empty
                                                    <!-- Empty state: Still allow user to add catalogs later -->
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Right column: Door Colors & Factors -->
                                    <div class="col-lg-8">
                                        <h6>Door Point Factors</h6>
                                        <hr>
                                        @forelse ($product_catalogs as $product_catalog)
                                            <div class="door-colors-container" data-catalog-id="{{ $product_catalog->id }}"
                                                style="{{ isset($selected_catalogs) && in_array($product_catalog->id, $selected_catalogs) ? 'display:block;' : 'display:none;' }}">

                                                @forelse ($door_colors->where('productCatalog.id', $product_catalog->id) as $door_color)
                                                    <div class="mb-2 col-lg-12">
                                                        <div class="form-group">
                                                            <strong class="f-w-400">
                                                                {{ $door_color->product_label }} - ({{ $door_color->productCatalog->name }})
                                                            </strong>
                                                            <input type="text"
                                                                name="door_factors[{{ $product_catalog->id }}][{{ $door_color->id }}]"
                                                                placeholder="Door Point Factor for {{ $door_color->product_label }}"
                                                                class="form-control"
                                                                value="{{ $doorFactorValue($product_catalog->id, $door_color->id) }}">
                                                        </div>
                                                    </div>
                                                @empty
                                                    <!-- Empty state: No door colors available, but user can set later -->
                                                @endforelse

                                            </div>
                                        @empty
                                            <!-- Empty state: No catalogs yet, so no door factors will be displayed -->
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <!-- Left column: Catalog Checkboxes -->
                                    <div class="col-lg-4">
                                        <h6>Visibility To User</h6>
                                        <hr>
                                        <div class="form-group">
                                            <div class="checkbox-group">
                                                @foreach ($product_catalogs as $product_catalog)
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                            name="catalog_visibility[{{ $product_catalog->id }}]"
                                                            id="checkbox-primary-{{ $product_catalog->id }}"
                                                            class="form-check-input product-catalog-checkbox"
                                                            data-catalog-id="{{ $product_catalog->id }}"
                                                            value="{{ $product_catalog->id }}"
                                                            {{ in_array($product_catalog->id, $selected_catalogs) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="checkbox-primary-{{ $product_catalog->id }}">
                                                            {{ $product_catalog->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right column: Door Colors & Factors -->
                                    <div class="col-lg-8">
                                        <h6>Door Point Factors</h6>
                                        <hr>

                                        @foreach ($product_catalogs as $product_catalog)
                                            <div class="door-colors-container" data-catalog-id="{{ $product_catalog->id }}"
                                                style="{{ in_array($product_catalog->id, $selected_catalogs) ? 'display:block;' : 'display:none;' }}">

                                                @foreach ($door_colors->where('productCatalog.id', $product_catalog->id) as $door_color)
                                                    <div class="mb-2 col-lg-12">
                                                        <div class="form-group">
                                                            <strong class="f-w-400">
                                                                {{ $door_color->product_label }} -
                                                                ({{ $door_color->productCatalog->name }})
                                                            </strong>
                                                            <input type="text"
                                                                name="door_factors[{{ $product_catalog->id }}][{{ $door_color->id }}]"
                                                                placeholder="Door Point Factor for {{ $door_color->product_label }}"
                                                                class="form-control"
                                                                value="{{ $existing_factors[$product_catalog->id]->where('door_style', $door_color->id)->first()->factor ?? '' }}">
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="m-2 row">
                {{-- <a href="#" class="pull-right btn btn-outline-dark btn-md btn-import" data-toggle="tooltip">
                    + Product Catalog - (Door point Factors)
                </a> --}}
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>Product Catalog:<span class="txt-danger">*</span></strong>
                        <a href="#" class="pull-right btn-import form-control b-r-0" data-toggle="tooltip"
                            data-toggle="tooltip" title="Click Me: To Set Point Factors" autofocus>
                            + Set Door Point Factors For Product Catalogs
                        </a>
                    </div>
                </div>
                <!-- User Role -->
                {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>User Type:<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_role" name="role_id"
                            required data-toggle="tooltip" title="Select the role of the user">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <!-- User Role -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>User Type:<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_role" name="role_id"
                            required data-toggle="tooltip" title="Select the role of the user">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $user_role_id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Username -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>User Name &nbsp;<span class="txt-danger">*</span></strong>
                        <input class="form-control" name="username" type="text" value="{{ $user->username }}"
                            placeholder="Enter a unique username" required>
                    </div>
                </div>

                <!-- Full Name -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Full Name &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="text" name="name" value="{{ $user->name }}" placeholder="Enter the full name"
                            class="form-control" required>
                    </div>
                </div>

                <!-- Phone -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cell Phone &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="text" name="phone" value="{{ $user->phone }}"
                            placeholder="Enter the cell phone number" class="form-control" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Email &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="email" name="email" value="{{ $user->email }}"
                            placeholder="Enter a valid email address" class="form-control" required>
                    </div>
                </div>

                <!-- Password (optional) -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Password &nbsp;</strong>
                        <input type="password" name="password" placeholder="Update password if required"
                            class="form-control">
                    </div>
                </div>

                <!-- Country -->
                {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Country &nbsp;<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_country"
                            name="country_id" required>
                            @if ($user->country_id)
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div> --}}

                <!-- Country -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Country &nbsp;<span class="txt-danger">*</span></strong>
                        <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_country"
                            name="country_id" required>
                            @if ($user->country_id)
                                @foreach ($countries as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('country_id', $user->country_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <!-- State -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>State &nbsp;<span class="txt-danger">*</span></strong>

                        <select class="js-example-basic-single col-sm-12 form-control b-r-0"
                                id="search_state"
                                name="state_id" required>
                                @if ($user->state_id)
                                <option value="{{ $user->state_id }}" selected>
                                    {{ $user->state->name }}
                                </option>
                            @endif
                        </select>
                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0"
                                id="search_state_demo"
                                name="state_id" required>
                            @if ($user->state_id)
                                <option value="{{ $user->state_id }}" selected>
                                    {{ $user->state->name }}
                                </option>
                            @endif
                        </select> --}}
                    </div>
                </div>

                <!-- City -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>City</strong>

                        <input type="text" name="city_name" placeholder="Enter Your City Name"
                            class="form-control" data-toggle="tooltip" value="{{ $user->city_name }}"
                            title="Enter Your City Name">
                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0"
                                id="search_city"
                                name="city_id" required>
                            @if ($user->city_id)
                                <option value="{{ $user->city_id }}" selected>
                                    {{ $user->city->name }}
                                </option>
                            @endif
                        </select> --}}
                    </div>
                </div>

                <!-- Select2 CSS and JS -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $('#search_city').select2({
                            placeholder: "Search for a city...",
                            ajax: {
                                url: '{{ route('tenant_city_autocomplete') }}',  // AJAX route
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        query: params.term // Search query
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: data.map(city => ({
                                            id: city.id,
                                            text: city.name
                                        }))
                                    };
                                }
                            }
                        });
                    });
                </script>



                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>County</strong>

                        <input type="text" name="county_name" placeholder="Enter Your County Name"
                            class="form-control" data-toggle="tooltip" value="{{ $user->county_name }}"
                            title="Enter Your County Name">
                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_county"
                            name="county_id" autofocus>
                        </select> --}}
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Zip &nbsp;<span class="txt-danger">*</span></strong>
                        <input type="text" name="zip_code" placeholder="Enter the ZIP code" class="form-control"
                            data-toggle="tooltip" title="Provide the postal code for the user's address" autofocus
                            value="{{ $user->zip_code }}">
                    </div>
                </div>

                <!-- Tax Exemption -->
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Tax Exemption &nbsp;</strong>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-primary-0" type="checkbox" name="is_taxable_user"
                                {{ $user->is_taxable_user ? 'checked' : '' }}>
                            <label class="form-label" for="checkbox-primary-0">Is Exempted?</label>
                        </div>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Address &nbsp;</strong>
                        <input class="form-control" id="exampleFormControlTextarea4" rows="2" placeholder="Enter the full address"
                            data-toggle="tooltip" title="Provide the complete residential address" name="address"
                            value="{{ $user->address}}"
                            ></input>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Note &nbsp;</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea4" rows="2"
                            placeholder="Type something about this user." name="note">{{ old('note', $user->note) }}</textarea>
                    </div>
                </div>

                <hr>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>
                            Business Name
                        </strong>
                        <input type="text" name="business_name" placeholder="Business Name" class="form-control"
                            value="{{ old('business_name', $user->company_name) }}">
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>
                            Gross Sales
                        </strong>
                        <input type="text" name="gross_sale" placeholder="Gross Sales" class="form-control"
                            value="{{ old('gross_sale', $user->gross_sale) }}">
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">

                        <strong>
                            Status <span class="txt-danger">*</span>
                        </strong>
                        <select class="form-control b-r-0 status-dropdown" name="status" required>
                            <option value="approved" {{ $user->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="un-approved" {{ $user->status === 'un-approved' ? 'selected' : '' }}>Unapproved</option>
                            <option value="block" {{ $user->status === 'block' ? 'selected' : '' }}>Block</option>
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="deactive" {{ $user->status === 'deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>
                </div>
                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"> Update User</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var role_path = "{{ route('tenant_role_autocomplete') }}";
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
        $(document).ready(function() {
            $(".btn-import").on("click", function(e) {
                e.preventDefault();
                var el = document.getElementById('importModal');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(el).show();
                } else {
                    $('#importModal').modal('show');
                }
            });
        });
    </script>

    <!-- JavaScript to Toggle Door Colors Based on Selected Catalogs -->
    <script>
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
