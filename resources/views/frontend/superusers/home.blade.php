@extends('frontend.superusers.layout')


@section('content')



<section id="wrapper">
    <div data-depth="1" class="breadcrumb-bg brcenter breadcrumb-full" style="background-image: url(https://cdn.shopify.com/s/files/1/0489/1171/2423/files/leo-kitchor-bg-breadcrum.jpg?v=1654305611); min-height:480px; ">
        <div class="container">
            <nav data-depth="1" class="breadcrumb hidden-sm-down">
                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">


                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="#">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>


                </ol>
            </nav>
        </div>
    </div>
    <div class="row">



        <div id="content-wrapper" class="col-lg-12 col-xs-12 js-content-wrapper">



            <section id="main">






                <section id="content" class="page-home">



                    {{-- first  --}}
                    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
@if(!empty($bennersection))

   <section
    class="d-flex justify-content-center align-items-center  text-white"
    style="
        height: 100vh;
        width: 100%;
        margin: 0;
        padding: 0;
        background:
            linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('{{ asset($bennersection->banner_image) }}')
            center center / cover no-repeat;
    "
>
    <div
        class="container"
        style="
            max-width: 900px;
        "
    >
        <h1
            class="fw-bold"
            style="
                font-size: 4rem;
                line-height: 1.2;
                font-weight: 700;
                margin-top: 1rem;
                padding-top:5rem;
                color: #ffffff;
            "
        >
            {{ $homesettings?->benner_title }}
        </h1>
        <p
            class="lead"
            style="
                font-size: 1.25rem;
                font-weight: 400;
                color: #eaeaea;
            "
        >
             {{ $homesettings?->benner_description }}
        </p>
    </div>
</section>

@endif








    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
     @if(!empty($aboutussection) )
    <div class="wrapper">

        <div class="container">
            <div class="row box-padding-top100 banner1-home1 ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12 col-sp-12 banner-left ApColumn ">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApImage -->
                    <div id="image-form_8998935955098666" class="block ApImage">



                         <img class="img-fluid " src="{{ asset($aboutussection->aboutus_image) }}" title="" alt="" style=" width:100%;
			                              height:auto" loading="lazy">




                    </div>
                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12 col-sp-12 banner-right ApColumn ">
                    <div class="sub-title-widget sub-title-ap-column">About us</div>
                    <!-- @file modules\appagebuilder\views\templates\hook\ApButton -->
                    <div class="AppButton button ApButton ">
                        <h4 class="title_block">
{{ $aboutussection->aboutus_title }}

                        </h4>
                        <div class="sub-title-widget">{{ $aboutussection->aboutus_description}}</div>
                        <a href="#/en/content/4-about-us">
                            <span class="btn btn-link btn-lg">Contact Us </span>

                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
     @endif
    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->

    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
    @if(!empty($cardsection))
    <div class="wrapper" style="background:url(https://cdn.shopify.com/s/files/1/0489/1171/2423/files/leo-kitchor-home1-bg-banner4-img1.jpg?v=1653465758)  no-repeat; background-size: cover">

        <div class="container">
            <div class="row box-padding130 box-service-2 banner4-home1 ApRow  has-bg bg-fullwidth-container" style="">
                <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                    <div class="sub-title-widget sub-title-ap-column">Why choose us</div>
                    <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                    <div class="block ApRawHtml">

                        <h4 class="title_block">Team Cabinet Distributors Difference</h4>
                    </div>
                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 col-sp-12 sv-col-2 ApColumn ">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                    <div class="block sv-content ApRawHtml">
                        <i class="fa fa-table"></i><br>
                        <div>{{$cardsection->card_one_title}}</div>
                        <p>{{$cardsection->card_one_description}}</p>
                    </div>
                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 col-sp-12 sv-col-2 ApColumn ">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                    <div class="block sv-content ApRawHtml">
                        <i class="fa fa-dollar"></i><br>
                        <div>{{$cardsection->card_one_description}}</div>
                        <p>{{$cardsection->card_one_description}}</p>
                    </div>
                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12 col-sp-12 sv-col-2 ApColumn ">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                    <div class="block sv-content ApRawHtml">
                        <i class="fa fa-handshake-o"></i><br>
                        <div>{{$cardsection->card_one_description}}</div>
                        <p class="mb-4">{{$cardsection->card_one_description}}</p>
                    </div>
                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->


            </div>
        </div>
    </div>
    @endif

    <script type="text/javascript">
        ap_list_functions.push(function() {
            $.stellar({
                horizontalScrolling: false
            });
        });

    </script>

    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
    <div class="wrapper" style="background:url(https://cdn.shopify.com/s/files/1/0489/1171/2423/files/leo-kitchor-home1-bg-video.jpg?v=1653471907)  no-repeat center center; background-size: cover">

        <div class="container">
            <div class="row box-padding130 banner-video-home1 ApRow  has-bg bg-fullwidth-container" style="">
                <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 col-sp-12 banner-left ApColumn ">
                    <div class="sub-title-widget sub-title-ap-column">promo video</div>
                    <!-- @file modules\appagebuilder\views\templates\hook\ApButton -->
                    <div class="AppButton button ApButton ">
                        <h4 class="title_block">
                            Watch our video to learn more about Team Cabinets
                        </h4>
                        <div class="sub-title-widget">You provide the space we'll provide the cabinets</div>
                        <span class="btn btn-link btn-lg">Contact Us</span>
                    </div>

                </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 col-sp-12 box-video ApColumn ">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApImage -->
                    <div id="image-form_3668901708829681" class="block img-bg-video ApImage">


                        <img class="img-fluid " src="{{ asset('') }}frontend/leo-kitchor-home1-video-img1.jpg" title="" alt="" style=" width:100%;
			height:auto" loading="lazy">

                    </div><!-- @file modules\appagebuilder\views\templates\hook\ApImage -->
                    <div id="image-form_7867552674966037" class="block box-icon-play ApImage">


                        <img class="img-fluid " src="{{ asset('') }}frontend/leo-kitchor-home1-icon-video.png" title="" alt="" style=" width:auto;
			height:auto" loading="lazy">

                    </div> <!-- @file modules\appagebuilder\views\templates\hook\ApVideo -->
                    <div id="video-form_7318792994790534" class="video" style="clear:both;">
                        <div style="text-align:center">
                            <iframe width="1000" height="562" style="max-width:100%; max-height: 100%" src="{{ asset('') }}frontend/qt8jJu7BsnM.html"></iframe> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        ap_list_functions.push(function() {
            $.stellar({
                horizontalScrolling: false
            });
        });

    </script>

    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
   @if ($doorstyles->isNotEmpty())

    <div class="wrapper">
        <div class="container">
            <div class="row box-padding130 banner-text-center banner5-home1 ApRow has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                <div class="col-12 banner-text ApColumn text-center">
                    {{-- <div class="sub-title-widget sub-title-ap-column">OUR FEATURED DOOR STYLES</div> --}}
                    <h4 class="title_block">OUR FEATURED DOOR STYLES</h4>
                </div>

                <div class="col-12">
                    {{-- Swiper Carousel Starts --}}
                    <div class="elementor-element elementor-element-f01d518 elementor-arrows-position-outside elementor-pagination-type-bullets elementor-pagination-position-outside elementor-widget elementor-widget-n-carousel" data-settings='{
                    "slides_to_show":"4",
                    {{-- "slides_to_scroll":"1", --}}
                    "autoplay":"yes",
                    "autoplay_speed":2000,
                    "speed":1000,
                    "infinite":"yes",
                    {{-- "arrows":"yes", --}}
                    "pagination":"bullets",
                    "slides_to_show_mobile":"2",
                    "slides_to_show_tablet":"2"
                }'>
                        <div class="elementor-widget-container">
                            <div class="e-n-carousel swiper" role="region" aria-roledescription="carousel" aria-label="Featured Door Styles" dir="ltr">
                                <div class="swiper-wrapper">
                                    {{-- Repeat this block for each slide --}}
                                    @foreach ($doorstyles as $door )
                                       <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset($door->image) }}" alt="Shaker Gray" width="258" height="316" />
                                                <h3 class="elementor-heading-title m-1">{{$door->product_label}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    {{-- <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Shaker_Gray.png" alt="Shaker Gray" width="258" height="316" />
                                                <h3 class="elementor-heading-title m-1">Shaker Gray</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Shaker_White.png" alt="Shaker White" width="258" height="316" />
                                                <h3 class="elementor-heading-title m-1">Shaker White</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Shaker_Espresso.png" alt="Shaker Espresso" width="258" height="316" />
                                                <h3 class="elementor-heading-title m-1">Shaker Espresso</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/blue-shaker-1.png" alt="blue shaker 1" width="258" height="316" />
                                                <h3 class="elementor-heading-title mt-1">blue shaker</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Charleston_White.png" alt="Charleston White" width="258" height="316" />
                                                <h3 class="elementor-heading-title mt-1">Charleston White</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/charcoal-black-1.jpeg" alt="charcoal black 1" width="258" height="316" />
                                                <h3 class="elementor-heading-title mt-1">charcoal black</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Cachew.jpg" alt="Cachew" width="258" height="316" />
                                                <h3 class="elementor-heading-title mt-1">Cachew</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="e-flex e-con-boxed e-con e-child">
                                            <div class="e-con-inner text-center">
                                                <img src="{{ asset('') }}frontend/Charleston_White.png" alt="Charleston White" width="258" height="316" />
                                                <h3 class="elementor-heading-title mt-1">Charleston White</h3>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- Add other slides below following same format --}}
                                </div>

                                {{-- <div class="elementor-swiper-button elementor-swiper-button-prev" role="button" tabindex="0" aria-label="Previous"> --}}
                                {{-- <svg class="e-font-icon-svg" viewBox="0 0 1000 1000"><path d="M646 125C629 125 613 133 604 142L308 442C296 454 292 471 292 487 292 504 296 521 308 533L604 854C617 867 629 875 646 875 663 875 679 871 692 858 704 846 713 829 713 812 713 796 708 779 692 767L438 487 692 225C700 217 708 204 708 187 708 171 704 154 692 142 675 129 663 125 646 125Z"></path></svg> --}}
                                {{-- </div> --}}
                                {{-- <div class="elementor-swiper-button elementor-swiper-button-next" role="button" tabindex="0" aria-label="Next"> --}}
                                {{-- <svg class="e-font-icon-svg" viewBox="0 0 1000 1000"><path d="M696 533C708 521 713 504 713 487 713 471 708 454 696 446L400 146C388 133 375 125 354 125 338 125 325 129 313 142 300 154 292 171 292 187 292 204 296 221 308 233L563 492 304 771C292 783 288 800 288 817 288 833 296 850 308 863 321 871 338 875 354 875 371 875 388 867 400 854L696 533Z"></path></svg> --}}
                                {{-- </div> --}}


                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    {{-- Swiper Carousel Ends --}}
                </div>
            </div>
        </div>
    </div>

    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper('.e-n-carousel', {
                slidesPerView: 4
                , slidesPerGroup: 1
                , spaceBetween: 20
                , loop: true
                , autoplay: {
                    delay: 3000
                    , disableOnInteraction: false
                , }
                , watchSlidesProgress: true
                , pagination: {
                    el: '.swiper-pagination',

                    clickable: true
                , }
                , breakpoints: {
                    0: { // from 0px width and up
                        slidesPerView: 1
                    , }
                    , 640: { // from 640px width and up (mobile landscape / small tablets)
                        slidesPerView: 2
                    , }
                    , 1024: { // from 1024px width and up (desktop)
                        slidesPerView: 4
                    , }
                , },

            });
        });

    </script>

    <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->




</section>



{{-- <footer class="page-footer">

                            <!-- Footer content -->

                        </footer> --}}


</section>



</div>



</div>



{{-- <div class="footer-top">
                <div class="container">
                    <div class="inner">
                        <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
                        <div class="row box-padding100 banner-text-center box-footer-top ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                            <div class="sub-title-widget sub-title-ap-group">You dream It, we design It</div>
                            <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                                <h4 class="title_block title-ap-column">We can build you the kitchen <br>of your dreams</h4>
                                <!-- @file modules\appagebuilder\views\templates\hook\ApButton -->
                                <div class="AppButton text-center button ApButton ">
                                    <a href="#/en/2-home">
                                        <span class="btn btn-link btn-lg">SCHEDULE A CHAT</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
</section>

<section id="wrapper">

    <div class="container">



        <div data-depth="2" class="breadcrumb-bg brcenter breadcrumb-full" style="background-image: url(https://cdn.shopify.com/s/files/1/0489/1171/2423/files/leo-kitchor-bg-breadcrum.jpg?v=1654305611); min-height:480px; ">
            <div class="container">
                <nav data-depth="2" class="breadcrumb hidden-sm-down">
                    <ol itemscope itemtype="http://schema.org/BreadcrumbList">


                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="#/en/">
                                <span itemprop="name">Home</span>
                            </a>
                            <meta itemprop="position" content="1">
                        </li>


                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="#/en/contact-us">
                                <span itemprop="name">Contact us</span>
                            </a>
                            <meta itemprop="position" content="2">
                        </li>


                    </ol>
                </nav>
            </div>
        </div>

        <div class="row" style="margin-top: 50px !important;">


            <div id="left-column" class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

                <div class="contact-rich">
                    <h4>Store information</h4>
                    <div class="block">
                        <div class="icon"><i class="material-icons">&#xE55F;</i></div>
                        <div class="data">
                            @if (!empty($settings) && !empty($settings->address))
                            <a style="font-size: 20px" href="{{ $settings->address_url }}" target="_blank" rel="noopener noreferrer">
                                {{ $settings->address }}
                            </a>

                            @endif
                        </div>
                    </div>
                    <hr />
                    <div class="block">
                        <div class="icon"><i class="material-icons">&#xE158;</i></div>
                        <div class="data email">
                            Email us:<br />
                        </div>
                        {{-- <script type="80c741ecc28488d3684c05df-text/javascript">
                            document.write(unescape('%3c%61%20%68%72%65%66%3d%22%6d%61%69%6c%74%6f%3a%64%65%6d%6f%40%64%65%6d%6f%2e%63%6f%6d%22%20%3e%64%65%6d%6f%40%64%65%6d%6f%2e%63%6f%6d%3c%2f%61%3e'))

                        </script> --}}
                    </div>
                </div>

            </div>



            <div id="content-wrapper" class=" js-content-wrapper left-column col-xs-12 col-sm-12 col-md-8 col-lg-9">



                <section id="main">




                    <section id="content" class="page-content card card-block">


                        <section class="contact-form">
                            <form action="{{ route('contact.send') }}" method="post" enctype="multipart/form-data">

                                @csrf

                                <section class="form-fields">

                                    <div class="form-group row">
                                        <div class="col-md-9 col-md-offset-3">
                                            <h3>Contact us</h3>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="id_contact">Subject</label>
                                        <div class="col-md-6">
                                            <select name="id_contact" id="id_contact" class="form-control form-control-select">
                                                <option value="2">Customer service</option>
                                                <option value="1">Webmaster</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="email">Email address</label>
                                        <div class="col-md-6">
                                            <input id="email" class="form-control" name="from" type="email" value="" placeholder="your@email.com">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="file-upload">Attachment</label>
                                        <div class="col-md-6">
                                            <input id="file-upload" type="file" name="fileUpload" class="filestyle" data-buttonText="Choose file">
                                        </div>
                                        <span class="col-md-3 form-control-comment">
                                            optional
                                        </span>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="contactform-message">Message</label>
                                        <div class="col-md-9">
                                            <textarea id="contactform-message" class="form-control" name="message" placeholder="How can we help?" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-md-3">

                                        </div>
                                    </div>

                                </section>

                                <footer class="form-footer text-sm-right">
                                    <style>
                                        input[name=url] {
                                            display: none !important;
                                        }

                                    </style>
                                    <input type="text" name="url" value="" />
                                    <input type="hidden" name="token" value="f07722f33d733368354e185855177415" />
                                    <input class="btn btn-outline" type="submit">
                                </footer>

                            </form>
                        </section>


                    </section>



                    <footer class="page-footer">

                        <!-- Footer content -->

                    </footer>


                </section>



            </div>



        </div>
    </div>

</section>


@endsection
