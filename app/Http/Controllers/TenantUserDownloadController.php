<?php

namespace App\Http\Controllers;

use App\Models\AdminUpload;
use App\Models\ManageDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TenantUserDownloadController extends Controller
{
    public function index(): View
    {
        $types = tenant_manage_document_types_for_user(Auth::user());

        $documents = Schema::hasTable('manage_document')
            ? ManageDocument::query()
                ->when(
                    Schema::hasColumn('manage_document', 'status'),
                    fn ($q) => $q->where(function ($inner) {
                        $inner->where('status', 'active')->orWhereNull('status');
                    })
                )
                ->whereIn('user_type', $types)
                ->orderByDesc('id')
                ->get()
                ->map(function (ManageDocument $doc) {
                    $fileName = (string) $doc->document_name;
                    $url = tenant_static_asset('assets/admin/manage_document/'.$fileName);

                    return [
                        'id' => 'doc-'.$doc->id,
                        'name' => $fileName,
                        'url' => $url,
                        'is_pdf' => (bool) preg_match('/\.pdf$/i', $fileName),
                        'kind' => 'document',
                    ];
                })
            : collect();

        $userType = Auth::user()?->getCiRole() ?? '';

        $adminFiles = Schema::hasTable('admin_uploads')
            ? AdminUpload::query()
                ->where(function ($q) use ($userType) {
                    $q->where('user_type', '')
                        ->orWhere('user_type', $userType);
                })
                ->orderByDesc('id')
                ->get()
                ->map(function (AdminUpload $upload) {
                    return [
                        'id' => 'upload-'.$upload->id,
                        'name' => $upload->original_name ?: $upload->file_name,
                        'description' => $upload->description,
                        'url' => tenant_static_asset('assets/admin_uploads/'.$upload->file_name),
                        'is_pdf' => (bool) preg_match('/\.pdf$/i', $upload->file_name),
                        'kind' => 'admin_upload',
                    ];
                })
            : collect();

        return view('tenants.rep.downloads.index', [
            'documents' => $documents,
            'adminFiles' => $adminFiles,
        ]);
    }
}
