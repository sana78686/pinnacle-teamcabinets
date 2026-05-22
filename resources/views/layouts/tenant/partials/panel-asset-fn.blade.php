{{--
  Pinnacle super-user (pinnacle.apimstec.com): layouts/mega uses asset() → /assets/... (tenancy OFF).
  Tenant panel (amin-paragon.apimstec.com): tenancy ON — asset() may become /tenancy/assets/... (404).
  Live tenant docroot = project folder → static files are under /public/{path} (verified in browser).
--}}
@php
    if (! isset($panelAsset)) {
        $panelAsset = function (string $path): string {
            $path = ltrim($path, '/');
            $host = request()->getHost();
            $centralHosts = config('tenancy.central_domains', []);
            if (in_array($host, $centralHosts, true)
                || app()->environment('local')
                || str_contains($host, 'localhost')
                || str_contains($host, '127.0.0.1')) {
                return asset($path);
            }

            return rtrim(request()->getSchemeAndHttpHost(), '/').'/public/'.$path;
        };
    }
@endphp
