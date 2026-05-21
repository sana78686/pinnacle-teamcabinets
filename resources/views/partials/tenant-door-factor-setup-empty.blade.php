@php
    $inModal = ($context ?? '') === 'modal';
    $missingDefaults = $missingDefaults ?? true;
    $missingCatalogs = $missingCatalogs ?? false;
    $missingDoorStyles = $missingDoorStyles ?? false;
@endphp
<div class="alert alert-warning outline tc-door-factor-setup-empty {{ $inModal ? 'mb-3' : '' }}" role="status">
    <strong class="d-block mb-2">Door point factors are not ready yet</strong>
    @if ($missingDefaults)
        <p class="mb-2 small mb-0">No <strong>default point factors by role</strong> are configured. Add them first so you can apply defaults when creating users.</p>
        <a href="{{ route('tenant_setting_commission') }}" class="btn btn-sm btn-primary">
            Add door factor defaults (Commission settings)
        </a>
    @endif
    @if ($missingCatalogs)
        <p class="mb-2 mt-2 small">No active <strong>product catalogs</strong> found. Create catalogs before assigning door factors.</p>
        <a href="{{ route('tenant_product_catalog_index') }}" class="btn btn-sm btn-outline-primary">Manage product catalogs</a>
    @endif
    @if ($missingDoorStyles)
        <p class="mb-2 mt-2 small">No <strong>door styles</strong> found. Add door styles linked to your catalogs.</p>
        <a href="{{ route('tenant_door_style_index') }}" class="btn btn-sm btn-outline-primary">Manage door styles</a>
    @endif
    @if (! $missingDefaults && ! $missingCatalogs && ! $missingDoorStyles)
        <p class="mb-2 small">Select at least one catalog, then enter a factor for each visible door style.</p>
        <button type="button" class="btn btn-sm btn-primary btn-import">Add door point factors</button>
    @endif
</div>
