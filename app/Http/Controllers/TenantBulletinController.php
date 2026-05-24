<?php

namespace App\Http\Controllers;

use App\Exports\BulletinExport;
use App\Imports\BulletinImport;
use App\Models\Bulletin;
use App\Support\BulletinAudience;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
use App\Support\TenantListPaginator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TenantBulletinController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $sort = (string) $request->input('sort', 'newest');
        $audience = (string) $request->input('audience', '');

        if (! array_key_exists($sort, BulletinAudience::adminSortOptions())) {
            $sort = 'newest';
        }

        $query = Bulletin::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('bulletin_title', 'like', '%'.$search.'%')
                    ->orWhere('bulletin_description', 'like', '%'.$search.'%')
                    ->orWhere('target_role', 'like', '%'.$search.'%');
            });
        }

        if ($audience === 'every_one' || $audience === 'specific_user') {
            $query->where('user_option', $audience);
        }

        match ($sort) {
            'oldest' => $query->oldest('id'),
            'title_asc' => $query->orderBy('bulletin_title')->orderByDesc('id'),
            'title_desc' => $query->orderByDesc('bulletin_title')->orderByDesc('id'),
            default => $query->latest('created_at')->latest('id'),
        };

        $bulletins = $query->paginate($perPage)->withQueryString();

        return view('tenants.Bulletins.index', [
            'bulletins' => $bulletins,
            'perPage' => $perPage,
            'search' => $search,
            'sort' => $sort,
            'audience' => $audience,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.bulletins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(array_merge([
            'user_option' => 'required|in:every_one,specific_user',
            'target_role' => 'nullable|string|max:100|required_if:user_option,specific_user',
            'bulletin_title' => 'required|string|max:255',
            'bulletin_description' => 'required|string|max:5000',
        ], MediaUpload::imageOrPdfFieldRules('image')));

        $bulletin = new Bulletin;
        $bulletin->user_option = $validated['user_option'];
        $bulletin->target_role = $validated['user_option'] === 'specific_user'
            ? BulletinAudience::normalizeTargetRole($validated['target_role'] ?? null)
            : null;
        $bulletin->bulletin_title = $validated['bulletin_title'];
        $bulletin->bulletin_description = $validated['bulletin_description'];
        $bulletin->image = PublicUploadedFile::resolve(
            $request,
            'image',
            null,
            'images',
            'public'
        );
        $bulletin->save();

        return redirect()
            ->route('tenant_bulletin_index')
            ->with('success', 'Bulletin created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bulletin = Bulletin::findOrFail($id);
        return view('tenants.bulletins.show',compact('bulletin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bulletin = Bulletin::findOrFail($id);
       return view('tenants.bulletins.edit',compact('bulletin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bulletin = Bulletin::findOrFail($id);

        $validated = $request->validate(array_merge([
            'user_option' => 'required|in:every_one,specific_user',
            'target_role' => 'nullable|string|max:100|required_if:user_option,specific_user',
            'bulletin_title' => 'required|string|max:255',
            'bulletin_description' => 'required|string|max:5000',
        ], MediaUpload::imageOrPdfFieldRules('image')));

        $bulletin->user_option = $validated['user_option'];
        $bulletin->target_role = $validated['user_option'] === 'specific_user'
            ? BulletinAudience::normalizeTargetRole($validated['target_role'] ?? null)
            : null;
        $bulletin->bulletin_title = $validated['bulletin_title'];
        $bulletin->bulletin_description = $validated['bulletin_description'];
        $bulletin->image = PublicUploadedFile::resolve(
            $request,
            'image',
            $bulletin->image,
            'images',
            'public'
        );
        $bulletin->save();

        return redirect()
            ->route('tenant_bulletin_index')
            ->with('success', 'Bulletin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $bulletin = Bulletin::findOrFail($id);

       $bulletin->delete();

       return redirect()->back();
    }

    public function deletedbulletinList()
    {

        $data['bulletin'] = Bulletin::onlyTrashed()->latest('id')->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.Bulletins.deleted_bulletin_list', $data);
    }

    public function restoreDeletedbulletin($id)
    {
        $bulletin = Bulletin::onlyTrashed()->findOrFail($id);
     $bulletin = Bulletin::onlyTrashed()->findOrFail($id);
     if (!$bulletin) {
         session()->flash('error', 'Bulletin cannot found.');
         return redirect()->back();
        }
     $bulletin->restore();
        return redirect()->route('tenant_bulletin_index')
         ->with('success', 'bulletin.'.$bulletin->name.'. Restored successfully');
 }



 public function bulletin_export()
 {
     return Excel::download(new BulletinExport, 'bulletin.xlsx');
 }

 public function bulletin_import(Request $request)
{
 // Validate the file
 $request->validate([
     'bulletinFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
 ]);

 // Import the file using Excel::import
 Excel::import(new BulletinImport, $request->file('bulletinFile'));

 // Redirect back after import
 return redirect()->back();
}
}
