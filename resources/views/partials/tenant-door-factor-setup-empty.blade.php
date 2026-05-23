@php
    $inModal = ($context ?? '') === 'modal';
    $missingDefaults = $missingDefaults ?? true;
    $missingCatalogs = $missingCatalogs ?? false;
    $missingDoorStyles = $missingDoorStyles ?? false;
    $commissionUrl = route('tenant_setting_commission');
    $catalogUrl = route('tenant_product_catalog_index');
    $doorStyleUrl = route('tenant_door_style_index');
@endphp
<div class="tc-door-factor-setup-note {{ $inModal ? 'tc-door-factor-setup-note--modal' : '' }}" role="status">
    <p class="tc-door-factor-setup-note__text mb-0">
        @if ($missingDefaults)
            <a href="{{ $commissionUrl }}" class="tc-door-factor-setup-note__link">Door factors</a> are not ready yet.
            Configure default percentages by role in
            <a href="{{ $commissionUrl }}" class="tc-door-factor-setup-note__link">Commission settings</a> before creating users.
        @endif
        @if ($missingCatalogs)
            @if ($missingDefaults)
                <span class="tc-door-factor-setup-note__sep"> </span>
            @endif
            No active
            <a href="{{ $catalogUrl }}" class="tc-door-factor-setup-note__link">product catalog</a>
            found. Create a catalog before assigning door factors.
        @endif
        @if ($missingDoorStyles)
            @if ($missingDefaults || $missingCatalogs)
                <span class="tc-door-factor-setup-note__sep"> </span>
            @endif
            No
            <a href="{{ $doorStyleUrl }}" class="tc-door-factor-setup-note__link">door styles</a>
            found. Add door styles linked to your catalogs.
        @endif
        @if (! $missingDefaults && ! $missingCatalogs && ! $missingDoorStyles)
            Select at least one catalog, then enter a factor for each visible door style.
            <button type="button" class="btn btn-link btn-sm tc-door-factor-setup-note__action p-0 align-baseline btn-import">
                Add door point factors
            </button>
        @endif
    </p>
</div>
