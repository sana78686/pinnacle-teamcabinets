<?php

namespace App\Http\Controllers;

use App\Support\InventoryAdminVueConfig;
use Illuminate\View\View;

class TenantInventoryAdminController extends Controller
{
    public function index(): View
    {
        return view('tenants.inventory.index', [
            'vueConfig' => InventoryAdminVueConfig::get(),
        ]);
    }
}
