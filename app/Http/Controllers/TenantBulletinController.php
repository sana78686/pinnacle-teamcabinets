<?php

namespace App\Http\Controllers;

use App\Exports\BulletinExport;
use App\Imports\BulletinImport;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TenantBulletinController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bulletin = Bulletin::latest('id')->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.bulletins.index', ['bulletin' => $bulletin]);
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
        $bulletin =new Bulletin;
        $bulletin->user_option = $request->user_option;
        $bulletin->bulletin_title = $request->bulletin_title;
        $bulletin->bulletin_description = $request->bulletin_description;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalExtension();
            $filepath =$file->storeAs('images',$fileName,'public');
            $bulletin->image=$filepath;
        }
        $bulletin->save();
        return redirect()->back();
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

        $bulletin->user_option = $request->user_option;
        $bulletin->bulletin_title = $request->bulletin_title;
        $bulletin->bulletin_description = $request->bulletin_description;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalExtension();
            $filepath =$file->storeAs('images',$fileName,'public');
            $bulletin->image=$filepath;
        }
        $bulletin->save();
        return redirect()->route('tenant_bulletin_index');
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
