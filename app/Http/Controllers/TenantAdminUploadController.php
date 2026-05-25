<?php

namespace App\Http\Controllers;

use App\Support\AdminUploadVueConfig;
use Illuminate\View\View;

class TenantAdminUploadController extends Controller
{
    public function index(): View
    {
        return view('tenants.admin_uploads.index', [
            'vueConfig' => AdminUploadVueConfig::get(),
        ]);
    }
}
