@extends('layouts.tenant.role.master')
@section('title', 'Order')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Create an<span>Order </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            @foreach ($product_catalogs as $catalog)
                <div class="col-xl-3 col-sm-6 box-col-4a">
                    <a href="{{ route('tenant_order_step_2', ['id' => $catalog->id]) }}">
                    <div class="card">
                        <div class="product-box">
                            <div class="product-img">
                                @if (!empty($catalog->image))
                                    <img class="img-fluid" src="{{ asset('storage/tenants/' . tenant('id') . '/images/' . $catalog->image) }}" alt="" style="height: 200px">
                                    {{-- <img class="img-fluid" src="{{ route('/') }}/{{ $catalog->image }}" alt="" style="height: 200px"> --}}
                                @else
                                    <img class="img-fluid" src="{{ url('product/catalog-img/no-img.avif') }}" alt=""
                                        style="height: 250px">
                                @endif
                                <div class="product-hover">
                                    <ul>
                                        <li><i class="icon-eye"></i></li>
                                        {{-- <li><i class="icon-shopping-cart"></i></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="product-details">
                                <h6>{{ $catalog->name }}</h6>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
