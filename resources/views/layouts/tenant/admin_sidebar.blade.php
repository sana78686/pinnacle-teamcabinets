<div class="vertical-menu-main tc-tenant-nav">
    <nav id="main-nav" aria-label="Main navigation">
        <ul class="sm pixelstrap tc-nav-menu" id="main-menu">
            <li class="tc-nav-mobile-back">
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            <li class="{{ request()->routeIs('tenant_dashboard') ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_dashboard') }}">
                    <i data-feather="home"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_user_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="users"></i><span>Users</span></a>
                <ul>
                    <li><a href="{{ route('tenant_user_create') }}">Create User</a></li>
                    <li><a href="{{ route('tenant_user_index') }}">Users List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_role_*', 'tenant_manage_role_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="shield"></i><span>Roles</span></a>
                <ul>
                    <li><a href="{{ route('tenant_manage_role_create') }}">Manage User Role</a></li>
                    <li><a href="{{ route('tenant_role_create') }}">Create Role</a></li>
                    <li><a href="{{ route('tenant_role_index') }}">Roles List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_product_*', 'tenant_door_style_*', 'tenant_product_catalog_*', 'tenant_product_section_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="package"></i><span>Products</span></a>
                <ul>
                    <li><a href="{{ route('tenant_product_create') }}">Create Product</a></li>
                    <li><a href="{{ route('tenant_product_index') }}">Products List</a></li>
                    <li><a href="{{ route('tenant_product_catalog_create') }}">Create Catalog</a></li>
                    <li><a href="{{ route('tenant_product_catalog_index') }}">Catalog List</a></li>
                    <li><a href="{{ route('tenant_product_section_create') }}">Create Category</a></li>
                    <li><a href="{{ route('tenant_product_section_index') }}">Category List</a></li>
                    <li><a href="{{ route('tenant_door_style_create') }}">Create Door Style</a></li>
                    <li><a href="{{ route('tenant_door_style_index') }}">Door Style List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_order_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="shopping-cart"></i><span>Orders</span></a>
                <ul>
                    <li><a href="{{ route('tenant_order_create_static') }}">Create Order</a></li>
                    <li><a href="{{ route('tenant_order_list') }}">Orders List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_claim_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="alert-circle"></i><span>Claims</span></a>
                <ul>
                    <li><a href="#">Create Claim</a></li>
                    <li><a href="{{ route('tenant_claim_index') }}">Claims List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_bulletin_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="speaker"></i><span>Bulletins</span></a>
                <ul>
                    <li><a href="{{ route('tenant_bulletin_create') }}">Create Bulletin</a></li>
                    <li><a href="{{ route('tenant_bulletin_index') }}">Bulletins List</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs(['tenant_settings_hub', 'tenant_site_setting', 'tenant_home_setting_*', 'tenant_setting_*', 'pages.*']) ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_settings_hub') }}">
                    <i data-feather="settings"></i><span>Settings</span>
                </a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_stock_check_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="layers"></i><span>Stock Check</span></a>
                <ul>
                    <li><a href="{{ route('tenant_stock_check_create') }}">Create Stock Check</a></li>
                    <li><a href="{{ route('tenant_stock_check_index') }}">Stock Check List</a></li>
                </ul>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_quotes_*', 'tenant_shipping_quotes_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="file-text"></i><span>Quotes</span></a>
                <ul>
                    <li><a href="{{ route('tenant_quotes_create') }}">Create Quote</a></li>
                    <li><a href="{{ route('tenant_quotes_index') }}">Quotes List</a></li>
                    <li><a href="{{ route('tenant_shipping_quotes_create') }}">Create Shipping Quote</a></li>
                    <li><a href="{{ route('tenant_shipping_quotes_index') }}">Shipping Quotes List</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
