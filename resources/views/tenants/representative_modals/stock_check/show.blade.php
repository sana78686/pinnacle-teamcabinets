@extends('layouts.tenant.role.master')
@section('title', 'Stock Check Menu')
@section('css')
@endsection
@section('style')
@endsection
{{-- @section('breadcrumb-title')
    <h2>Stock Check<span>Details </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item active">Stock Check</li>
    <li class="breadcrumb-item">View</li>
@endsection --}}
@section('content')
    <div class="content-wrapper card b-r-0" style="min-height: 348px;">
        <!-- Main content -->
        <section class="p-2 m-2 card-body" style="padding-top:30px;">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="row ">
                        <div class="col-6 col-xl-4 col-md-6 col-sm-12 custom_order_bill_form_cls">
                            <div class="box-header" style="padding-left:0px !important;">
                                <h3 class="box-title"><b>Bill To :</b></h3>
                            </div>
                            <div class="form-group">
                                Name : &nbsp;&nbsp;{{ ucfirst($stock_check_request->user->name) }} </div>
                            <div class="form-group">
                                Address : &nbsp;&nbsp;{{ $stock_check_request->user_address }} </div>
                            <div class="form-group">
                                Email : &nbsp;&nbsp;{{ ucfirst($stock_check_request->user_email) }} </div>
                            <div class="form-group">
                                Phone : &nbsp;&nbsp;{{ $stock_check_request->user_phone }} </div>
                        </div>
                        <div class="col-6 col-xl-4 col-md-6 col-sm-12 custom_order_bill_form_cls">
                            <div class="box-header" style="padding-left:0px !important;">
                                <h3 class="box-title"><b>Ship To :</b></h3>
                            </div>
                            <div class="form-group">
                                Name : {{ ucfirst($stock_check_request->user->name) }} </div>
                            <div class="form-group">
                                Address : {{ $stock_check_request->user_address }} </div>
                            <div class="form-group">
                                Email : {{ ucfirst($stock_check_request->user_email) }} </div>
                            <div class="form-group">
                                Phone : {{ $stock_check_request->user_phone }} </div>
                        </div>
                        <div class="col-6 col-xl-4 col-md-6 col-sm-12">
                            <div class="box-header">
                                <h3 class="box-title"> </h3>
                            </div>
                            <div class="form-group">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12" style="max-height: 350px; overflow-y: auto;">
                    <div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
                        <div class="box box-primary custom_order_product_description_cls">
                            <div class="job_name_cls" style="padding:5px 10px 5px 0 ;">
                                <hr>
                                <b>Job Name</b> : {{ $stock_check_request->job_name }}
                            </div>
                            <table class="table custom_cart_cls table-border-vertical">
                                <thead class="table-light">
                                    <tr>
                                        <th>Double Check Work</th>
                                        <th>Cabinet Name</th>
                                        <th>Cabinet Description</th>
                                        <th>Weight</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Quantity</th>
                                        <th>Assemble Cost</th>
                                        <th>Item Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="#" id="add_items_comment_form" method="post">
                                        <input type="hidden" name="stock_check_id" value="857">
                                        @foreach ($rooms as $room)
                                            <tr>
                                                <th colspan="7">Room: {{ $room['room_name'] }}</th>
                                            </tr>
                                            <input type="hidden" name="roomlabel[]" value="2">
                                            <input type="hidden" name="roomlabel_id[]" id="roomlabel_id" value="1">
                                            @if (isset($room['products']) && count($room['products']) > 0)
                                                @foreach ($room['products'] as $each)
                                                    @php
                                                        $productData = \App\Models\Product::with('doorColor')->find(
                                                            $each['product_id'],
                                                        );
                                                        $productWeight = $productData ? $productData->weight : 0;
                                                        $productPrice = $productData ? $productData->price : 0;
                                                        $productAssembleCost = $productData
                                                            ? $productData->assemble_cost
                                                            : 0;
                                                        // Calculate total for each product
                                                        $totalProductWeight = $productWeight * $each['quantity'];
                                                        $totalProductPrice = $productPrice * $each['quantity'];
                                                        $totalProductAssembleCost =
                                                            $productAssembleCost * $each['quantity'];

                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            @if ($productData->checkbox_status == 1)
                                                                <label class='container_chk_lbl'><input type='checkbox'
                                                                        checked disabled><span
                                                                        class='checkmark'></span></label>
                                                                &nbsp;&nbsp;<label class='container_chk_lbl_01'><input
                                                                        type='checkbox' disabled><span
                                                                        class='checkmark'></span>
                                                                @elseif($productData->checkbox_status == 2)
                                                                    <label class='container_chk_lbl'><input type='checkbox'
                                                                            checked disabled><span
                                                                            class='checkmark'></span></label>
                                                                    &nbsp;&nbsp;<label class='container_chk_lbl_01'><input
                                                                            checked type='checkbox' disabled><span
                                                                            class='checkmark'></span>
                                                                    @else
                                                                        <label class='container_chk_lbl'><input
                                                                                type='checkbox'  disabled><span
                                                                                class='checkmark'></span></label>
                                                                        &nbsp;&nbsp;<label
                                                                            class='container_chk_lbl_01'><input
                                                                                type='checkbox' disabled><span
                                                                                class='checkmark'></span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $productData->label }}</td>
                                                        <td>{{ $productData->sku }} +
                                                            {{ $productData->doorColor->product_label }}</td>
                                                        <td>{{ $productData->weight }} lbs</td>
                                                        <td>${{ number_format($productData->cost, 2) }}</td>
                                                        @php
                                                            $productAssembleCost =
                                                                $productData->cost * $each['quantity'];
                                                        @endphp
                                                        <td>${{ number_format($productAssembleCost, 2) }}</td>
                                                        <td>{{ $each['quantity'] }}</td>
                                                        @php

                                                            $eachProductCost =
                                                                $productData->assemble_cost * $each['quantity'];
                                                        @endphp
                                                        <td>${{ number_format($eachProductCost, 2) }}</td>
                                                        <td>
                                                            <textarea style="width:100%; min-width:100%;" class="product_note" name="product_note1[]"></textarea>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <p>No products found for this room.</p>
                                            @endif
                                        @endforeach
                                        <input type="hidden" name="checkbox_val11[]" value="0">
                                        <input type="hidden" name="checkbox_val21[]" value="0">
                                        <input type="hidden" name="product_sku1[]" value="SW-Sample">
                                        <input type="hidden" name="product_weight1[]" value="7">
                                        <input type="hidden" name="product_cost1[]" value="0.00">
                                        <input type="hidden" name="product_quantity1[]" value="1">
                                        <input type="hidden" name="product_count_cost1[]" value="">
                                        <input type="hidden" name="product_cabinets_id1[]" value="38">
                                        <input type="hidden" name="product_name1[]" value="Sample Door">
                                        <input type="hidden" name="product_ids1[]" value="6789">
                                        <input type="hidden" name="product_cabinets_color1[]" value="Shaker White">
                                        <input type="hidden" name="product_tot_quantity1[]" value="2">
                                        <input type="hidden" name="product_tot_price1[]" value="0.00">
                                        <input type="hidden" name="product_actual_price1[]" value="0.00">
                                        <input type="hidden" name="product_details1[]" value="Shaker White Sample Door">
                                        <input type="hidden" name="add_pro_ids_room_wise1[]" value="6789">
                                        <input type="hidden" name="parent_door_price1[]" value="0.00">
                                        <input type="hidden" name="parent_door_factor1[]" value=".42">
                                        <input type="hidden" name="representative_door_price1[]" value="">
                                        <input type="hidden" name="representative_door_factor1[]" value="">
                                        <input type="hidden" name="user_door_factor1[]" value="">
                                        <input type="hidden" name="sel_catalogue_name1[]" value="TEAM CABINETS">
                                        <input type="hidden" name="product_cabinets_description1[]"
                                            value="SW - SW-Sample - Sample Door">
                                        <input type="hidden" name="product_assemble_cost1[]" value="0">
                                    </form>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Sub Total</th>
                                        <td>{{ number_format($stock_check_request->sub_total_weight, 2) }} lbs</td>
                                        <td></td>
                                        <td>${{ number_format($stock_check_request->sub_total_cost, 2) }}</td>
                                        <td></td>
                                        <td> ${{ number_format($stock_check_request->sub_total_assemble_cost, 2) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Cabinetry Assembly Cost</th>
                                        <td>${{ number_format($stock_check_request->sub_total_assemble_cost, 2) }} </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    {{-- <tr>
                                        <th colspan="5">Shipping Charges</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr> --}}
                                    <tr>
                                        <th colspan="2">Total (<span class="note_charges">Excluding Sales Tax And
                                                Payment Charges</span>)</th>
                                        <td></td>
                                        <td>{{ number_format($stock_check_request->sub_total_weight, 2) }} lbs</td>
                                        <td></td>
                                        <td>${{ number_format($stock_check_request->grand_total_cost, 2) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="order_name_cls" style="padding:5px 55px 5px 0 ;">
                                <b>Comment</b> : <p class="">{{ $stock_check_request->comment }}</p>
                            </div>
                            <button style="float:right; margin:5px;" class="btn btn-primary approve_stock_check"
                                onclick ="">Approve & Procced To Checkout</button>
                            <div class="form_sub">
                                <form action="#" id="view_ship_form" method="post">
                                    <input type="hidden" name="shipping_quote_id" value="857">
                                    <input type="hidden" name="user_id" value="703">
                                    <input type="hidden" name="bill_to_name" value="Jeet Ram">
                                    <input type="hidden" name="bill_to_address" value="915 Doyle Road Suite 303 -225">
                                    <input type="hidden" name="bill_to_email" value="ramkumarjeet31081994@gmail.com">
                                    <input type="hidden" name="bill_to_phone" value="1231231234">
                                    <input type="hidden" name="ship_to_name" value="Jeet Ram">
                                    <input type="hidden" name="ship_to_address" value="915 Doyle Road Suite 303 -225">
                                    <input type="hidden" name="ship_to_email" value="ramkumarjeet31081994@gmail.com">
                                    <input type="hidden" name="ship_to_phone" value="1231231234">
                                    <input type="hidden" name="product_img_src"
                                        value="https://stage.teamcabinets.com/assets/admin/cabinet_img/Shaker_White.PNG">
                                    <input type="hidden" name="product_img_name" value="Shaker White">
                                    <input type="hidden" name="product_description_val"
                                        value="Shaker White Sample Door">
                                    <input type="hidden" name="room_arry"
                                        value='{"2":{"checkbox_val1":["0"],"checkbox_val2":["0"],"product_sku":["SW-Sample"],"product_weight":["7"],"product_quantity":["1"],"product_cost":["0.00"],"product_count_cost":null,"product_cabinets_id":["38"],"product_name":["Sample Door"],"product_ids":["6789","6789"],"product_cabinets_color":["Shaker White"],"product_tot_quantity":["2"],"product_tot_price":["0.00"],"product_actual_price":["0.00"],"product_details":["Shaker White Sample Door"],"add_pro_ids_room_wise":["6789"],"parent_door_price":["0.00"],"parent_door_factor":[".42"],"representative_door_price":[""],"representative_door_factor":[""],"user_door_factor":[""],"sel_catalogue_name":["TEAM CABINETS"],"product_cabinets_description":["SW - SW-Sample - Sample Door"],"product_assemble_cost":["0"],"product_note":""}}'>
                                    <input type="hidden" name="cart_product_weight" value="7 lbs">
                                    <input type="hidden" name="all_cart_total" value="0">
                                    <input type="hidden" name="job_name" value="tester">
                                    <input type="hidden" name="order_comment" value="">
                                    <input type="hidden" name="affiliate_id" value="0">
                                    <input type="hidden" name="quote_name" value="">
                                    <input type="hidden" name="last_cata_name" value="6">
                                    <input type="hidden" name="ship_to_city" value="Deltona">
                                    <input type="hidden" name="ship_to_county" value="Volusia County">
                                    <input type="hidden" name="ship_to_country" value="USA">
                                    <input type="hidden" name="ship_to_zipcode" value="32725">
                                    <input type="hidden" name="ship_to_state" value="Florida">
                                    <input type="hidden" name="is_assemble" value="1">
                                    <input type="hidden" name="rep_id" value="439">
                                    <input type="hidden" name="parent_id" value="439">
                                    <input type="hidden" name="is_shipping_quote" value="2">
                                    <input type="hidden" name="order_shipping_cost" value="180">
                                    <input type="hidden" name="last_cata_name" value="6">
                                    <input type="hidden" id="is_edit_stock" name="is_edit_stock" value="">
                                    <input type="hidden" name="shipping_charges_arr"
                                        value='{"Pallets(Total Pallets = 1)":30,"Liftgate Charges":"0","Unload Charges(By Forklift)":"150","Delivery Charges(Residential)":"0","Miscellneous Charges":"0"}'>
                                    <input type="hidden" name="stock_check_shipping_type" value='1'>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </section> <!-- /.content -->
    </div>
    <div class="modal fade" id="userStockCheckApproveModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Stock Check Approved Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>
                    <p>Welcome to STOCK CHECK, this process may take up to 48hours to confirm our warehouse can fill your
                        order.</p>
                    <p>Once we receive confirmation, you will have 48 hours to act on this STOCK CHECK, after 48 hours, we
                        have to release these items for purchasers.</p>
                    <p>Please inform your clients. If you only need a QUOTE, then please select QUOTE, be sure to manually
                        add Taxes and Shipping costs to assure the accuracy of your estimate. If you need a SHIPPING QUOTE,
                        please feel free to send&nbsp; us your QUOTE, and we will be happy to help your company.</p>
                    <p>Thank you,</p>
                    <p>TEAM</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick ="approvedStockCheckRequest()"
                        data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- sweet alert  start --}}
    <script>
        function deleteUser(userId) {
            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the delete form
                    document.getElementById('deleteForm' + userId).submit();
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    {{-- sweet alert  end --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You can revert this within 60 days!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
    <script>
        // Status change script
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const userId = this.getAttribute('data-user-id');
                    const newStatus = this.value;
                    const previousValue = this.dataset.previousValue || this.value;
                    Swal.fire({
                        text: `You are about to change the user's status to ${newStatus}.`,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const csrfToken = document.querySelector(
                                'meta[name="csrf-token"]') ? document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content') : '';
                            if (!csrfToken) {
                                console.error('CSRF token not found!');
                                return; // Exit if the CSRF token is missing
                            }
                            // Get the route URL dynamically
                            const updateStatusUrl =
                                '{{ route('tenant_users_update_status', ':id') }}'.replace(
                                    ':id', userId);
                            fetch(updateStatusUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        status: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Updated!',
                                            `The user's status has been updated to ${newStatus}.`,
                                            'success');
                                    } else {
                                        Swal.fire('Error!',
                                            'There was a problem updating the status.',
                                            'error');
                                        dropdown.value =
                                            previousValue; // Revert if error occurs
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!',
                                        'There was a problem updating the status.',
                                        'error');
                                    dropdown.value = previousValue; // Revert on error
                                });
                        } else {
                            dropdown.value = previousValue; // Revert if canceled
                        }
                    });
                    this.dataset.previousValue = newStatus; // Store previous value
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loop through all copy icons for users
            document.querySelectorAll('.fa-copy').forEach(copyIcon => {
                copyIcon.addEventListener('click', function() {
                    const userId = this.id.split('-')[
                        2]; // Extract the user ID from the copy icon ID
                    const emailText = document.getElementById('email-' + userId)
                        .textContent; // Get the email using the user ID

                    // Use the Clipboard API to copy the email text
                    navigator.clipboard.writeText(emailText).then(function() {
                        // If the text is copied, show SweetAlert with the copied email
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Email: ' +
                                emailText, // Show the copied email in the SweetAlert message
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }).catch(function(err) {
                        // If an error occurs while copying, show an error message
                        console.error('Error copying text: ', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Failed to copy the email.',
                            confirmButtonText: 'Try Again'
                        });
                    });
                });
            });
        });
    </script>
@endsection


{{-- sweet alert link start --}}

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- sweet alert link end --}}
