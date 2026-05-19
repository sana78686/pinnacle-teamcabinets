<header id="header">
    @if(!$settingsCompleted)
        <!-- Trigger the modal automatically -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('settingsModal'));
                myModal.show();
            });
        </script>

        <!-- Modal -->
        <div class="modal fade  center" style="opacity: 3;padding: 200px; backdrop-filter: blur(8px);
    background-color: rgba(0, 0, 0, 0.3);
" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-3">
                    <div class="modal-header bg-warning text-dark border-0 rounded-top-3">
                        <h5 class="modal-title fw-bold p-5" id="settingsModalLabel">
                            <i class="bi bi-gear-fill me-2"></i> Settings Required
                        </h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body bg-light text-center py-4">
                        <p class="fs-5 mb-0">
                            ⚙️ Please complete your <strong>settings</strong> before proceeding.
                        </p>
                    </div>
                    <div class="modal-footer bg-light border-0 d-flex justify-content-center">
                        <a href="{{ route('tenant_site_setting') }}" class="btn btn-primary px-4">
                            <i class="bi bi-sliders me-1"></i> Go to Settings
                        </a>
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif




     <div class="header-banner">
         <div class="container">
             <div class="inner"></div>
         </div>
     </div>



     <nav class="header-nav">
         <div class="topnav">
             <div class="container">
                 <div class="inner"></div>
             </div>
         </div>
         <div class="bottomnav">
             <div class="container">
                 <div class="inner">
                     <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
                     <div class="row header-bottomnav ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                         <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                         <div class="col-xl-4 col-lg-2 col-md-12 col-sm-12 col-xs-12 col-sp-12 bottomnav-left hidden-md-down ApColumn ">
                             <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->

                             <div class="block-social">
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


                         </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                         <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 col-xs-12 col-sp-12 bottomnav-right ApColumn ">
                             <!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
                             <div class="block ApHtml">
                                 <div class="block_content">
                                     <div>
                                         @if (!empty($settings) && !empty($settings->email))
                                         <a href="mailto:{{ $settings->email }}" data-mce-href="mailto:{{ $settings->email }}" data-mce-selected="inline-boundary"><i class="fa-solid fa-envelope"></i>﻿ Email: {{ $settings->email }}</a>
                                         @endif
                                     </div>
                                     <div>
                                         @if (!empty($settings) && !empty($settings->phone))
                                         <a href="tel:{{ $settings->phone }}" data-mce-href="tel:{{ $settings->phone }}"><i class="fa-solid fa-phone"></i> Call us: {{ $settings->phone }}</a>
                                         @endif
                                     </div>
                                     {{-- <div class="button5-banner">Book appointment</div> --}}
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </nav>



     <div class="header-top">
         <div class="container">
             <div class="inner">
                 <!-- @file modules\appagebuilder\views\templates\hook\ApRow -->
                 <div class="row header-menu ApRow  has-bg bg-boxed" style="background: no-repeat;" data-bg_data=" no-repeat">
                     <!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                     <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 col-sp-12 col-logo ApColumn ">
                         <!-- @file modules\appagebuilder\views\templates\hook\ApGenCode -->
                         @if(!empty($settings) && !empty($settings->logo))
                         <a href="#"><img class="logo img-fluid" style="    width: auto; max-height: 80px;" src="{{ asset($settings->logo) }}" alt="Leo Kitchor"></a>
                         @else
                         <a href="#"><img class="logo img-fluid" src="{{ asset('') }}frontend/Teamcabinets-Logo.jpg" alt="Leo Kitchor"></a>
                         @endif


                     </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                     <div class="col-xl-8 col-lg-8 col-md-2 col-sm-2 col-xs-2 col-sp-2 col-menu ApColumn ">
                         <!-- @file modules\appagebuilder\views\templates\hook\ApSlideShow -->
                         <div id="memgamenu-form_1947357956302447" class="ApMegamenu">

                             <nav data-megamenu-id="1947357956302447" class="leo-megamenu cavas_menu navbar navbar-default enable-canvas " role="navigation">
                                 <!-- Brand and toggle get grouped for better mobile display -->
                                 <div class="navbar-header">
                                     <button type="button" class="navbar-toggler hidden-lg-up" data-toggle="collapse" data-target=".megamenu-off-canvas-1947357956302447">
                                         <span class="sr-only">Toggle navigation</span>
                                         ☰
                                         <!--
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            -->
                                     </button>
                                 </div>



                                 <!-- Collect the nav links, forms, and other content for toggling -->
                                 <div class="leo-top-menu collapse navbar-toggleable-md megamenu-off-canvas megamenu-off-canvas-1947357956302447" id="megaMenu1947">
                                     <ul class="nav navbar-nav megamenu horizontal">
                                         @foreach($pages as $page)
                                         <li data-menu-type="controller" class="nav-item parent dropdown leo-1 active">
                                             @if(is_null($page->parent) && $page->children->isEmpty())


                                             <a class="nav-link" href="{{ route('cms.page', ['slug' => $page->slug]) }}" target="_self">

                                                 <span class="menu-title">{{ $page->title }}</span>

                                             </a>

                                             @elseif(is_null($page->parent))
                                             <a class="nav-link" data-toggle="dropdown" target="_self">


                                                 <span class="menu-title">{{ $page->title }}</span>

                                             </a>
                                             @endif
                                             <b class="caret"></b>
                                             @if($page->children->count())
                                             <div class="dropdown-menu level1">
                                                 <div class="dropdown-menu-inner">
                                                     <div class="row">
                                                         <div class="col-sm-12 mega-col" data-colwidth="12" data-type="menu">
                                                             <div class="inner">
                                                                 <ul>
                                                                     @foreach($page->children as $child)


                                                                     <li data-menu-type="url" class="nav-item    leo-1">
                                                                         <a class="nav-link" href="{{ route('cms.page', ['slug' => $page->slug]) }}" target="_self">

                                                                             <span class="menu-title">{{ $child->title }}</span>

                                                                         </a>

                                                                     </li>

                                                                     @endforeach

                                                                 </ul>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             @endif
                                         </li>
                                         @endforeach
                                     </ul>
                                 </div>
                             </nav>
                             <script type="text/javascript">
                                 list_menu_tmp.id = '1947357956302447';
                                 list_menu_tmp.type = 'horizontal';
                                 list_menu_tmp.show_cavas = 1;
                                 list_menu_tmp.list_tab = list_tab;
                                 list_menu.push(list_menu_tmp);
                                 list_menu_tmp = {};
                                 list_tab = {};

                             </script>

                         </div>

                     </div><!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
                     <div class="col-xl-2 col-lg-2 col-md-10 col-sm-10 col-xs-10 col-sp-10 col-info ApColumn ">
                         <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
                         <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->


                         <!-- Block search module -->
                         <div id="leo_search_block_top" class="block exclusive">
                             <h4 class="title_block">Search here...</h4>
                             <form method="get" action="#en/index.php?controller=productsearch" id="leosearchtopbox" data-label-suggestion="Suggestion" data-search-for="Search for" data-in-category="in category" data-products-for="Products For" data-label-products="Products" data-view-all="View all">
                                 <input type="hidden" name="fc" value="module">
                                 <input type="hidden" name="module" value="leoproductsearch">
                                 <input type="hidden" name="controller" value="productsearch">
                                 <input type="hidden" name="txt_not_found" value="No products found">
                                 <input type="hidden" name="leoproductsearch_static_token" value="a62e6788a2c7f7d47b6a046686c497d8">
                                 <label>Search products:</label>
                                 <div class="block_content clearfix leoproductsearch-content">
                                     <div class="leoproductsearch-result">
                                         <div class="leoproductsearch-loading cssload-speeding-wheel"></div>
                                         <input class="search_query form-control grey ac_input" type="text" id="leo_search_query_top" name="search_query" data-content="" value="" placeholder="Search" autocomplete="off">
                                         <div class="ac_results lps_results" style="width: 303px; display: none;"></div>
                                     </div>
                                     <button type="submit" id="leo_search_top_button" class="btn btn-default button button-small"><span><i class="material-icons search">search</i></span></button>
                                 </div>
                             </form>
                         </div>
                         <script type="text/javascript">
                             var blocksearch_type = 'top';

                         </script>
                         <!-- /Block search module -->
                         <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
                         <!-- Block languages module -->
                        <div id="leo_block_top" class="popup-over">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="popup-title">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                             <div class="popup-content">
                                 <div class="row">

                                     <div class="col-xs-7">
                                         <div class="useinfo-selector">
                                             <ul class="user-info">
                                                 <li>
                                                     <a class="signin leo-quicklogin" data-enable-sociallogin="enable" data-type="popup" data-layout="login" href="/login" title="Log in to your customer account" rel="nofollow">
                                                         <i class="material-icons"></i>
                                                         <span>Login in</span>
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a class="myacount" href="/registration" title="My account" rel="nofollow">
                                                         <i class="material-icons">person_add</i>
                                                         <span>Register</span>
                                                     </a>
                                                 </li>
                                                 {{-- <li>
                                                     <a class="checkout" href="#en/cart?action=show" title="Checkout" rel="nofollow">
                                                         <i class="material-icons"></i>
                                                         <span>Checkout</span>
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a class="ap-btn-wishlist dropdown-item" href="#en/module/leofeature/mywishlist" title="Wishlist" rel="nofollow">
                                                         <i class="material-icons"></i>
                                                         <span>Wishlist</span>
                                                         <span class="ap-total-wishlist ap-total">0</span>
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a class="ap-btn-compare dropdown-item" href="#en/module/leofeature/productscompare" title="Compare" rel="nofollow">
                                                         <i class="material-icons"></i>
                                                         <span>Compare</span>
                                                         <span class="ap-total-compare ap-total">0</span>
                                                     </a>
                                                 </li> --}}
                                             </ul>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div>
                         <!-- /Block languages module -->
                         <!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
                         {{-- <div id="_desktop_cart">
                             <div class="blockcart cart-preview leo-blockcart show-leo-loading inactive" data-refresh-url="//demo74.leotheme.com/prestashop/leo_kitchor_demo/en/module/ps_shoppingcart/ajax">
                                 <div class="header">
                                     <i class="fa-solid fa-shopping-bag"></i>
                                     <span class="cart-products-count">0</span>
                                 </div>
                                 <div class="cssload-piano" style="display: none;">
                                     <div class="cssload-rect1"></div>
                                     <div class="cssload-rect2"></div>
                                     <div class="cssload-rect3"></div>
                                 </div>
                             </div>
                             <div class="leo-dropdown-cart defaultcart dropdown"></div>
                         </div> --}}

                     </div>
                 </div>
                 <a href="#en/blog.html" class="hookDisplayTop link-top-blog"><i class="material-icons"></i><span class="hidden-sm-down">Blog</span></a>
             </div>
         </div>
     </div>




 </header>
