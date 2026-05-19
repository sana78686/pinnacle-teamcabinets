@extends('layouts.light.master')
@section('title', 'Order')

@section('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/owlcarousel.css">
@endsection

@section('style')
    <style>
        [id^=product_label_] {
            cursor: pointer;
            /* Makes the mouse pointer a hand */
        }
    </style>

@endsection

@section('breadcrumb-title')
    <h2>Create an<span>Order </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card b-r-0">
                    <div class="card-body">
                        <div class="stepwizard">
                            <div class="stepwizard-row setup-panel">
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="{{ route('tenant_order_create') }}">1</a>
                                    <p>Select Catalog</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#">2</a>
                                    <p>Select Door Style</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-primary" href="#">3</a>
                                    <p>Cart Products</p>
                                </div>
                                {{-- <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#step-4">4</a>
                                    <p>Step 4</p>
                                </div> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12" style="max-height: 600px; overflow-y: auto;">
                                <input type="search" id="search_sku" placeholder="Enter SKU Number." name="search"
                                    class="sku_no form-control" aria-label="Search">

                                <br>
                                <strong>
                                    <b>NOTE: Do empty search to reset.</b>
                                </strong>
                                <strong>
                                    <b>NOTE: Double click on Cabinet Label to select product.</b>
                                </strong>
                                <hr>
                                <div class="default-according " id="accordionclose">
                                    @forelse ($product_sections as $section)
                                        <div class="card b-r-0">
                                            <div class="card-header" id="heading{{ $section->id }}">
                                                <h6 class="mb-0">
                                                    <button class="btn btn-link" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $section->id }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $section->id }}">
                                                        {{ $section->cabinets_name }}
                                                    </button>
                                                </h6>
                                            </div>
                                            <div id="collapse{{ $section->id }}" class="collapse"
                                                aria-labelledby="heading{{ $section->id }}"
                                                data-bs-parent="#accordionclose">
                                                <div class="p-1 card-body">
                                                    <div class="table-responsive table-xs"
                                                        style="max-height: 250px; overflow-y: auto;">
                                                        <table
                                                            class="table p-0 m-0 display table-striped table-bordered table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Cabinet Label</th>
                                                                    <th scope="col">SKU</th>
                                                                    <th scope="col">Description</th>
                                                                    <th scope="col">Weight</th>
                                                                    <th scope="col">Cost</th>
                                                                    <th scope="col">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @php
                                                                    $product_data = $section->products
                                                                        ->where('product_catalog_id', $catalog_id)
                                                                        ->where('door_color_id', '=', $door_id);
                                                                @endphp
                                                                @foreach ($product_data as $product)
                                                                    <tr>
                                                                        <td id="product_label_{{ $product->id }}">
                                                                            {{ $product->label }}</td>
                                                                        <td>{{ $product->sku }}</td>
                                                                        <td>{{ $product->sku . '-' . $product->doorColor->product_label }}
                                                                        </td>
                                                                        <td>{{ $product->weight }}</td>
                                                                        <td>{{ $product->cost }}</td>
                                                                        <td>{{ $product->qty }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th scope="col">Cabinet Label</th>
                                                                    <th scope="col">SKU</th>
                                                                    <th scope="col">Description</th>
                                                                    <th scope="col">Weight</th>
                                                                    <th scope="col">Cost</th>
                                                                    <th scope="col">Qty</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        There is nothing to show.
                                    @endforelse
                                </div>

                            </div>

                            <div class="border col-xl-7 col-lg-7 col-md-12 col-sm-12">

                                <strong class="mt-2">
                                    <b>Step #1: Please enter Job Name and Room before selecting items from
                                        inventory.</b>
                                </strong>
                                <div class="box box-primary" style="overflow-x: auto;">
                                    <div class="form-inline ">
                                        <span class="m-2">
                                            <b>
                                                Job Name <span class="astirisk font-danger">*</span>
                                            </b>
                                        </span>
                                        <input id="job_name" type="text" name="job_name" class="form-control"
                                            value="{{ $jobName }}" placeholder="Enter Job Name." required autofocus>
                                        <button type="button" class="m-2 text-white btn btn-info" id="add_room_btn">+ ADD
                                            ROOM</button>
                                        <span class="" style="float:right;">
                                            <a href="#" id="clear_cart" class="m-2 btn btn-light">
                                                Clear Cart
                                            </a>
                                        </span>
                                    </div>
                                    <div class="">
                                        <strong class="m-2">Assemble All Cabinetry?<span
                                                class="asterisk font-danger">&nbsp;*</span></strong>
                                        <input type="radio" id="ass_required" name="assemble_cabinets_check"
                                            value="1" required autofocus>
                                        <label for="html">Yes</label>

                                        <input type="radio" id="" class="space_right"
                                            name="assemble_cabinets_check" value="2">
                                        <label for="css">No</label><span class="err_assemble_check"
                                            style="font-weight:525;"></span><br>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered " id="">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Double Check Work</th>
                                                    <!--  <th></th> -->
                                                    <th>Cabinet Name</th>
                                                    <th>Cabinet Description</th>
                                                    <!-- <th>Cabinet Color</th> -->
                                                    <th>Weight</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Quantity</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>

                                            <tbody id="room_table_body">
                                                @foreach ($roomNames as $room)
                                                    <tr class="show_room table-warning">
                                                        <td><label>Room<span class="astirisk font-danger">*</span></label>
                                                        </td>
                                                        <td colspan="5">
                                                            <input type="text" name="roomlabel[]"
                                                                class="form-control room_input"
                                                                value="{{ $room }}" readonly>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-danger remove_room">x</button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @foreach ($cart as $productId => $product)
                                                    <tr data-id="{{ $productId }}">
                                                        <td>
                                                            <input type="checkbox" class="single_check"> <br>
                                                            <input type="checkbox" class="double_check">
                                                        </td>
                                                        <td>{{ $product['room_name'] }}</td>
                                                        <td>Product ID: {{ $productId }}</td>
                                                        <td class="product_weight">0 lbs</td>
                                                        <td>${{ number_format($product['price'], 2) }}</td>
                                                        <td class="product_total_price">
                                                            ${{ number_format($product['quantity'] * $product['price'], 2) }}
                                                        </td>
                                                        <td class="product_quantity">{{ $product['quantity'] }}</td>
                                                        <td>
                                                            <button
                                                                class="btn btn-outline-danger remove_product">x</button>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <!-- <th></th> -->
                                                    <th class="custom_all_product_weights">0 lbs</th>
                                                    <th></th>
                                                    <th class="custom_all_product_total">$0.00</th>
                                                    <th></th>
                                                    <!-- <th></th> -->
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="form-inline">
                                        <label><b>Comment</b></label>
                                        <textarea style="margin-left:1%; width:80%" rows="4" name="order_comment" class="mt-2 form-control"
                                            maxlength="200"></textarea>
                                    </div>
                                </div>
                                <div class="clearfix m-2 box-footer pull-left">
                                    <button class="btn btn-light" id="print_btn" onclick="checkvalidation_process(event)"
                                        name="print_btn">Print</button>
                                    <button class="btn btn-light" id="save_quote_btn"
                                        onclick="checkvalidation(event,'quote')" name="save_quote_btn">Save
                                        Quote</button>
                                    <button class="btn btn-light" id="save_shipping_quote_btn"
                                        onclick="checkvalidation(event,'shipping')" name="save_shipping_quote_btn">Request
                                        Shipping Quote</button>

                                    <button class="btn btn-light" id="stock_check_btn" name="stock_check_btn"
                                        style="display:none">Update Stock Check</button>
                                    <button class="btn btn-light" id="stock_check_btn"name="stock_check_btn">Stock
                                        Check</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-two.js"></script>
    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl.carousel.js"></script>
    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl-custom.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script>
        $(document).ready(function()
        {
            let lastRoomRow = null;

            function updateTotals() {
                let totalPrice = 0;
                let totalWeight = 0;

                $(".product_total_price").each(function() {
                    totalPrice += parseFloat($(this).text().replace("$", "")) || 0;
                });

                $(".product_weight").each(function() {
                    totalWeight += parseFloat($(this).text().replace(" lbs", "")) || 0;
                });

                $(".custom_all_product_total").text(`$${totalPrice.toFixed(2)}`);
                $(".custom_all_product_weights").text(`${totalWeight.toFixed(2)} lbs`);
            }

            $("#add_room_btn").click(function() {
                let jobName = $("#job_name").val().trim();
                if (jobName === "") {
                    alert("Please enter a Job Name before adding a room.");
                    return;
                }

                let roomRow = `
                    <tr class="show_room table-warning">
                        <td>
                            <label>Room<span class="astirisk font-danger">*</span></label>
                        </td>
                        <td colspan="5">
                            <input required type="text" name="roomlabel[]" placeholder="Enter Room Name." class="form-control room_input">
                        </td>
                        <td>
                            <button class="btn btn-outline-danger remove_room">x</button>
                        </td>
                    </tr>
                `;

                $("#room_table_body").append(roomRow);
                lastRoomRow = $("#room_table_body tr.show_room").last();
            });

            $(document).on("click", ".remove_room", function() {
                $(this).closest("tr").nextUntil(".show_room").remove();
                $(this).closest("tr").remove();
                updateTotals();
            });

            $(document).on("dblclick", "[id^=product_label_]", function() {
                if (!lastRoomRow) {
                    alert("Please add a room before selecting a product.");
                    return;
                }

                let productRow = $(this).closest("tr");
                let productLabel = productRow.find("td:nth-child(1)").text().trim();
                let productSku = productRow.find("td:nth-child(2)").text().trim();
                let productDescription = productRow.find("td:nth-child(3)").text().trim();
                let productWeight = parseFloat(productRow.find("td:nth-child(4)").text().trim()) || 0;
                let productPrice = parseFloat(productRow.find("td:nth-child(5)").text().trim().replace("$",
                    "")) || 0;

                let existingProduct = $(`#room_table_body tr[data-sku="${productSku}"]`);
                if (existingProduct.length > 0) {
                    let qtyField = existingProduct.find(".product_quantity");
                    let newQty = parseInt(qtyField.text()) + 1;
                    qtyField.text(newQty);

                    let totalPriceField = existingProduct.find(".product_total_price");
                    totalPriceField.text(`$${(newQty * productPrice).toFixed(2)}`);

                    let totalWeightField = existingProduct.find(".product_weight");
                    totalWeightField.text(`${(newQty * productWeight).toFixed(2)} lbs`);
                } else {
                    let productData = `
                        <tr data-sku="${productSku}">
                            <td>
                                <input type="checkbox" class="single_check">  <br>
                                <input type="checkbox" class="double_check">
                            </td>
                            <td>${productLabel}</td>
                            <td>${productDescription}</td>
                            <td class="product_weight">${productWeight.toFixed(2)} lbs</td>
                            <td>$${productPrice.toFixed(2)}</td>
                            <td class="product_total_price">$${productPrice.toFixed(2)}</td>
                            <td class="product_quantity">1</td>
                            <td>
                                <button class="btn btn-outline-danger remove_product">x</button>
                            </td>
                        </tr>
                    `;

                    lastRoomRow.after(productData);
                }

                updateTotals();
            });

            $(document).on("click", ".remove_product", function() {
                $(this).closest("tr").remove();
                updateTotals();
            });

            // Ensure only one checkbox is checked at a time
            $(document).on("change", ".single_check", function() {
                if ($(this).is(":checked")) {
                    $(this).closest("tr").find(".double_check").prop("checked", false);
                }
            });

            $(document).on("change", ".double_check", function() {
                if ($(this).is(":checked")) {
                    $(this).closest("tr").find(".single_check").prop("checked", false);
                }
            });

        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $("#search_sku").on("keyup", function() {
                var value = $(this).val().trim();
                $.ajax({
                    url: "{{ route('tenant_order_create_search') }}",
                    type: "GET",
                    data: {
                        'search': value
                    },
                    success: function(data) {
                        var products = data.products;
                        var html = '';
                        if (products.length > 0) {
                            for (let i = 0; i < products.length; i++) {
                                html += '<tr>\
                                                                            <td>' + products[i].label + '</td>\
                                                                            <td>' + products[i].sku + '</td>\
                                                                            <td>' + products[i].weight + '</td>\
                                                                            <td>' + products[i].detail + '</td>\
                                                                            <td>' + products[i].cost + '</td>\
                                                                            <td>' + products[i].qty + '</td>\
                                                                            </tr>';
                            }
                        } else {
                            html = '<tr><td>No Data Found</td></tr>';
                        }

                        $("#product_search_results").html(html);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let lastRoomRow = null;

            function updateTotals() {
                let totalPrice = 0;
                let totalWeight = 0;

                $(".product_total_price").each(function() {
                    totalPrice += parseFloat($(this).text().replace("$", "")) || 0;
                });

                $(".product_weight").each(function() {
                    totalWeight += parseFloat($(this).text().replace(" lbs", "")) || 0;
                });

                $(".custom_all_product_total").text(`$${totalPrice.toFixed(2)}`);
                $(".custom_all_product_weights").text(`${totalWeight.toFixed(2)} lbs`);
            }


            function loadCart() {
                $.get("{{ route('cart.getCart') }}", function(cart) {
                    if (Object.keys(cart).length > 0) {
                        $.each(cart, function(productId, product) {
                            let productData = `
                        <tr data-id="${productId}">
                            <td>
                                <input type="checkbox" class="single_check">  <br>
                                <input type="checkbox" class="double_check">
                            </td>
                            <td>${product.room_name}</td>
                            <td>Product ID: ${productId}</td>
                            <td class="product_weight">0 lbs</td>
                            <td>$${product.price.toFixed(2)}</td>
                            <td class="product_total_price">$${(product.quantity * product.price).toFixed(2)}</td>
                            <td class="product_quantity">${product.quantity}</td>
                            <td>
                                <button class="btn btn-outline-danger remove_product">x</button>
                            </td>
                        </tr>
                    `;
                            $("#room_table_body").append(productData);
                        });
                        updateTotals();
                    }
                });
            }

            loadCart();

            $("#add_room_btn").click(function() {
                let jobName = $("#job_name").val().trim();
                if (jobName === "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Job Name",
                        text: "Please enter a Job Name before adding a room.",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#d33"
                    });
                    return;
                }

                $.post("{{ route('cart.saveJobName') }}", {
                    _token: "{{ csrf_token() }}",
                    job_name: jobName
                });
                let roomRow = `
                    <tr class="show_room table-warning">
                        <td><label>Room<span class="astirisk font-danger">*</span></label></td>
                        <td colspan="5">
                            <input required type="text" name="roomlabel[]" placeholder="Enter Room Name." class="form-control room_input">
                        </td>
                        <td>
                            <button class="btn btn-outline-danger remove_room">x</button>
                        </td>
                    </tr>
                `;

                $("#room_table_body").append(roomRow);
                lastRoomRow = $("#room_table_body tr.show_room").last();

                let roomName = lastRoomRow.find(".room_input").val();
                $.post("{{ route('cart.addRoom') }}", {
                    _token: "{{ csrf_token() }}",
                    job_name: jobName,
                    room_name: roomName
                });
            });

            $(document).on("click", ".remove_room", function() {
                let roomRow = $(this).closest("tr");
                let roomName = roomRow.find(".room_input").val();

                $.post("{{ route('cart.removeRoom') }}", {
                    _token: "{{ csrf_token() }}",
                    room_name: roomName
                });

                roomRow.nextUntil(".show_room").remove();
                roomRow.remove();
                updateTotals();
            });

            $(document).on("dblclick", "[id^=product_label_]", function() {
                if (!lastRoomRow) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Room",
                        text: "Please add a room before selecting a product.",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#d33"
                    });
                    return;
                }

                let productRow = $(this).closest("tr");
                let productId = $(this).attr("id").replace("product_label_", "").trim();
                let productLabel = productRow.find("td:nth-child(1)").text().trim();
                let productSku = productRow.find("td:nth-child(2)").text().trim();
                let productDescription = productRow.find("td:nth-child(3)").text().trim();
                let productWeight = parseFloat(productRow.find("td:nth-child(4)").text().trim()) || 0;
                let productPrice = parseFloat(productRow.find("td:nth-child(5)").text().trim().replace("$",
                    "")) || 0;

                let existingProduct = $(`#room_table_body tr[data-id="${productId}"]`);
                if (existingProduct.length > 0) {
                    let qtyField = existingProduct.find(".product_quantity");
                    let newQty = parseInt(qtyField.text()) + 1;
                    qtyField.text(newQty);

                    let totalPriceField = existingProduct.find(".product_total_price");
                    totalPriceField.text(`$${(newQty * productPrice).toFixed(2)}`);
                } else {
                    let productData = `
                <tr data-id="${productId}">
                    <td>
                        <input type="checkbox" class="single_check">  <br>
                        <input type="checkbox" class="double_check">
                    </td>
                    <td>${productLabel}</td>
                    <td>${productDescription}</td>
                    <td class="product_weight">${productWeight.toFixed(2)} lbs</td>
                    <td>$${productPrice.toFixed(2)}</td>
                    <td class="product_total_price">$${productPrice.toFixed(2)}</td>
                    <td class="product_quantity">1</td>
                    <td>
                        <button class="btn btn-outline-danger remove_product">x</button>
                    </td>
                </tr>
            `;

                    lastRoomRow.after(productData);
                }

                $.post("{{ route('cart.addProduct') }}", {
                    _token: "{{ csrf_token() }}",
                    room_name: lastRoomRow.find(".room_input").val(),
                    product_id: productId,
                    quantity: 1,
                    price: productPrice
                });

                updateTotals();
            });

            $(document).on("click", ".remove_product", function() {
                let productRow = $(this).closest("tr");
                let productId = productRow.data("id");

                $.post("{{ route('cart.removeProduct') }}", {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                });

                productRow.remove();
                updateTotals();
            });

            $(document).on("click", "#clear_cart", function() {
                $.post("{{ route('cart.clearCart') }}", {
                    _token: "{{ csrf_token() }}"
                }, function() {
                    Swal.fire({
                        icon: "warning",
                        title: "Are you sure?",
                        text: "You want to clear your Cart.",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                    }).then(() => {
                        location.reload();
                    });
                });
            });

            $(document).on("click", "#stock_check_btn", function(event) {
                let errors = [];

                let jobName = $("#job_name").val().trim();
                if (jobName === "") errors.push("Please enter a Job Name.");

                let roomExists = $(".room_input").length > 0;
                if (!roomExists) errors.push("Please add at least one room.");

                let productExists = $("#room_table_body tr[data-id]").length > 0;
                if (!productExists) errors.push("Please add at least one product.");

                let assembleRequired = $("input[name='assemble_cabinets_check']:checked").val();
                if (!assembleRequired) errors.push(
                    "Please select 'Yes' or 'No' for 'Assemble All Cabinetry'.");

                if (errors.length > 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Incomplete Steps",
                        html: errors.join("<br>"),
                        confirmButtonText: "OK",
                        confirmButtonColor: "#d33"
                    });
                    event.preventDefault();
                    return;
                }

                Swal.fire({
                    icon: "success",
                    title: "Stock Check Processing",
                    text: "Stock check is now processing...",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3085d6"
                });
            });
        });

        // with sweet alerts
        // $(document).ready(function() {
        //     let lastRoomRow = null;

        //     function updateTotals() {
        //         let totalPrice = 0;
        //         let totalWeight = 0;

        //         $(".product_total_price").each(function() {
        //             totalPrice += parseFloat($(this).text().replace("$", "")) || 0;
        //         });

        //         $(".product_weight").each(function() {
        //             totalWeight += parseFloat($(this).text().replace(" lbs", "")) || 0;
        //         });

        //         $(".custom_all_product_total").text(`$${totalPrice.toFixed(2)}`);
        //         $(".custom_all_product_weights").text(`${totalWeight.toFixed(2)} lbs`);
        //     }

        //     $("#add_room_btn").click(function() {
        //         let jobName = $("#job_name").val().trim();
        //         if (jobName === "") {
        //             Swal.fire({
        //                 icon: "warning",
        //                 title: "Missing Job Name",
        //                 text: "Please enter a Job Name before adding a room.",
        //                 confirmButtonText: "OK",
        //                 confirmButtonColor: "#d33"
        //             });
        //             return;
        //         }

        //         let roomRow = `
    //         <tr class="show_room table-warning">
    //             <td><label>Room<span class="astirisk font-danger">*</span></label></td>
    //             <td colspan="5">
    //                 <input required type="text" name="roomlabel[]" placeholder="Enter Room Name." class="form-control room_input">
    //             </td>
    //             <td>
    //                 <button class="btn btn-outline-danger remove_room">x</button>
    //             </td>
    //         </tr>
    //         `;

        //         $("#room_table_body").append(roomRow);
        //         lastRoomRow = $("#room_table_body tr.show_room").last();

        //         let roomName = lastRoomRow.find(".room_input").val();
        //         $.post("{{ route('cart.addRoom') }}", {
        //             _token: "{{ csrf_token() }}",
        //             job_name: jobName,
        //             room_name: roomName
        //         });
        //     });

        //     $(document).on("click", ".remove_room", function() {
        //         let roomRow = $(this).closest("tr");
        //         let roomName = roomRow.find(".room_input").val();

        //         $.post("{{ route('cart.removeRoom') }}", {
        //             _token: "{{ csrf_token() }}",
        //             room_name: roomName
        //         });

        //         roomRow.nextUntil(".show_room").remove();
        //         roomRow.remove();
        //         updateTotals();
        //     });

        //     function loadCart() {
        //         $.get("{{ route('cart.getCart') }}", function(cart) {
        //             $.each(cart, function(productId, product) {
        //                 let productData = `
    //             <tr data-id="${productId}">
    //                 <td>
    //                     <input type="checkbox" class="single_check">  <br>
    //                     <input type="checkbox" class="double_check">
    //                 </td>
    //                 <td>${product.room_name}</td>
    //                 <td>Product ID: ${productId}</td>
    //                 <td class="product_weight">0 lbs</td>
    //                 <td>$${product.price.toFixed(2)}</td>
    //                 <td class="product_total_price">$${(product.quantity * product.price).toFixed(2)}</td>
    //                 <td class="product_quantity">${product.quantity}</td>
    //                 <td>
    //                     <button class="btn btn-outline-danger remove_product">x</button>
    //                 </td>
    //             </tr>
    //         `;
        //                 $("#room_table_body").append(productData);
        //             });
        //             updateTotals();
        //         });
        //     }

        //     loadCart();
        //     $(document).on("dblclick", "[id^=product_label_]", function() {
        //         if (!lastRoomRow) {
        //             Swal.fire({
        //                 icon: "warning",
        //                 title: "Missing Room",
        //                 text: "Please Enter Job and Room Name before selecting a product.",
        //                 confirmButtonText: "OK",
        //                 confirmButtonColor: "#d33"
        //             });
        //             return;
        //         }

        //         let productRow = $(this).closest("tr");
        //         let productId = $(this).attr("id").replace("product_label_", "").trim();
        //         let productLabel = productRow.find("td:nth-child(1)").text().trim();
        //         let productSku = productRow.find("td:nth-child(2)").text().trim();
        //         let productDescription = productRow.find("td:nth-child(3)").text().trim();
        //         let productWeight = parseFloat(productRow.find("td:nth-child(4)").text().trim()) || 0;
        //         let productPrice = parseFloat(productRow.find("td:nth-child(5)").text().trim().replace("$",
        //             "")) || 0;

        //         $(this).closest("tr").css("background-color", "#d4edda").delay(300).queue(function(next) {
        //             $(this).css("background-color", "");
        //             next();
        //         });

        //         let existingProduct = $(`#room_table_body tr[data-id="${productId}"]`);
        //         if (existingProduct.length > 0) {
        //             let qtyField = existingProduct.find(".product_quantity");
        //             let newQty = parseInt(qtyField.text()) + 1;
        //             qtyField.text(newQty);

        //             let totalPriceField = existingProduct.find(".product_total_price");
        //             totalPriceField.text(`$${(newQty * productPrice).toFixed(2)}`);

        //             let totalWeightField = existingProduct.find(".product_weight");
        //             totalWeightField.text(`${(newQty * productWeight).toFixed(2)} lbs`);
        //         } else {
        //             let productData = `
    //                 <tr data-id="${productId}">
    //                     <td>
    //                         <input type="checkbox" class="single_check">  <br>
    //                         <input type="checkbox" class="double_check">
    //                     </td>
    //                     <td>${productLabel}</td>
    //                     <td>${productDescription}</td>
    //                     <td class="product_weight">${productWeight.toFixed(2)} lbs</td>
    //                     <td>$${productPrice.toFixed(2)}</td>
    //                     <td class="product_total_price">$${productPrice.toFixed(2)}</td>
    //                     <td class="product_quantity">1</td>
    //                     <td>
    //                         <button class="btn btn-outline-danger remove_product">x</button>
    //                     </td>
    //                 </tr>
    //             `;

        //             lastRoomRow.after(productData);
        //         }

        //         $.post("{{ route('cart.addProduct') }}", {
        //             _token: "{{ csrf_token() }}",
        //             room_name: lastRoomRow.find(".room_input").val(),
        //             product_id: productId,
        //             quantity: 1,
        //             price: productPrice
        //         });

        //         updateTotals();
        //     });

        //     $(document).on("click", ".remove_product", function() {
        //         let productRow = $(this).closest("tr");
        //         let productId = productRow.data("id");

        //         $.post("{{ route('cart.removeProduct') }}", {
        //             _token: "{{ csrf_token() }}",
        //             product_id: productId
        //         });

        //         productRow.remove();
        //         updateTotals();
        //     });

        //     $(document).on("click", "#stock_check_btn", function(event) {
        //         let errors = [];

        //         let jobName = $("#job_name").val().trim();
        //         if (jobName === "") {
        //             errors.push("Please enter a Job Name.");
        //         }

        //         let roomExists = $(".room_input").length > 0;
        //         if (!roomExists) {
        //             errors.push("Please add at least one room.");
        //         }

        //         let productExists = $("#room_table_body tr[data-id]").length > 0;
        //         if (!productExists) {
        //             errors.push("Please add at least one product.");
        //         }

        //         let assembleRequired = $("input[name='assemble_cabinets_check']:checked").val();
        //         if (!assembleRequired) {
        //             errors.push("Please select 'Yes' or 'No' for 'Assemble All Cabinetry'.");
        //         }

        //         if (errors.length > 0) {
        //             Swal.fire({
        //                 icon: "error",
        //                 title: "Incomplete Steps",
        //                 html: errors.join("<br>"),
        //                 confirmButtonText: "OK",
        //                 confirmButtonColor: "#d33"
        //             });
        //             event.preventDefault();
        //             return;
        //         }

        //         Swal.fire({
        //             icon: "success",
        //             title: "Stock Check Processing",
        //             text: "Stock check is now processing...",
        //             confirmButtonText: "OK",
        //             confirmButtonColor: "#3085d6"
        //         });
        //     });

        // });
        // Old jquery code that saved data in cart
        // $(document).ready(function() {
        //     let lastRoomRow = null;

        //     function updateTotals() {
        //         let totalPrice = 0;
        //         let totalWeight = 0;

        //         $(".product_total_price").each(function() {
        //             totalPrice += parseFloat($(this).text().replace("$", "")) || 0;
        //         });

        //         $(".product_weight").each(function() {
        //             totalWeight += parseFloat($(this).text().replace(" lbs", "")) || 0;
        //         });

        //         $(".custom_all_product_total").text(`$${totalPrice.toFixed(2)}`);
        //         $(".custom_all_product_weights").text(`${totalWeight.toFixed(2)} lbs`);
        //     }

        //     $("#add_room_btn").click(function() {
        //         let jobName = $("#job_name").val().trim();
        //         if (jobName === "") {
        //             alert("Please enter a Job Name before adding a room.");
        //             return;
        //         }

        //         let roomRow = `
    //             <tr class="show_room table-warning">
    //                 <td><label>Room<span class="astirisk font-danger">*</span></label></td>
    //                 <td colspan="5">
    //                     <input required type="text" name="roomlabel[]" placeholder="Enter Room Name." class="form-control room_input">
    //                 </td>
    //                 <td>
    //                     <button class="btn btn-outline-danger remove_room">x</button>
    //                 </td>
    //             </tr>
    //         `;

        //         $("#room_table_body").append(roomRow);
        //         lastRoomRow = $("#room_table_body tr.show_room").last();

        //         // ** Save the room to the database **
        //         let roomName = lastRoomRow.find(".room_input").val();
        //         $.post("{{ route('cart.addRoom') }}", {
        //             _token: "{{ csrf_token() }}",
        //             job_name: jobName,
        //             room_name: roomName
        //         });
        //     });

        //     $(document).on("click", ".remove_room", function() {
        //         let roomRow = $(this).closest("tr");
        //         let roomName = roomRow.find(".room_input").val();

        //         $.post("{{ route('cart.removeRoom') }}", {
        //             _token: "{{ csrf_token() }}",
        //             room_name: roomName
        //         });

        //         roomRow.nextUntil(".show_room").remove();
        //         roomRow.remove();
        //         updateTotals();
        //     });

        //     $(document).on("dblclick", "[id^=product_label_]", function() {
        //         if (!lastRoomRow) {
        //             alert("Please add a room before selecting a product.");
        //             return;
        //         }

        //         let productRow = $(this).closest("tr");
        //         let productLabel = productRow.find("td:nth-child(1)").text().trim();
        //         let productSku = productRow.find("td:nth-child(2)").text().trim();
        //         let productDescription = productRow.find("td:nth-child(3)").text().trim();
        //         let productWeight = parseFloat(productRow.find("td:nth-child(4)").text().trim()) || 0;
        //         let productPrice = parseFloat(productRow.find("td:nth-child(5)").text().trim().replace("$",
        //             "")) || 0;


        //         // Adding highlight animation when product is added
        //         $(this).closest("tr").css("background-color", "#d4edda").delay(300).queue(function(next) {
        //             $(this).css("background-color", "");
        //             next();
        //         });
        //         let existingProduct = $(`#room_table_body tr[data-sku="${productSku}"]`);
        //         if (existingProduct.length > 0) {
        //             let qtyField = existingProduct.find(".product_quantity");
        //             let newQty = parseInt(qtyField.text()) + 1;
        //             qtyField.text(newQty);

        //             let totalPriceField = existingProduct.find(".product_total_price");
        //             totalPriceField.text(`$${(newQty * productPrice).toFixed(2)}`);

        //             let totalWeightField = existingProduct.find(".product_weight");
        //             totalWeightField.text(`${(newQty * productWeight).toFixed(2)} lbs`);
        //         } else {
        //             let productData = `
    //                 <tr data-sku="${productSku}">
    //                     <td>
    //                         <input type="checkbox" class="single_check">  <br>
    //                         <input type="checkbox" class="double_check">
    //                     </td>
    //                     <td>${productLabel}</td>
    //                     <td>${productDescription}</td>
    //                     <td class="product_weight">${productWeight.toFixed(2)} lbs</td>
    //                     <td>$${productPrice.toFixed(2)}</td>
    //                     <td class="product_total_price">$${productPrice.toFixed(2)}</td>
    //                     <td class="product_quantity">1</td>
    //                     <td>
    //                         <button class="btn btn-outline-danger remove_product">x</button>
    //                     </td>
    //                 </tr>
    //             `;

        //             lastRoomRow.after(productData);
        //         }

        //         $.post("{{ route('cart.addProduct') }}", {
        //             _token: "{{ csrf_token() }}",
        //             room_name: lastRoomRow.find(".room_input").val(),
        //             product_sku: productSku,
        //             quantity: 1,
        //             price: productPrice
        //         });

        //         updateTotals();
        //     });

        //     $(document).on("click", ".remove_product", function() {
        //         let productRow = $(this).closest("tr");
        //         let productSku = productRow.data("sku");

        //         $.post("{{ route('cart.removeProduct') }}", {
        //             _token: "{{ csrf_token() }}",
        //             product_sku: productSku
        //         });

        //         productRow.remove();
        //         updateTotals();
        //     });
        //     $(document).on("click", "#stock_check_btn", function(event) {
        //         let assembleRequired = $("input[name='assemble_cabinets_check']:checked").val();

        //         if (!assembleRequired) {
        //             Swal.fire({
        //                 icon: "warning",
        //                 title: "Missing Selection",
        //                 text: "Please select 'Yes' or 'No' for 'Assemble All Cabinetry' before checking stock.",
        //                 confirmButtonText: "OK",
        //                 confirmButtonColor: "#d33"
        //             });
        //             event.preventDefault(); // Prevents further action
        //             return;
        //         }

        //         // If the user has selected Yes or No, show success SweetAlert
        //         Swal.fire({
        //             icon: "success",
        //             title: "Stock Check Processing",
        //             text: "Stock check is now processing...",
        //             confirmButtonText: "OK",
        //             confirmButtonColor: "#3085d6"
        //         });
        //     });


        // });
    </script>



@endsection
