<div class="iconsidebar-menu iconbar-mainmenu-close">
    <div class="sidebar">
       <ul class="iconMenu-bar custom-scrollbar">
          <li>
             <a class="bar-icons" href="javascript:;">
                <!--img(src='{{route('/')}}/assets/images/menu/home.png' alt='')--><i class="pe-7s-home"></i><span>Home    </span>
             </a>
             <ul class="iconbar-mainmenu custom-scrollbar">
                <li class="iconbar-header">Dashboard</li>
                <li><a href="{{ route('tenant_dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('tenant_profile_step_1') }}">My Profile</a></li>
                <li><a href="{{ route('tenant_profile_step_2') }}">Change Password</a></li>
                <li class="iconbar-header sub-header">Widgets</li>
                <li><a href="javascript:;">General widget</a></li>
                <li><a href="javascript:;">Chart widget</a></li>
             </ul>
          </li>
          <li>
             <a class="bar-icons" href="javascript:;"><i class="pe-7s-portfolio"></i><span>Orders</span></a>

             <ul class="iconbar-mainmenu custom-scrollbar">
                <li><a href="{{ route('tenant_order_create') }}">Create Order</a></li>
                <li><a href="{{ route('tenant_order_list') }}">My Orders List</a></li>
                <li><a href="{{ route('tenant_quotes_index') }}">My Quotes List</a></li>
                <li><a href="{{ route('tenant_shipping_quotes_index') }}">My Shipping Quotes List</a></li>
                <li><a href="{{ route('tenant_stock_check_index') }}">My Stock Check Requests</a></li>
                <li><a href="javascript:;">Claims</a></li>
                <li><a href="javascript:;">Downloads</a></li>
             </ul>{{-- <ul class="iconbar-mainmenu custom-scrollbar">
                <li><a href="{{ route('tenant_order_create') }}">Create Order</a></li>
                <li><a href="{{ route('tenant_order_list') }}">My Orders List</a></li>
                <li><a href="{{ route('tenant_quotes_index') }}">My Quotes List</a></li>
                <li><a href="{{ route('tenant_shipping_quotes_index') }}">My Shipping Quotes List</a></li>
                <li><a href="{{ route('tenant_stock_check_index') }}">My Stock Check Requests List</a></li>
                <li><a href="javascript:;">Claims</a></li>
                <li><a href="javascript:;">Downloads</a></li>
             </ul> --}}
          </li>
          <li>
             <span class="badge rounded-pill badge-danger">
                {{ \App\Models\User::where('parent_id', auth()->id())->count() ?? 0}}
            </span><a class="bar-icons" href="javascript:;"><i class="pe-7s-diamond"></i><span>Affliates</span></a>
             <ul class="iconbar-mainmenu custom-scrollbar">
                <li class="iconbar-header">Users</li>
                <li><a href="{{ route('tenant_user_child_create') }}">Create Affliate</a></li>
                <li><a href="{{ route('tenant_user_child_index') }}">Affliates List</a></li>
             </ul>
          </li>
          <li>
             <a class="bar-icons" href="javascript:;"><i class="pe-7s-note2"></i><span>Uploads</span></a>
             <ul class="iconbar-mainmenu custom-scrollbar">
                <li class="iconbar-header">My Uploads</li>
                <li><a href="javascript:;">Add Uploads</a></li>
                <li><a href="javascript:;">Uploads List</a></li>
             </ul>
          </li>
          <li>
             <a class="bar-icons" href="javascript:;"><i class="pe-7s-id"></i><span class="text-sm">Commission Report</span></a>
             <ul class="iconbar-mainmenu custom-scrollbar">
                <li class="iconbar-header">Commission Report</li>
                <li><a href="javascript:;">Commission Report</a></li>
             </ul>
          </li>
       </ul>
    </div>
 </div>
