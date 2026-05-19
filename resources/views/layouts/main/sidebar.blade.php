<div class="vertical-menu-main">
    <nav id="main-nav">
        <!-- Sample menu definition-->
        <ul class="sm pixelstrap" id="main-menu">
            <li>
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            <li><a href="{{ route('tenant_index') }}">
                <i class="font-primary" data-feather="home"></i> Dashboard</a></li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> users</a>
                <ul>
                    <li><a href="#">Create User</a></li>
                    <li><a href="{{ route('tenant_user_index') }}">users List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Roles</a>
                <ul>
                    <li><a href="#">Create an Role</a></li>
                    <li><a href="#">Roles List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Products</a>
                <ul>
                    <li><a href="#">Create Prpduct</a></li>
                    <li><a href="#">Products List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Product Catalogs</a>
                <ul>
                    <li><a href="#">Create Catalog</a></li>
                    <li><a href="#">Catalog List</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="font-primary" data-feather="anchor"></i> Orders</a>
                <ul>
                    <li><a href="#">Create an order</a></li>
                    <li><a href="#">Orders List</a></li>
                </ul>
            </li>

        </ul>
    </nav>
</div>
