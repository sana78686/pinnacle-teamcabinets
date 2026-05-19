@extends('layouts.tenant.master')
@section('title', 'Order')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/owlcarousel.css">
@endsection

@section('style')
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
                                    <a class="btn btn-primary" href="#step-1">1</a>
                                    <p>Select Catalog</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#step-2">2</a>
                                    <p>Select Door Style</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#step-3">3</a>
                                    <p>Cart Products</p>
                                </div>
                                {{-- <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#step-4">4</a>
                                    <p>Step 4</p>
                                </div> --}}
                            </div>
                        </div>
                        <form action="#" method="POST">
                            <div class="setup-content" id="step-1">
                                <div class="row">
                                    @foreach ($product_catalogs as $catalog)
                                        <div class="col-xl-2 col-sm-6 box-col-4a">
                                            <a href="{{ route('tenant_order_step_2', ['id' => $catalog->id]) }}">
                                                <div class="card">
                                                    <div class="product-box">
                                                        <div class="product-img">
                                                            <div class="ribbon ribbon-danger"><i class="fa fa-file"
                                                                    class="p-0"></i>&nbsp;&nbsp; View PDF</div>
                                                            @if (!empty($catalog->image))
                                                                <img class="img-fluid"
                                                                    src="{{ url($catalog->image) }}"
                                                                    alt="">
                                                                {{-- <img class="img-fluid" src="{{ url('/') }}{{ $catalog->image }}" alt="" style="height: 200px"> --}}
                                                            @else
                                                                <img class="img-fluid"
                                                                    src="{{ url('product/catalog-img/no-img.avif') }}"
                                                                    alt="">
                                                            @endif
                                                            <div class="product-hover">
                                                                <ul>
                                                                    <li><i class="icon-eye"></i></li>
                                                                    {{-- <li><i class="icon-shopping-cart"></i></li> --}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="product-details">
                                                            <h6>{{ ucfirst($catalog->name) }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                    <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                </div>
                            </div>
                            <div class="setup-content" id="step-2">
                                <div class="col-xs-12">
                                    <div class="col-md-12">

                                        <div class="owl-carousel owl-theme" id="owl-carousel-1">
                                            @forelse ($door_colors as $door_style)

                                            <div class="item">
                                                <img src="{{ url('') }}/assets/main/images/slider/1.jpg"
                                                    alt="">
                                                <p><strong>{{ $door_style->product_label }}</strong></p>
                                            </div>
                                            @empty

                                            @endforelse
                                            @php
                                                /*
                                            @endphp
                                            {{-- <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/1.jpg"
                                                    alt="">
                                                <p><strong>Shaker White</strong></p>
                                            </div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/2.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/3.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/4.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/5.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/6.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/7.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/8.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/9.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/10.jpg"
                                                    alt=""></div>
                                            <div class="item"><img
                                                    src="{{ url('') }}/assets/main/images/slider/11.jpg"
                                                    alt=""></div> --}}

                                                    @php
                                                        */
                                                    @endphp
                                        </div>
                                        <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="setup-content" id="step-3">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                        <input type="text" name="sku_no" class="sku_no form-control" value=""
                                            placeholder = "Enter SKU number.">
                                        <br>
                                        <strong>
                                            <b>NOTE: Do empty search to reset.</b>
                                        </strong>
                                        <strong>
                                            <b>NOTE: Double click on Cabinet Label to select product.</b>
                                        </strong>
                                        <hr>
                                        @forelse ($product_sections as $section)
                                            <div class="">
                                                <div class="">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed ps-0"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseicon{{ $section->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseicon{{ $section->id }}">
                                                            {{ $section->cabinets_name }}</button>
                                                            <i data-feather="chevron-down" class="p-1"></i>
                                                    </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon{{ $section->id }}"
                                                    data-parent="#accordionoc">

                                                    <div class="table-responsive table-xs">
                                                        <table
                                                            class="table p-0 m-0 display table-striped table-bordered table-sm"
                                                            id="">
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

                                                            @foreach ($section->products as $product)
                                                                <tr>

                                                                    <td>{{ $product->label }}</td>
                                                                    <td>{{ $product->sku }}</td>
                                                                    <td>{{ $product->description }}</td>
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
                                        @empty
                                            There is nothing to show.
                                        @endforelse
                                        <div class="default-according" id="accordionclose">
                                            @forelse ($product_sections as $section)

                                                <div class="card b-r-0">
                                                    <div class="card-header" id="heading1">
                                                        <h6 class="mb-0">
                                                            <button class="btn btn-link" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $section->id }}"
                                                                aria-expanded="true"
                                                                aria-controls="heading1">{{ $section->cabinets_name }}</button>
                                                        </h6>
                                                    </div>
                                                    <div class="collapse" id="collapse{{ $section->id }}"
                                                        aria-labelledby="heading1" data-parent="#accordionclose">
                                                        <div class="p-1 card-body">
                                                            <div class="table-responsive table-xs">
                                                                <table
                                                                    class="table p-0 m-0 display table-striped table-bordered table-sm"
                                                                    id="">
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

                                                                    @foreach ($section->products as $product)
                                                                        <tr>

                                                                            <td>{{ $product->label }}</td>
                                                                            <td>{{ $product->sku }}</td>
                                                                            <td>{{ $product->description }}</td>
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
                                        <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

                                        <div class="box box-primary custom_order_product_description_cls custom_cart_main_cls"
                                            style="float:left;">
                                            <div class="err_cart_tot" style="margin-left:2%"></div>
                                            <div class="form-inline job_and_room_add">
                                                <p
                                                    style="padding:5px 10px 0px 10px !important; margin:0px 0px 0px 0px !important;">
                                                    <b>Step #1: Please enter Job Name and Room before selecting items from
                                                        inventory.</b>
                                                </p><br>
                                                <span class="lab_job_name" style="margin-left:2%"><b>Job Name
                                                        <span class="astirisk">*</span></b></span>
                                                <input type="text" name="job_name" class="job_name"
                                                    value="Quote Data">
                                                <button type="button" class="btn btn-default custom_add_more_btn">+ ADD
                                                    ROOM</button>
                                                <span class="" style="float:right;">
                                                    <a href="#"
                                                        onclick="return confirm('Are you sure you want to clear all the items in cart?');"
                                                        class="btn btn-default">
                                                        Clear Cart
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="err_job_name" style="font-weight: normal;"></div>

                                            <div class="assemble_cost_cls">
                                                <label for="html">Assemble All Cabinetry?<span
                                                        class="asterisk">*</span></label>
                                                <div class="space_assemble_check"></div>


                                                <input type="radio" id="ass_required" name="assemble_cabinets_check"
                                                    value="1">
                                                <label for="html">Yes</label>

                                                <input type="radio" id="ass_not_required" class="space_right"
                                                    name="assemble_cabinets_check" value="2">
                                                <label for="css">No</label><span class="err_assemble_check"
                                                    style="font-weight:525;"></span><br>
                                            </div>
                                            <table class="table table-bordered custom_cart_cls" id="my_table_id">

                                                <tr>
                                                    <!--  <div class="col-12"><div class="form-row"><label class="lab_job_name">Job Name
                                                                                    <input type="text" name="job_name" class="job_name"></label></div></div>
                                                                                    <div class="err_job_name" style="font-weight: normal;"></div>
                                                                                    <td colspan="8"><button type="button" style="" class="btn btn-default custom_add_more_btn">+ ADD ROOM</button></td>
                                                                                 -->
                                                </tr>
                                                <tbody class="custom_display_select_val1 active custom_room_cls"
                                                    ondrop="drop(event)" ondragover="allowDrop(event)"
                                                    style="border-top:0px;">
                                                    <tr class="product_room_cls">
                                                        <th>
                                                            <label class="room_lab_cls">Room<span
                                                                    class="astirisk">*</span></label>
                                                        </th>
                                                        <th>
                                                            <input type="text" name="roomlabel[]" data-attr="1"
                                                                onclick="add_active_clas('1');" id="roomlabel"
                                                                style="width: 84px;">
                                                            <div class="err_roomlabel" style="font-weight: normal;"></div>
                                                            <input type="hidden" name="roomlabel_id[]" id="roomlabel_id"
                                                                value="1">
                                                            <input type="hidden" name="catalogue_name"
                                                                id="catalogue_name" value="">
                                                        </th>
                                                    </tr>
                                                    <tr>
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
                                            <div class="err_cart_value_select"></div>
                                            <div class="form-inline formfield">
                                                <label style="margin-left:2%;"
                                                    class="order_comment_cls"><b>Comment</b></label>
                                                <textarea style="margin-left:1%; width:80%" rows="4" name="order_comment" class="order_comment"
                                                    maxlength="200"></textarea>
                                            </div>


                                        </div>

                                        <div class="clearfix box-footer custom_cart_footer">

                                            <button class="btn btn-default" id="print_btn"
                                                onclick="checkvalidation_process(event)" name="print_btn">Print</button>
                                            <button class="btn btn-default" id="save_quote_btn"
                                                onclick="checkvalidation(event,'quote')" name="save_quote_btn">Save
                                                Quote</button>
                                            <button class="btn btn-default" id="save_shipping_quote_btn"
                                                onclick="checkvalidation(event,'shipping')"
                                                name="save_shipping_quote_btn">Request
                                                Shipping Quote</button>

                                            <button class="btn btn-default" id="stock_check_btn"
                                                onclick="checkvalidation(event,'isStockCheck')" name="stock_check_btn"
                                                style="display:none">Update Stock Check</button>
                                            <button class="btn btn-default" id="stock_check_btn"
                                                onclick="checkvalidation(event,'isStockCheck')" name="stock_check_btn"
                                                style="display:none">Stock Check</button>
                                            <button class="btn btn-default" id="process_order_btn"
                                                onclick="checkvalidation_process(event)" name="process_order_btn">Process
                                                Order</button>
                                            <div id="leaveWarning">Please dont leave me!</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="setup-content" id="step-4">
                                <div class="col-xs-12">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">State</label>
                                            <input class="mt-1 form-control" type="text" placeholder="State"
                                                required="required">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">City</label>
                                            <input class="mt-1 form-control" type="text" placeholder="City"
                                                required="required">
                                        </div>
                                        <button class="btn btn-success pull-right" type="submit">Finish!</button>
                                    </div>
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
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-two.js"></script>

    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl.carousel.js"></script>
    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl-custom.js"></script>
@endsection
