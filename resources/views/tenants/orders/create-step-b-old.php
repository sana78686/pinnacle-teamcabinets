@extends('layouts.light.master')
@section('title', 'Order')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/owlcarousel.css">
@endsection
@section('style')
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="p-0 m-0 b-r-0">
            <div class="p-3 card-body">
                <div class="row">
                    <div class="pb-3 col-sm-12">
                        <div class="owl-carousel owl-theme" id="owl-carousel-1">
                            <div class="item">
                                <img src="{{ url('') }}/assets/main/images/slider/1.jpg" alt="">
                                <p><strong>Shaker White</strong></p>
                            </div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/1.jpg"
                                    alt="">
                                <p><strong>Shaker White</strong></p>
                            </div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/2.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/3.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/4.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/5.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/6.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/7.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/8.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/9.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/10.jpg"
                                    alt=""></div>
                            <div class="item"><img src="{{ url('') }}/assets/main/images/slider/11.jpg"
                                    alt=""></div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <h6>Shaker White</h6>
                        <div class="item">
                            <img src="{{ url('') }}/assets/product/product-img/SW-Shaker-White.jpg" alt=""
                                style="height: 150px;">
                        </div><br>
                        <table class="table table-bordered">
                            <thead>
                                <h6 class="f-w-600">Product Details</h6>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <p>Base Cabinets:</p>
                                    </th>
                                    <td>Base Cabinet 9" W</td>
                                </tr>
                                <tr>
                                    <th>SKU:</th>
                                    <td>A-BT9</td>
                                </tr>
                                <tr>
                                    <th>Weight:</th>
                                    <td>38 lbs</td>
                                </tr>
                                <tr>
                                    <th>Cost:</th>
                                    <td> $395.00</td>
                                </tr>
                                <tr>
                                    <th>Details:</th>
                                    <td>W9</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <div class="card b-r-0">
                            <div class="card-header">
                                <div class="row">
                                    <input type="text" name="sku_no" class="sku_no" value=""
                                        placeholder = "Enter SKU number">
                                </div>
                                <span>
                                    <b>NOTE: Do empty search to reset.</b>
                                </span>
                                <span>
                                    <b>NOTE: Double click on Cabinet Label to select product.</b>
                                </span>
                            </div>
                            <div class="default-according" id="accordionclose">
                                @forelse ($product_sections as $section)
                                    <div class="card b-r-0">
                                        <div class="card-header" id="heading1">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $section->id }}" aria-expanded="true"
                                                    aria-controls="heading1">{{ $section->cabinets_name }}</button>
                                            </h6>
                                        </div>
                                        <div class="collapse" id="collapse{{ $section->id }}" aria-labelledby="heading1"
                                            data-parent="#accordionclose">
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
                                {{-- <div class="card">
                                    <div class="card-header" id="heading2">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#collapse2" aria-expanded="false"
                                                aria-controls="heading2">Collapsible Group Item #<span
                                                    class="digits">2</span></button>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="collapse2" aria-labelledby="heading2"
                                        data-parent="#accordionclose">
                                        <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                            moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                            haven't heard of them accusamus labore sustainable VHS.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading3">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#collapse3" aria-expanded="false"
                                                aria-controls="collapse3">Collapsible Group Item #<span
                                                    class="digits">3</span></button>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="collapse3" aria-labelledby="heading3"
                                        data-parent="#accordionclose">
                                        <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                            moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                            haven't heard of them accusamus labore sustainable VHS.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading4">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#collapse4" aria-expanded="false"
                                                aria-controls="collapse4">Collapsible Group Item #<span
                                                    class="digits">4</span></button>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="collapse4" aria-labelledby="heading4"
                                        data-parent="#accordionclose">
                                        <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                            moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                            haven't heard of them accusamus labore sustainable VHS.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading5">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#collapse5" aria-expanded="false"
                                                aria-controls="collapse5">Collapsible Group Item #<span
                                                    class="digits">5</span></button>
                                        </h6>
                                    </div>
                                    <div class="collapse" id="collapse5" aria-labelledby="heading5"
                                        data-parent="#accordionclose">
                                        <div class="card-body">Anim pariatur cliche reprehenderit, enim eiusmod high life
                                            accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                            skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf
                                            moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                            haven't heard of them accusamus labore sustainable VHS.</div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">

                        <div class="box box-primary custom_order_product_description_cls custom_cart_main_cls"
                            style="float:left;">
                            <div class="err_cart_tot" style="margin-left:2%"></div>
                            <div class="form-inline job_and_room_add">
                                <p style="padding:5px 10px 0px 10px !important; margin:0px 0px 0px 0px !important;">
                                    <b>Step #1: Please enter Job Name and Room before selecting items from
                                        inventory.</b>
                                </p><br>
                                <span class="lab_job_name" style="margin-left:2%"><b>Job Name
                                        <span class="astirisk">*</span></b></span>
                                <input type="text" name="job_name" class="job_name" value="Quote Data">
                                <button type="button" class="btn btn-default custom_add_more_btn">+ ADD ROOM</button>
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
                                <label for="html">Assemble All Cabinetry?<span class="asterisk">*</span></label>
                                <div class="space_assemble_check"></div>
                                <input type="radio" id="ass_required" name="assemble_cabinets_check" value="1">
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
                                <tbody class="custom_display_select_val1 active custom_room_cls" ondrop="drop(event)"
                                    ondragover="allowDrop(event)" style="border-top:0px;">
                                    <tr class="product_room_cls">
                                        <th>
                                            <label class="room_lab_cls">Room<span class="astirisk">*</span></label>
                                        </th>
                                        <th>
                                            <input type="text" name="roomlabel[]" data-attr="1"
                                                onclick="add_active_clas('1');" id="roomlabel" style="width: 84px;">
                                            <div class="err_roomlabel" style="font-weight: normal;"></div>
                                            <input type="hidden" name="roomlabel_id[]" id="roomlabel_id"
                                                value="1">
                                            <input type="hidden" name="catalogue_name" id="catalogue_name"
                                                value="">
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
                                <label style="margin-left:2%;" class="order_comment_cls"><b>Comment</b></label>
                                <textarea style="margin-left:1%; width:80%" rows="4" name="order_comment" class="order_comment"
                                    maxlength="200"></textarea>
                            </div>


                        </div>

                        <div class="clearfix box-footer custom_cart_footer">

                            <button class="btn btn-default" id="print_btn" onclick="checkvalidation_process(event)"
                                name="print_btn">Print</button>
                            <button class="btn btn-default" id="save_quote_btn" onclick="checkvalidation(event,'quote')"
                                name="save_quote_btn">Save Quote</button>
                            <button class="btn btn-default" id="save_shipping_quote_btn"
                                onclick="checkvalidation(event,'shipping')" name="save_shipping_quote_btn">Request
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

        </div>
    </div>


    <!-- Container-fluid Ends-->
@endsection

@section('script')

    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl.carousel.js"></script>
    <script src="{{ route('/') }}/assets/main/js/owlcarousel/owl-custom.js"></script>
@endsection
