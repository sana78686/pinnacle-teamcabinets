<div class="vertical-menu-main">
    <nav id="main-nav">
        <!-- Sample menu definition-->
        <ul class="sm pixelstrap" id="main-menu">
            <li>
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            <li><a href="{{ route('tenant_dashboard') }}">
                    <i class="font-primary" data-feather="home"></i> Dashboard</a></li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> users</a>
                <ul>
                    <li><a href="{{ route('tenant_user_create') }}">Create User</a></li>
                    <li><a href="{{ route('tenant_user_index') }}">users List</a></li>
                </ul>
            </li>

            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Roles</a>
                <ul>
                    <li><a href="{{ route('tenant_manage_role_create') }}">Manage user Role</a></li>
                    <li><a href="{{ route('tenant_role_create') }}">Create an Role</a></li>
                    <li><a href="{{ route('tenant_role_index') }}">Roles List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Products</a>
                <ul>
                    <li><a href="{{ route('coming_soon') }}">Create Product</a></li>
                    <li><a href="{{ route('coming_soon') }}">Products List</a></li>
                    <li><a href="{{ route('tenant_product_catalog_create') }}">Create Catalog</a></li>
                    <li><a href="{{ route('tenant_product_catalog_index') }}">Catalog List</a></li>
                    <li><a href="{{ route('tenant_product_section_create') }}">Create Product Category</a></li>
                    <li><a href="{{ route('tenant_product_section_index') }}">Product Category List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Orders</a>
                <ul>
                    <li><a href="#">Create an order</a></li>
                    <li><a href="{{ route('coming_soon') }}">Orders List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Claims</a>
                <ul>
                    <li><a href="#">Create an Claim</a></li>
                    <li><a href="{{ route('coming_soon') }}">Claims List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Bulletins</a>
                <ul>
                    <li><a href="{{ route('coming_soon') }}">Create an Bulletin</a></li>
                    <li><a href="{{ route('coming_soon') }}">Bulletins List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i>Setting</a>
                <ul>
                    <li><a href="{{ route('coming_soon') }}">Manage Document</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage STMP</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Email Content</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Credit/Debit/ACH</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Fuel</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Success/Error content</a></li>
                    <hr class="p-0 m-0">
                    <li><a href="{{ route('coming_soon') }}">Manage Home</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Contact Us</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage About Us</a></li>
                    <li><a href="{{ route('coming_soon') }}">Manage Term & Condition </a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
