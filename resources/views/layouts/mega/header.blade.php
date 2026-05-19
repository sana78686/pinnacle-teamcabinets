<div class="page-main-header mega-menu-header">
   <div class="main-header-right">
      <div class="text-center main-header-left">
         <div class="logo-wrapper"><a href="{{route('/')}}">

            @if (auth()->user()->logo)

            <img src="{{ dynamic_url(auth()->user()->logo) }}" alt="" style="height: 70px" class="p-2"/>
            @else

            <img src="{{ dynamic_url('assets/logo/pinnacle.png') }}" alt=""  style="height: 90px" class="p-1"/>
            @endif
        </a></div>
      </div>
      <div class="mobile-sidebar d-none">
         <div class="flex-grow-1 text-end switch-sm">
            <label class="switch ms-3"><i class="font-primary" id="sidebar-toggle" data-feather="align-center"></i></label>
         </div>
      </div>
      <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar">               </i></div>
      <div class="nav-right col pull-right right-menu">
         <!-- vertical menu start-->
         <div class="mega-menu-header">
            <div class="vertical-mobile-sidebar"><i class="sidebar-toggle-btn" data-feather="align-right"></i></div>
            <div class="vertical-menu-main">
               <nav id="main-nav">
                  <!-- Sample menu definition-->
                  <ul class="sm pixelstrap" id="main-menu">
                     <li>
                        <div class="text-end mobile-back">Back<i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                     </li>
                     <li>
                        <a href="#"><i class="mt-0" data-feather="command"></i>Mega menu</a>
                        <ul class="mega-menu">
                           <li>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-xl-3 list-unstyled">
                                       <div>
                                          <p class="title">Builder [BS4+] <span class="badge badge-success ms-2">New</span></p>
                                       </div>
                                       <div><a href="javascript:;"> Page Builder </a></div>
                                       <div><a href="javascript:;"> Form Builder</a></div>
                                       <div><a href="javascript:;"> Button Builder </a></div>
                                       <div class="mt-3">
                                          <p class="title">Accordion</p>
                                       </div>
                                       <div>
                                          <div class="default-according style-1" id="accordionoc">
                                             <div class="card">
                                                <div>
                                                   <h5 class="mb-0">
                                                      <button class="p-2 btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseicon" aria-expanded="true" aria-controls="collapseicon">Accordion 1</button>
                                                   </h5>
                                                </div>
                                                <div class="collapse show" id="collapseicon" data-parent="#accordionoc">
                                                   <div class="p-2 card-body">Anim pariatur cliche reprehenderit.</div>
                                                </div>
                                             </div>
                                             <div class="card">
                                                <div>
                                                   <h5 class="mb-0">
                                                      <button class="p-1 btn btn-link text-muted collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon1" aria-expanded="false" aria-controls="collapseicon1">Accordion 2</button>
                                                   </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon1" data-parent="#accordionoc">
                                                   <div class="p-2 card-body">Anim pariatur cliche reprehenderit.</div>
                                                </div>
                                             </div>
                                             <div class="card">
                                                <div>
                                                   <h5 class="mb-0">
                                                      <button class="p-1 btn btn-link text-muted collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="false" aria-controls="collapseicon2">Accordion 3</button>
                                                   </h5>
                                                </div>
                                                <div class="collapse" id="collapseicon2" data-parent="#accordionoc">
                                                   <div class="p-2 card-body">Anim pariatur cliche reprehenderit.</div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-2 list-unstyled xs-mt">
                                       <div>
                                          <p class="title">Drill Down</p>
                                       </div>
                                       <div class="drilldown">
                                          <div class="drilldown-container">
                                             <div class="drilldown-root">
                                                <div><a class="mt-0 font-primary" href="#">First Level Menu</a></div>
                                                <div>
                                                   <a class="ps-0" href="#"><i class="icon-support"></i>  Base <span class="float-end">→</span></a>
                                                   <div class="drilldown-sub">
                                                      <div class="drilldown-back"><a class="font-primary f-w-100" href="#"><span>←</span> Second Level Menu</a></div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  State color</a></div>
                                                      <div>
                                                         <a href="#"><i class="fa fa-angle-right"></i>  Tabs <span class="float-end">→</span></a>
                                                         <div class="drilldown-sub">
                                                            <div class="drilldown-back"><a class="font-primary f-w-100" href="#"><span>←</span> Third Level Menu</a></div>
                                                            <div><a href="#"><i class="fa fa-angle-right"></i>  Bootstrap Tabs</a></div>
                                                            <div><a href="#"><i class="fa fa-angle-right"></i>  Line Tabs</a></div>
                                                         </div>
                                                      </div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  Typography</a></div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  Progress</a></div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  Model</a></div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  Alert</a></div>
                                                      <div><a href="#"><i class="fa fa-angle-right"></i>  Popover</a></div>
                                                   </div>
                                                </div>
                                                <div><a href="#"><i class="icon-dropbox"></i>  Advanced</a></div>
                                                <div><a href="#"><i class="fa fa-spin fa-spinner"></i>  Animation</a></div>
                                                <div><a href="#"><i class="icon-package"></i>  Icons</a></div>
                                                <div><a href="#"><i class="icon-cloud-down"></i>  Buttons</a></div>
                                                <div><a href="#"><i class="icon-notepad"></i>  Forms</a></div>
                                                <div><a class="mb-0" href="#"><i class="icon-harddrives"></i>  Tables</a></div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="clearfix col-xl-3 galleria-list lg-mt">
                                       <div>
                                          <p class="title">Galleria</p>
                                       </div>
                                       <div>
                                          <div class="galleria row">
                                             <div class="col-6">
                                                <a href="javascript:void(0)"><img src="{{route('/')}}/assets/images/slider/1.jpg" alt=""></a>
                                                <h4 class="username text-ellipsis">Airi Satou<small>Algerian</small></h4>
                                             </div>
                                             <div class="col-6">
                                                <a href="javascript:void(0)"><img src="{{route('/')}}/assets/images/slider/2.jpg" alt=""></a>
                                                <h4 class="username text-ellipsis">Fiona Green<small>Korean</small></h4>
                                             </div>
                                             <div class="mb-0 col-6">
                                                <a href="javascript:void(0)"><img src="{{route('/')}}/assets/images/slider/3.jpg" alt=""></a>
                                                <h4 class="mb-0 username text-ellipsis">Gavin Joyce<small>Indian</small></h4>
                                             </div>
                                             <div class="mb-0 col-6">
                                                <a href="javascript:void(0)"><img src="{{route('/')}}/assets/images/slider/4.jpg" alt=""></a>
                                                <h4 class="mb-0 username text-ellipsis">Howard Hatfield<small>Japanese</small></h4>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-xl-4 list-unstyled custom-nav-img lg-mt">
                                       <div>
                                          <p class="title">Contact Form</p>
                                       </div>
                                       <div>
                                          <form class="theme-form">
                                             <div class="form-group">
                                                <label class="pt-0 col-form-label"><i class="icon-user pe-2"></i>                                                                        Your Name</label>
                                                <input class="form-control" type="text" placeholder="Enter your name">
                                             </div>
                                             <div class="form-group">
                                                <label class="col-form-label"><i class="icon-email pe-2"></i>Your Email</label>
                                                <input class="form-control" type="email" placeholder="Enter your emailid">
                                             </div>
                                             <div class="form-group">
                                                <label class="col-form-label"><i class="icon-comment pe-2"></i>Your Message</label>
                                                <textarea class="form-control" placeholder="Enter your message" rows="2"></textarea>
                                             </div>
                                             <div class="mb-0 form-group">
                                                <button class="btn btn-pill btn-primary">Send</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </li>
                        </ul>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
         <!-- vertical menu ends-->
         <ul class="nav-menus">
            <li>
               <form class="form-inline search-form" action="#" method="get">
                  <div class="form-group">
                     <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                           <input class="Typeahead-input form-control-plaintext" id="demo-input" type="text" name="q" placeholder="Search Your Product...">
                           <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div>
                           <span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
                        </div>
                        <div class="Typeahead-menu"></div>
                     </div>
                  </div>
               </form>
            </li>
            <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
            {{-- <li class="onhover-dropdown">
               <img class="img-fluid img-shadow-warning" src="{{route('/')}}/assets/images/dashboard/bookmark.png" alt="">
               <div class="onhover-show-div bookmark-flip">
                  <div class="flip-card">
                     <div class="flip-card-inner">
                        <div class="front">
                           <ul class="droplet-dropdown bookmark-dropdown">
                              <li class="text-center gradient-primary">
                                 <h5 class="f-w-700">Bookmark</h5>
                                 <span>Bookmark Icon With Grid</span>
                              </li>
                              <li>
                                 <div class="row">
                                    <div class="text-center col-4"><i data-feather="file-text"></i></div>
                                    <div class="text-center col-4"><i data-feather="activity"></i></div>
                                    <div class="text-center col-4"><i data-feather="users"></i></div>
                                    <div class="text-center col-4"><i data-feather="clipboard"></i></div>
                                    <div class="text-center col-4"><i data-feather="anchor"></i></div>
                                    <div class="text-center col-4"><i data-feather="settings"></i></div>
                                 </div>
                              </li>
                              <li class="text-center">
                                 <button class="flip-btn" id="flip-btn">Add New Bookmark</button>
                              </li>
                           </ul>
                        </div>
                        <div class="back">
                           <ul>
                              <li>
                                 <div class="droplet-dropdown bookmark-dropdown flip-back-content">
                                    <input type="text" placeholder="search...">
                                 </div>
                              </li>
                              <li>
                                 <button class="d-block flip-back" id="flip-back">Back</button>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </li>
            <li class="onhover-dropdown">
               <img class="img-fluid img-shadow-secondary" src="{{route('/')}}/assets/images/dashboard/like.png" alt="">
               <ul class="onhover-show-div droplet-dropdown">
                  <li class="text-center gradient-primary">
                     <h5 class="f-w-700">Grid Dashboard</h5>
                     <span>Easy Grid inside dropdown</span>
                  </li>
                  <li>
                     <div class="row">
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="file-text"></i><span class="d-block">Content</span></div>
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="activity"></i><span class="d-block">Activity</span></div>
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="users"></i><span class="d-block">Contacts</span></div>
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="clipboard"></i><span class="d-block">Reports</span></div>
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="anchor"></i><span class="d-block">Automation</span></div>
                        <div class="col-sm-4 col-6 droplet-main"><i data-feather="settings"></i><span class="d-block">Settings</span></div>
                     </div>
                  </li>
                  <li class="text-center">
                     <button class="btn btn-primary btn-air-primary">Follows Up</button>
                  </li>
               </ul>
            </li>
            <li class="onhover-dropdown">
               <img class="img-fluid img-shadow-warning" src="{{route('/')}}/assets/images/dashboard/notification.png" alt="">
               <ul class="onhover-show-div notification-dropdown">
                  <li class="gradient-primary">
                     <h5 class="f-w-700">Notifications</h5>
                     <span>You have 6 unread messages</span>
                  </li>
                  <li>
                     <div class="d-flex">
                        <div class="notification-icons bg-success me-3"><i class="mt-0" data-feather="thumbs-up"></i></div>
                        <div class="flex-grow-1">
                           <h6>Someone Likes Your Posts</h6>
                           <p class="mb-0"> 2 Hours Ago</p>
                        </div>
                     </div>
                  </li>
                  <li class="pt-0">
                     <div class="d-flex">
                        <div class="notification-icons bg-info me-3"><i class="mt-0" data-feather="message-circle"></i></div>
                        <div class="flex-grow-1">
                           <h6>3 New Comments</h6>
                           <p class="mb-0"> 1 Hours Ago</p>
                        </div>
                     </div>
                  </li>
                  <li class="bg-light txt-dark"><a href="#">All </a> notification</li>
               </ul>
            </li> --}}
            {{-- <li><a class="right_side_toggle" href="#"><img class="img-fluid img-shadow-success" src="{{route('/')}}/assets/images/dashboard/chat.png" alt=""></a></li> --}}
            <li class="onhover-dropdown">
               <span class="d-flex user-header">
                <div
                    style="width: 80px; height: 50px; background-color: #d6eaff; color: #004085; display: flex; align-items: center; justify-content: center; border-radius: 12px; border: 2px solid #b8daff; font-size: 26px; font-weight: bold;">
                    <em>{{ auth()->user()->initials ?? 'P' }}</em>
                </div>
            </span>
               <ul class="onhover-show-div profile-dropdown">
                  <li class="gradient-primary">
                        <h5 class="mb-0 f-w-600">{{ auth()->user()->name ?? 'Pinnacle User' }}</h5>
                        <span>{{ auth()->user()->getRoleNames()->implode(', ') }}</span>
                    </li>
                    <li><a href="{{ route('profile') }}" class="text-black"><i data-feather="user">
                            </i>{{ __('Profile') }}</a></li>
                    <li><i data-feather="settings"> </i>{{ __('Setting') }} </li>
               </ul>
            </li>

            <li>
                <form action="{{ route('tenant_logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white border-0 "><i data-feather="log-out"></i></button>
                </form>
            </li>
         </ul>
         <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
      </div>
      <script id="result-template" type="text/x-handlebars-template">
         <div class="ProfileCard u-cf">
         <div class="ProfileCard-avatar"><i class="pe-7s-home"></i></div>
         <div class="ProfileCard-details">

         </div>
         </div>
      </script>
      <script id="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
   </div>
</div>
