<?php

namespace App\Http\Controllers;

use App\Models\ManageDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantUserDownloadController extends Controller
{
    public function index(): View
    {
        $types = tenant_manage_document_types_for_user(Auth::user());

        $documents = ManageDocument::query()
            ->whereIn('user_type', $types)
            ->orderByDesc('id')
            ->get()
            ->map(function (ManageDocument $doc) {
                $fileName = (string) $doc->document_name;
                $url = tenant_static_asset('assets/admin/manage_document/'.$fileName);

                return [
                    'id' => $doc->id,
                    'name' => $fileName,
                    'url' => $url,
                    'is_pdf' => (bool) preg_match('/\.pdf$/i', $fileName),
                ];
            });

        return view('tenants.rep.downloads.index', [
            'documents' => $documents,
        ]);
    }
}
