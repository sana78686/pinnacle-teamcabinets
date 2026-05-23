@extends('layouts.tenant.role.master')
@section('title', 'Order')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ dynamic_url('') }}/assets/main/css/owlcarousel.css">
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
                                    <a class="btn btn-light" href={{ route('tenant_order_create') }}>1</a>
                                    <p>Select Catalog</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-primary" href="#">2</a>
                                    <p>Select Door Style</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#">3</a>
                                    <p>Cart Products</p>
                                </div>
                                {{-- <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#step-4">4</a>
                                    <p>Step 4</p>
                                </div> --}}
                            </div>
                        </div>
                        <form action="#" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="owl-carousel owl-theme" id="owl-carousel-1">
                                        @foreach ($door_colors as $door_style)
                                            <a
                                                href="{{ route('tenant_order_create_step_3', ['catalog_id' => request('id'), 'door_id' => $door_style->id]) }}">
                                                <div class="item">
                                                    <img src="{{ url('') }}/assets/main/images/slider/1.jpg"
                                                        alt="">
                                                    <p><strong>{{ $door_style->product_label }}</strong></p>
                                                </div>
                                        @endforeach
                                        </a>
                                    </div>
                                    {{-- <button class="btn btn-primary nextBtn pull-right" type="button">Next</button> --}}
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
    <script src="{{ dynamic_url('') }}/assets/main/js/form-wizard/form-wizard-two.js"></script>
    <script src="{{ dynamic_url('') }}/assets/main/js/owlcarousel/owl.carousel.js"></script>
    <script src="{{ dynamic_url('') }}/assets/main/js/owlcarousel/owl-custom.js"></script>
    <script>
        $('#owl-carousel-1').owlCarousel({
            loop: false, // Prevents cloning
            margin: 10,
            nav: true,
            dots: true,
            autoplay: false, // Prevents automatic looping
            items: 1 // Ensures only one item per slide
        });
    </script>
@endsection
