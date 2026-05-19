@extends('layouts.light.master')
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
                                    <a class="btn btn-primary" href={{ route('tenant_order_create') }}">1</a>
                                    <p>Select Catalog</p>
                                </div>
                                <div class="stepwizard-step">
                                    <a class="btn btn-light" href="#">2</a>
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
                        <form action="#" method="get" action="#">
                            <div class="row">
                                @foreach ($product_catalogs as $catalog)
                                    <div class="col-xl-2 col-sm-6 box-col-4a">
                                        <a href="{{ route('tenant_order_create_step_2', ['id' => $catalog->id]) }}">
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
                                {{-- <button class="btn btn-primary nextBtn pull-right" type="submit">Next</button> --}}
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
