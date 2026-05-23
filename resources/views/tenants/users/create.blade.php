@extends('layouts.tenant.master')
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
    <h2>Create <span>User </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')



    <div class="m-2 card-body tc-form-page">
        @include('partial.message')
        <form method="POST" action="{{ route('tenant_user_store') }}">
            @csrf
            <!-- Product Catalog Visibility Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Product Catalog Visibility & their Point Factors
                            </h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($door_factor_setup_incomplete ?? false)
                                @include('partials.tenant-door-factor-setup-empty', [
                                    'context' => 'modal',
                                    'missingDefaults' => ! ($has_point_factor_defaults ?? false),
                                    'missingCatalogs' => ! ($has_product_catalogs ?? false),
                                    'missingDoorStyles' => ! ($has_door_styles ?? false),
                                ])
                            @else
                            <div class="container">
                                <div class="row">
                                    <!-- Left column: Checkboxes -->
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
                                                            value="{{ $product_catalog->id }}">
                                                        <label class="form-check-label"
                                                            for="checkbox-primary-{{ $product_catalog->id }}">
                                                            {{ $product_catalog->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right column: Door Colors -->
                                    <div class="col-lg-8">
                                        <h6>Door Point Factors</h6>
                                        <hr>

                                        @foreach ($product_catalogs as $product_catalog)
                                            <div class="door-colors-container" data-catalog-id="{{ $product_catalog->id }}"
                                                style="display: none;">
                                                @foreach ($door_colors->where('productCatalog.id', $product_catalog->id) as $door_color)
                                                    <div class="mb-2 col-lg-12">
                                                        <div class="form-group">
                                                            <strong class="f-w-400">{{ $door_color->product_label }} -
                                                                ({{ $door_color->productCatalog->name }})
                                                            </strong>
                                                            <input type="text"
                                                                name="door_factors[{{ $product_catalog->id }}][{{ $door_color->id }}]"
                                                                placeholder="Door point factor for {{ $door_color->product_label }}"
                                                                class="form-control door-factor-input"
                                                                inputmode="decimal"
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="m-2 row">
                {{-- <a href="#" class="pull-right btn btn-outline-dark btn-md btn-import" data-toggle="tooltip">
                    + Product Catalog - (Door point Factors)
                </a> --}}
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>Product Catalog &amp; door factors:<span class="txt-danger">*</span></strong>

                        <a href="#" class="pull-right btn-import form-control b-r-0" data-toggle="tooltip"
                            title="Open catalog visibility and door point factor settings">
                            + Set door point factors for product catalogs
                        </a>

                        <div id="door-factor-empty" class="mt-2 {{ ($door_factor_setup_incomplete ?? false) ? '' : 'tc-door-factor-prompt' }}">
                            @if ($door_factor_setup_incomplete ?? false)
                                @include('partials.tenant-door-factor-setup-empty', [
                                    'missingDefaults' => ! ($has_point_factor_defaults ?? false),
                                    'missingCatalogs' => ! ($has_product_catalogs ?? false),
                                    'missingDoorStyles' => ! ($has_door_styles ?? false),
                                ])
                            @else
                                <p class="tc-door-factor-setup-note__text mb-0 text-muted small">
                                    No door point factors set yet. Select catalogs and enter a factor for each door style, or
                                    <button type="button" class="btn btn-link btn-sm tc-door-factor-setup-note__action p-0 align-baseline btn-import">
                                        add door point factors
                                    </button>.
                                </p>
                                <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="apply-default-factors">
                                    Apply default for role
                                </button>
                            @endif
                        </div>
                        <div id="door-factor-set" class="tc-door-factor-prompt tc-door-factor-prompt--set mt-2 d-none">
                            <span class="badge bg-success"><span id="door-factor-count">0</span> door factor(s) set</span>
                            <button type="button" class="btn btn-sm btn-link btn-import p-0 ms-2">Edit door factors</button>
                        </div>
                    </div>
                </div>
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
                        <input type="password" name="password" placeholder="Leave blank to auto-generate and email"
                            class="form-control" data-toggle="tooltip"
                            title="Optional. If empty, a secure password is generated and emailed to the user with their login link.">
                        <p class="mb-0 mt-1 text-muted small">If left blank, a password is generated and sent in the welcome email.</p>
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
                        <strong>City &nbsp;</strong>
                        <input type="text" name="city_name" placeholder="Enter Your City Name"
                            class="form-control" data-toggle="tooltip"
                            title="Enter Your City Name">

                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_city"
                            name="city_id" data-toggle="tooltip" title="Select the city of residence" autofocus>
                            <!-- Options -->
                        </select> --}}
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                    <div class="form-group">
                        <strong>County</strong>

                        <input type="text" name="county_name" placeholder="Enter Your County Name"
                            class="form-control" data-toggle="tooltip"
                            title="Enter Your County Name">
                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_county"
                            name="county_id" autofocus>
                        </select> --}}
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
                        <strong>Tax Exemption &nbsp;</strong>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-primary-0" type="checkbox" name="is_taxable_user" id="is_taxable_user">
                            <label class="form-label" for="checkbox-primary-0">Is Exempted?</label>
                        </div>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Address &nbsp;</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea4" rows="2" placeholder="Enter the full address"
                            data-toggle="tooltip" title="Provide the complete residential address" name="address"></textarea>
                    </div>
                </div>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Note &nbsp;</strong>
                        <textarea class="form-control" id="exampleFormControlTextarea4" rows="2" placeholder="Type something about this user."
                            name="note"></textarea>
                    </div>
                </div>

                <hr>
                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>
                            Business Name
                        </strong>
                        <input type="text" name="business_name" placeholder=" Business Name" class="form-control">
                    </div>
                </div>

                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>
                            Gross Sales
                        </strong>
                        <input type="text" name="gross_sale" placeholder=" Gross Sales" class="form-control">
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
                        {{-- <select class="js-example-basic-single col-sm-12 form-control b-r-0" name="role_id"
                             data-toggle="tooltip" title="Select the Status of the user, such as Approved or Block"
                            autofocus>
                            <option value=""></option> --}}
                        </select>
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
            var role_path = "{{ route('tenant_role_autocomplete') }}";
            var country_path = "{{ route('tenant_country_autocomplete') }}";
            var state_path = "{{ route('tenant_state_autocomplete') }}";
            var city_path = "{{ route('tenant_city_autocomplete') }}";
            var county_path = "{{ route('tenant_county_autocomplete') }}";
            var $roleSelect = $('#search_role');
            $roleSelect.select2({
                placeholder: 'Select User Type',
                allowClear: true,
                width: '100%',
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
            $(".btn-import").on("click", function(e) {
                e.preventDefault();
                var el = document.getElementById('importModal');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(el).show();
                } else {
                    $('#importModal').modal('show');
                }
            });
            @if ($door_factor_setup_incomplete ?? false)
            var importModalEl = document.getElementById('importModal');
            if (importModalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(importModalEl).show();
            }
            @endif
        });
    </script>

    <script>
        (function () {
            const pointFactorDefaults = @json($point_factor_defaults ?? []);
            const emptyState = document.getElementById('door-factor-empty');
            const setState = document.getElementById('door-factor-set');
            const countEl = document.getElementById('door-factor-count');
            const applyDefaultBtn = document.getElementById('apply-default-factors');

            function doorFactorInputs() {
                return document.querySelectorAll('.door-factor-input');
            }

            function filledCount() {
                let n = 0;
                doorFactorInputs().forEach(function (input) {
                    if (String(input.value || '').trim() !== '') {
                        n++;
                    }
                });
                return n;
            }

            function updateDoorFactorStatus() {
                const count = filledCount();
                if (!emptyState || !setState) {
                    return;
                }
                if (count > 0) {
                    emptyState.classList.add('d-none');
                    setState.classList.remove('d-none');
                    if (countEl) {
                        countEl.textContent = String(count);
                    }
                } else {
                    emptyState.classList.remove('d-none');
                    setState.classList.add('d-none');
                }
            }

            function roleDefaultKey(roleName) {
                if (!roleName) {
                    return null;
                }
                const base = String(roleName).toLowerCase().trim().replace(/\s+/g, '-');
                if (pointFactorDefaults[base] !== undefined) {
                    return base;
                }
                const plural = base.endsWith('s') ? base : base + 's';
                if (pointFactorDefaults[plural] !== undefined) {
                    return plural;
                }
                const singular = base.replace(/s$/, '');
                if (pointFactorDefaults[singular] !== undefined) {
                    return singular;
                }
                return null;
            }

            function applyDefaultFactors() {
                const $role = $('#search_role');
                const selected = $role.select2('data')[0];
                const key = roleDefaultKey(selected ? selected.text : '');
                if (!key) {
                    return;
                }
                const value = pointFactorDefaults[key];
                doorFactorInputs().forEach(function (input) {
                    if (String(input.value || '').trim() === '') {
                        input.value = value;
                    }
                });
                updateDoorFactorStatus();
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.product-catalog-checkbox').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const catalogId = this.dataset.catalogId;
                        const doorColorsContainer = document.querySelector(
                            '.door-colors-container[data-catalog-id="' + catalogId + '"]'
                        );
                        if (!doorColorsContainer) {
                            return;
                        }
                        if (this.checked) {
                            doorColorsContainer.style.display = 'block';
                        } else {
                            doorColorsContainer.style.display = 'none';
                            doorColorsContainer.querySelectorAll('.door-factor-input').forEach(function (input) {
                                input.value = '';
                            });
                        }
                        updateDoorFactorStatus();
                    });
                });

                doorFactorInputs().forEach(function (input) {
                    input.addEventListener('input', updateDoorFactorStatus);
                });

                $('#search_role').on('select2:select', function (e) {
                    const key = roleDefaultKey(e.params.data.text);
                    if (applyDefaultBtn) {
                        if (key) {
                            applyDefaultBtn.classList.remove('d-none');
                        } else {
                            applyDefaultBtn.classList.add('d-none');
                        }
                    }
                }).on('select2:clear', function () {
                    if (applyDefaultBtn) {
                        applyDefaultBtn.classList.add('d-none');
                    }
                });

                if (applyDefaultBtn) {
                    applyDefaultBtn.addEventListener('click', function () {
                        const checked = document.querySelectorAll('.product-catalog-checkbox:checked');
                        if (checked.length === 0) {
                            var el = document.getElementById('importModal');
                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                bootstrap.Modal.getOrCreateInstance(el).show();
                            }
                            alert('Select at least one product catalog, then apply default door factors.');
                            return;
                        }
                        applyDefaultFactors();
                    });
                }

                updateDoorFactorStatus();
            });
        })();
    </script>
@endsection
