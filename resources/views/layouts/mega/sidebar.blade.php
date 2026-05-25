<div class="iconsidebar-menu iconbar-second-close" id="pn-admin-sidebar" aria-label="Admin modules">
   <div class="sidebar">
      <ul class="iconMenu-bar custom-scrollbar">
         <li>
            <a class="bar-icons" href="#">
               <!--img(src='{{route('/')}}/assets/images/menu/home.png' alt='')--><i
                  class="pe-7s-home"></i><span>General </span>
            </a>
            <ul class="iconbar-mainmenu custom-scrollbar">
               <li class="iconbar-header">Dashboard</li>
               <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
               <li><a href="{{ route('profile') }}">My Profile</a></li>
               <li><a href="{{ route('change_password') }}">Change Password</a></li>
            </ul>
         </li>
         <li>
            <a class="bar-icons" href="#"><i class="pe-7s-users"></i><span>Users</span></a>
            <ul class="iconbar-mainmenu custom-scrollbar">
               <li class="iconbar-header">Users</li>
               <li><a href="{{ route('users.create') }}">Create User</a></li>
               <li><a href="{{ route('users.index') }}">Users List</a></li>
               {{-- <li><a href="{{ route('users.show') }}">Deleted Users List</a></li> --}}
            </ul>
         </li>
         <li>
            <a class="bar-icons" href="#"><i class="pe-7s-menu"></i><span>Tenants</span></a>
            <ul class="iconbar-mainmenu custom-scrollbar">
               <li class="iconbar-header">Tenants</li>
               <li><a href="{{ route('registeration') }}" target="_blank" rel="noopener">Register New Tenant</a></li>
               <li><a href="{{ route('tenant_index') }}">Tenants List</a></li>
               {{-- <li><a href="{{ route('tenant_deleted_Tenants_list') }}">Deleted Tenants List</a></li> --}}
            </ul>
         </li>
         <li>
            <a class="bar-icons" href="#"><i class="pe-7s-network"></i><span>Roles</span></a>
            <ul class="iconbar-mainmenu custom-scrollbar">
               <li class="iconbar-header">Roles</li>
               <li><a href="{{ route('roles.create') }}">Create Role</a></li>
               <li><a href="{{ route('roles.index') }}">Roles List</a></li>
               {{-- <li><a href="{{ route('Role_deleted_Roles_list') }}">Deleted Roles List</a></li> --}}
            </ul>
         </li>
         {{-- <li>
            <a class="bar-icons" href="#"><i class="pe-7s-network"></i><span>Pages</span></a>
            <ul class="iconbar-mainmenu custom-scrollbar">
               <li class="iconbar-header">Pages</li>
               <li><a href="{{ route('pages.create') }}">Create Page</a></li>
               <li><a href="{{ route('pages.index') }}">Pages List</a></li>
               {{-- <li><a href="{{ route('Role_deleted_Roles_list') }}">Deleted Roles List</a></li> --}}
            {{-- </ul> --}}
         {{-- </li>  --}}
      </ul>
   </div>
</div>
