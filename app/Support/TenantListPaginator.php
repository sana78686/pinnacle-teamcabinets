<?php

namespace App\Support;

use Illuminate\Http\Request;

class TenantListPaginator
{
    public static function perPage(Request $request, array $allowed = [10, 15, 25, 50, 100], ?int $default = null): int
    {
        $default = $default ?? tenant_list_per_page();
        $perPage = (int) $request->input('per_page', $default);

        return in_array($perPage, $allowed, true) ? $perPage : $default;
    }

    public static function search(Request $request): string
    {
        return trim((string) $request->input('search', ''));
    }
}
