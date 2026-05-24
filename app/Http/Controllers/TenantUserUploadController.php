<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TenantUserUploadController extends Controller
{
    public function index(): View
    {
        return view('tenants.rep.uploads.index', [
            'vueConfig' => \App\Support\UserUploadVueConfig::get(),
        ]);
    }
}
