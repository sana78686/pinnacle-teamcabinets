<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManageOtherPageContent;
use App\Models\SiteSetting;
use App\Services\ManageOtherPageContentService;
use App\Services\TaxValuesService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TenantSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenants.setting.manage_contact_us');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.setting.manage_about_us');
    }



    public function manage_site_settings()
    {
        $settings = SiteSetting::first() ;
        return view('tenants.setting.manage_site_settings',compact('settings'));
    }
   public function store_site_settings(Request $request)
{
    // 🔹 Validate inputs
    $request->validate([
        'logo' => 'nullable|image|max:2048',
        'banner_image' => 'nullable|image|max:4096',
        'aboutus_image' => 'nullable|image|max:4096',
        'phone' => 'required|string|max:20',
        'contactus_phone' => 'nullable|string|max:20',
        'newuser_phone' => 'nullable|string|max:20',
        'email' => 'required|email|max:255',
        'contactus_email' => 'nullable|email|max:255',
        'newuser_email' => 'nullable|email|max:255',
        'address' => 'required|string|max:256',
        'facebook' => 'nullable|url|max:255',
        'twitter' => 'nullable|url|max:255',
        'youtube' => 'nullable|url|max:255',
        'instagram' => 'nullable|url|max:255',

    ]);

    // 🔹 Fetch or create settings (scoped to current tenant)
    $settings = SiteSetting::first() ?? new SiteSetting(['tenant_id' => tenant('id')]);
    if (! $settings->tenant_id && tenant('id')) {
        $settings->tenant_id = tenant('id');
    }

    // 🔹 Helper for file upload
    $uploadFile = function ($fileInput, $path, $oldFile = null) use ($request) {
        if ($request->hasFile($fileInput)) {
            // Delete old file if exists
            if ($oldFile && file_exists(public_path($oldFile))) {
                @unlink(public_path($oldFile));
            }

            $file = $request->file($fileInput);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            return "$path/$filename";
        }
        return $oldFile;
    };

    // 🔹 Upload files
    $settings->logo = $uploadFile('logo', 'uploads/logos', $settings->logo);


    // 🔹 Save text fields
    $settings->phone = $request->phone;
    $settings->contactus_phone = $request->contactus_phone;
    $settings->newuser_phone = $request->newuser_phone;
    $settings->email = $request->email;
    $settings->contactus_email = $request->contactus_email;
    $settings->newuser_email = $request->newuser_email;
    $settings->address = $request->address;
    $settings->facebook = $request->facebook;
    $settings->twitter = $request->twitter;
    $settings->youtube = $request->youtube;
    $settings->instagram = $request->instagram;


    // 🔹 Save all
    $settings->save();

    return redirect()->back()->with('success', 'Site settings saved successfully.');
}

    public function manage_tax_fees(TaxValuesService $taxValues)
    {
        $taxValues->ensureDefaults();
        $values = [];
        foreach (TaxValuesService::feeKeys() as $key => $meta) {
            $values[$key] = $taxValues->get($key, $meta['default']);
        }

        return view('tenants.setting.manage_tax_fees', compact('values'));
    }

    public function store_tax_fees(Request $request, TaxValuesService $taxValues)
    {
        $request->validate([
            'fuel_charges_value' => 'required|numeric|min:0|max:100',
            'credit_card_charges' => 'required|numeric|min:0|max:100',
            'debit_card_charges' => 'required|numeric|min:0|max:100',
            'ach_pay_charges' => 'required|numeric|min:0|max:99999',
            'sales_tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach (TaxValuesService::feeKeys() as $key => $meta) {
            if ($request->has($key)) {
                $taxValues->set($key, (string) $request->input($key), $meta['label']);
            }
        }

        return redirect()->back()->with('success', 'Tax and fee settings saved successfully.');
    }

    public function manage_commission()
    {
        return view('tenants.setting.manage_commission');
    }



    public function manage_document()
    {
        return view('tenants.setting.manage_document');
    }


    public function manage_stmp()
    {
        $smtp = \App\Models\TenantSmtpSetting::query()->first();

        return view('tenants.setting.manage_stmp', compact('smtp'));
    }

    public function manage_stmp_store(Request $request)
    {
        $rules = [
            'smtp_host' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'required|string|in:tls,ssl,none',
        ];

        $smtp = \App\Models\TenantSmtpSetting::query()->first();
        if (! $smtp || $request->filled('smtp_password')) {
            $rules['smtp_password'] = 'required|string|max:255';
        }

        try {
            $validated = $request->validate($rules);

            $record = $smtp ?? new \App\Models\TenantSmtpSetting(['tenant_id' => tenant('id')]);
            if (! $record->tenant_id) {
                $record->tenant_id = tenant('id');
            }

            $record->fill([
                'smtp_host' => $validated['smtp_host'],
                'smtp_port' => $validated['smtp_port'],
                'smtp_encryption' => $validated['smtp_encryption'],
                'smtp_username' => $validated['smtp_username'],
                'from_email' => $validated['from_email'],
                'from_name' => $validated['from_name'] ?? tenant('company_name') ?? tenant('name'),
            ]);

            if (! empty($validated['smtp_password'])) {
                $record->smtp_password = $validated['smtp_password'];
                $record->is_verified = false;
                $record->verified_at = null;
            }

            $record->save();

            return redirect()->back()->with('success', 'SMTP settings saved. Use Test connection to verify.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Failed to save SMTP settings: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function test_smtp_connection(Request $request)
    {
        $smtp = \App\Models\TenantSmtpSetting::query()->first();

        $rules = [
            'smtp_host' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'required|string|in:tls,ssl,none',
        ];

        if (! $smtp || $request->filled('smtp_password')) {
            $rules['smtp_password'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        if (empty($validated['smtp_password']) && $smtp) {
            $validated['smtp_password'] = $smtp->smtp_password;
        }

        $validated['from_name'] = $request->input('from_name', tenant('company_name') ?? tenant('name'));
        $validated['test_recipient'] = $request->input('test_recipient', $validated['from_email']);

        $result = app(\App\Services\TenantSmtpService::class)->testConnection($validated, true);

        if ($result['success']) {
            $record = $smtp ?? new \App\Models\TenantSmtpSetting(['tenant_id' => tenant('id')]);
            if (! $record->tenant_id) {
                $record->tenant_id = tenant('id');
            }
            $record->fill([
                'smtp_host' => $validated['smtp_host'],
                'smtp_port' => $validated['smtp_port'],
                'smtp_encryption' => $validated['smtp_encryption'],
                'smtp_username' => $validated['smtp_username'],
                'from_email' => $validated['from_email'],
                'from_name' => $validated['from_name'] ?? tenant('company_name') ?? tenant('name'),
            ]);
            if (! empty($validated['smtp_password'])) {
                $record->smtp_password = $validated['smtp_password'];
            }
            $record->is_verified = true;
            $record->verified_at = now();
            $record->save();
        }

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }


    public function manage_email()
    {
        return view('tenants.setting.manage_email_content');
    }
    public function manage_term_condition()
    {
        return view('tenants.setting.manage_term_condition');
    }

    public function manage_credit()
    {
        return redirect()->route('tenant_setting_tax_fees');
    }

    public function manage_fuel()
    {
        return redirect()->route('tenant_setting_tax_fees');
    }

    public function manage_success()
    {
        return redirect()->route('tenant_setting_manage_success_list');
    }
   public function manage_home_list()
{
    $settings = SiteSetting::first();
    return view('tenants.setting.manage_home_list', compact('settings'));
}


    public function home_list_edit(string $id)
    {
        $settings = SiteSetting::first();
        return view('tenants.setting.manage_home_edit', compact('settings'));
    }
    public function manage_show_home(string $id)
    {
        return view('tenants.setting.manage_show_home');
    }
    public function manage_documentation_list()
    {
        return view('tenants.setting.manage_documentation_list');
    }
    public function manage_documentation_edit(string $id)
    {
        return view('tenants.setting.manage_documentation_edit');
    }
    public function manage_documentation_show(string $id)
    {
        return view('tenants.setting.manage_documentation_show');
    }
    public function  manage_stmp_list()

    {
        return view('tenants.setting.manage_stmp_list');
    }
    public function  manage_stmp_edit()

    {
        return view('tenants.setting.manage_stmp_edit');
    }
    public function  manage_stmp_show()

    {
        return view('tenants.setting.manage_stmp_show');
    }
    public function  manage_email_content_list()

    {
        return view('tenants.setting.manage_email_content_list');
    }

    public function  manage_email_content_edit(string $id)

    {
        return view('tenants.setting.manage_email_content_edit');
    }

    public function  manage_email_content_show(string $id)

    {
        return view('tenants.setting.manage_email_content_show');
    }

    public function  manage_term_condition_list()

    {
        return view('tenants.setting.manage_term_condition_list');
    }
    public function  manage_term_condition_edit()

    {
        return view('tenants.setting.manage_term_condition_edit');
    }
    public function  manage_term_condition_show()

    {
        return view('tenants.setting.manage_term_condition_show');
    }

    public function  manage_credit_list()

    {
        return view('tenants.setting.manage_credit_list');
    }

    public function  manage_credit_edit()

    {
        return view('tenants.setting.manage_credit_edit');
    }

    public function  manage_credit_show()

    {
        return view('tenants.setting.manage_credit_show');
    }
    public function  manage_fuel_list()

    {
        return view('tenants.setting.manage_fuel_list');
    }

    public function  manage_fuel_edit()

    {
        return view('tenants.setting.manage_fuel_edit');
    }

    public function  manage_fuel_show()

    {
        return view('tenants.setting.manage_fuel_show');
    }


    public function manage_success_list(ManageOtherPageContentService $pageContentService)
    {
        $pageContentService->ensureDefaults();
        $pages = ManageOtherPageContent::query()->orderBy('id')->get();

        return view('tenants.setting.manage_success_list', compact('pages'));
    }

    public function manage_success_edit(string $id)
    {
        $page = ManageOtherPageContent::query()->findOrFail($id);

        return view('tenants.setting.manage_success_edit', compact('page'));
    }

    public function manage_success_update(Request $request, string $id, ManageOtherPageContentService $pageContentService)
    {
        $page = ManageOtherPageContent::query()->findOrFail($id);

        $request->validate([
            'page_content' => 'required|string',
        ]);

        $page->update([
            'page_content' => $request->input('page_content'),
        ]);

        return redirect()
            ->route('tenant_setting_manage_success_edit', $page->id)
            ->with('success', 'Page content has been updated successfully.');
    }

    public function manage_success_show(string $id)
    {
        $page = ManageOtherPageContent::query()->findOrFail($id);

        return view('tenants.setting.manage_success_show', compact('page'));
    }


    public function  manage_contact_list()

    {
        return view('tenants.setting.manage_contact_list');
    }


    public function  manage_contact_edit()

    {
        return view('tenants.setting.manage_contact_edit');
    }
    public function  manage_contact_show()

    {
        return view('tenants.setting.manage_contact_show');
    }

    public function  manage_about_list()

    {
        return view('tenants.setting.manage_about_list');
    }
    public function  manage_about_edit()

    {
        return view('tenants.setting.manage_about_edit');
    }



    public function  manage_about_show()

    {
        return view('tenants.setting.manage_about_show');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function deletedmanagehomelist()

    {

        return view('tenants.setting.deleted_manage_home_list');
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        // session()->flash('success', "Please deleted_products_list add user's Point Factor immediately after the Approval. Otherwise it will affect the Commission Report.You can only change the product type of the product until product is not approved.");
        // return view('tenants.product_section.deleted_product_section_list', $data);
    }

    public function restoredeletedmanagelist($id)
    {
        // $product_section = ProductSection::onlyTrashed()->findOrFail($id);
        // if (!$product_section) {
        //     session()->flash('error', 'Product cannot found.');
        //     return redirect()->back();
        // }
        // $product_section->restore(); // Restore the user
        // return redirect()->route('tenant_deleted_product_section_list')
        //     ->with('success', 'product_section.'.$product_section->name.'. Restored successfully');
    }



    public function deletedmanagedocumentlist()

    {

        return view('tenants.setting.deleted_manage_document_list');

    }

    public function restoredeletedmanagedocumentlist($id)
    {

    }



    public function deleted_manage_email_list()

    {

        return view('tenants.setting.deleted_manage_email_list');

    }

    public function restoredeletedmanagestmplist($id)
    {

    }
    public function deleted_manage_termcondition_list()

    {

        return view('tenants.setting.deleted_manage_term_condition_list');

    }

    public function restore_deleted_manage_termcondition_list($id)
    {

    }
    public function deleted_manage_credit_list()

    {

        return view('tenants.setting.deleted_manage_credit_list');

    }

    public function restore_deleted_manage_credit_list($id)
    {

    }
    public function deleted_manage_fuel_list()

    {

        return view('tenants.setting.deleted_manage_fuel_list');

    }

    public function restore_deleted_manage_fuel_list($id)
    {

    }
    public function deleted_manage_success_list()

    {

        return view('tenants.setting.deleted_manage_success_list');

    }

    public function restore_deleted_manage_success_list($id)
    {

    }
    public function deleted_manage_contact_list()

    {

        return view('tenants.setting.deleted_manage_contact_list');

    }

    public function restore_deleted_manage_contact_list($id)
    {

    }
    public function deleted_manage_about_list()

    {

        return view('tenants.setting.deleted_manage_about_list');

    }

    public function restore_deleted_manage_about_list($id)
    {

    }
}
