<footer id="footer" class="footer-container js-footer">





    <div class="footer-center">
        <div class="container">
            <div class="inner">
                <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
                <div class="row box-padding100 ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12 footer-logo ApColumn ">
                        <!-- @file modules\appagebuilder\views\templates\hook\ApGenCode -->

                        @if(!empty($settings) && !empty($settings->logo))
                        <a href="#"><img class="logo img-fluid" style="  max-width: 200px; max-height: 150px" src="{{ $settings->logo }}" alt="Leo Kitchor"></a>
                        @else
                        <a href="#"><img class="logo img-fluid" style="  max-width: 200px; max-height: 150px"  src="{{ asset('') }}frontend/Teamcabinets-Logo.jpg" alt="Leo Kitchor"></a>
                        @endif
                        <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                        <div class="block contact ApHtml">
                            <div class="block_content">
                                {{-- <p class="text-footer">Subscribe to receive inspiration,<br> ideas, and news in your inbox.</p> --}}
                                <div class="contact-tel " style="margin-top:16px !important"><i class="fa-solid fa-phone"></i>
                                    <div>
                                        @if (!empty($settings) && !empty($settings->phone))
                                        <a href="tel:{{ $settings->phone }}" data-mce-href="tel:{{ $settings->phone }}"> Call us: {{ $settings->phone }}</a>
                                        @endif
                                    </div>

                                </div>
                                <div class="contact-tel" style="margin-top: 16px;  !important;">
                                    <i class="fa-solid fa-location-dot"></i>

                                    <div>

                                        @if (!empty($settings) && !empty($settings->address))
                                        <a style="font-size: 20px" href="{{ $settings->address_url }}" target="_blank" rel="noopener noreferrer">
                                            {{ $settings->address }}
                                        </a>

                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div><!-- @file modules\appagebuilder\views\templates\hook\ApModule -->




                    </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                        <!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
                        <div class="block block-toggler ApLink ApBlockLink accordion_small_screen">
                            <div class="title clearfix" data-target="#footer-link-form_6082087264176545" data-toggle="collapse">
                                <h4 class="title_block">
                                    Company
                                </h4>
                                <span class="float-xs-right">
                                    <span class="navbar-toggler collapse-icons">
                                        <i class="material-icons add"></i>
                                        <i class="material-icons remove"></i>
                                    </span>
                                </span>
                            </div>

                            <ul class="collapse" id="footer-link-form_6082087264176545">
                                {{-- <ul class="nav navbar-nav megamenu horizontal"> --}}
                                @foreach($pages as $page)
                                <li data-menu-type="controller" class="nav-item parent dropdown leo-1 active">
                                    @if(is_null($page->parent) && $page->children->isEmpty())


                                    <a class="nav-link  has-category" href="{{ route('cms.page', ['slug' => $page->slug]) }}" target="_self">

                                        <span class="menu-title">{{ $page->title }}</span>

                                    </a>
                                    @endif

                                </li>
                                @endforeach
                            </ul>

                        </div>

                    </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                    {{-- <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                                <!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
                                <div class="block block-toggler ApLink ApBlockLink accordion_small_screen">
                                    <div class="title clearfix" data-target="#footer-link-form_2893883699003997" data-toggle="collapse">
                                        <h4 class="title_block">
                                            Explore
                                        </h4>
                                        <span class="float-xs-right">
                                            <span class="navbar-toggler collapse-icons">
                                                <i class="material-icons add"></i>
                                                <i class="material-icons remove"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <ul class="collapse" id="footer-link-form_2893883699003997">
                                        <li><a href="#/en/address" target="_self">Kitchen Cabinets</a></li>
                                        <li><a href="#/en/contact-us" target="_self">Counter Tops</a></li>
                                        <li><a href="#/en/3-livspace-select" target="_self">Bathroom Vanities</a></li>
                                        <li><a href="#/en/6-accessories" target="_self">Vanity Tops</a></li>
                                    </ul>
                                </div>

                            </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn --> --}}
                    {{-- <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                                <!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
                                <div class="block block-toggler ApLink ApBlockLink accordion_small_screen">
                                    <div class="title clearfix" data-target="#footer-link-form_6758423390316087" data-toggle="collapse">
                                        <h4 class="title_block">
                                            QUICK LINKS
                                        </h4>
                                        <span class="float-xs-right">
                                            <span class="navbar-toggler collapse-icons">
                                                <i class="material-icons add"></i>
                                                <i class="material-icons remove"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <ul class="collapse" id="footer-link-form_6758423390316087">
                                        <li><a href="#/en/index.php?controller=getfile" target="_self">FAQ </a></li>
                                        <li><a href="#/en/blog.html" target="_self">Blog</a></li>
                                        <li><a href="#/en/stores" target="_self">Design &amp; Quote</a></li>
                                        <li><a href="#/en/order-confirmation" target="_self">Warranty</a></li>
                                        <li><a href="#/en/sitemap" target="_self">Trade Partners</a></li>
                                        <li><a href="#/en/supplier/2-accessories-supplier" target="_self">Design </a></li>
                                    </ul>
                                </div>

                            </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn --> --}}
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 col-sp-12 footer-email ApColumn ">
                        <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
                        <div class="block_newsletter block" id="blockEmailSubscription_displayFooter">
                            <h3 class="title_block" id="block-newsletter-label">subscribe us</h3>
                            <div class="block_content">
                                <form action="#/en/home-1.html#blockEmailSubscription_displayFooter" method="post">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p>Subscribe to receive inspiration, ideas, and news in your inbox.</p>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="input-wrapper">
                                                <input name="email" type="email" value="" placeholder="Email address..." aria-labelledby="block-newsletter-label" required="">
                                                <i class="fa fa-envelope"></i>

                                                <button class="btn btn-outline float-xs-right" name="submitNewsletter" type="submit" value="Subscribe">
                                                    <span>Subscribe</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="blockHookName" value="displayFooter">
                                            <input type="hidden" name="action" value="0">
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="col-xs-12 mt-5">

                                            <div class="block-social" style="margin-top: 30px !important">
                                                <ul>
                                                    @if (!empty($settings) && !empty($settings->facebook))
                                                    <li class="facebook">
                                                        <a href="{{ $settings->facebook }}" title="Facebook" target="_blank" rel="noopener noreferrer">
                                                            <span>Facebook</span>
                                                        </a>
                                                    </li>
                                                    @endif
                                                    @if (!empty($settings) && !empty($settings->twitter))
                                                    <li class="twitter"><a href="{{$settings->twitter  }}" title="Twitter" target="_blank" rel="noopener noreferrer"><span>Twitter</span></a></li>
                                                    @endif
                                                    @if (!empty($settings) && !empty($settings->youtube))
                                                    <li class="youtube"><a href="{{ $settings->youtube }}" title="YouTube" target="_blank" rel="noopener noreferrer"><span>YouTube</span></a></li>
                                                    @endif
                                                    @if (!empty($settings) && !empty($settings->instagram))

                                                    <li class=""><a href="{{ $settings->instagram }}" title="Pinterest" target="_blank" rel="noopener noreferrer"><span>Pinterest</span></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer-bottom">
        <div class="container">
            <div class="inner">
                <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
                <div class="row text-center box-padding30 footer-copy  ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                    <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12  ApColumn ">
                        <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                        <div class="block ApHtml">
                            <div class="block_content">
                                <div>© Copyright 2022 <a href="#/en/index.php" data-mce-href="index.php">kitchen</a>. All rights reserved.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
