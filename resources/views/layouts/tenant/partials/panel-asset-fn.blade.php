@php
    if (! isset($panelAsset)) {
        $panelAsset = fn (string $path): string => tenant_static_asset($path);
    }
@endphp
