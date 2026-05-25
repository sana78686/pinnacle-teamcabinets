@if (tenant_can('order-create'))
    <li class="tc-header-create-order d-none d-md-flex align-items-center">
        <a href="{{ route('tenant_order_workspace') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">
            Create an order
        </a>
    </li>
@endif
