<?php

namespace App\Http\Controllers;

use App\Support\ManageDocumentVueConfig;
use Illuminate\View\View;

class TenantManageDocumentController extends Controller
{
    public function index(): View
    {
        return view('tenants.setting.manage_documentation_list', [
            'vueConfig' => ManageDocumentVueConfig::get(),
        ]);
    }

    public function create(): View
    {
        return view('tenants.setting.manage_document', [
            'vueConfig' => ManageDocumentVueConfig::get(),
        ]);
    }

    public function deleted(): View
    {
        return view('tenants.setting.deleted_manage_document_list', [
            'vueConfig' => ManageDocumentVueConfig::get(['trashed' => true]),
        ]);
    }
}
