<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\ManageOtherPageContent;
use App\Models\Page;
use App\Models\PointFactorDefault;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\SiteSetting;
use App\Services\ManageEmailsContentService;
use App\Services\ManageOtherPageContentService;
use Spatie\Permission\Models\Role;
use App\Models\SalesTaxCounty;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
use App\Support\TenantListPaginator;
use App\Services\PointFactorDefaultsService;
use App\Services\SalesTaxCountiesService;
use App\Services\TaxValuesService;
use App\Services\StorefrontBrandCssService;
use App\Services\StorefrontPageService;
use App\Services\TenantFrontendThemeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TenantSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('tenant_contact_page_settings');
    }

    public function contactPageSettings(StorefrontPageService $storefrontPages)
    {
        $settings = SiteSetting::forCurrentTenant();
        $contactPage = $storefrontPages->ensureContactPage();

        return view('tenants.setting.manage_contact_us', compact('settings', 'contactPage'));
    }

    public function storeContactPageSettings(Request $request, StorefrontPageService $storefrontPages)
    {
        $request->validate([
            'contact_sidebar_title' => 'nullable|string|max:255',
            'map_embed_url' => 'nullable|string|max:5000',
            'contact_intro' => 'nullable|string',
        ]);

        $settings = SiteSetting::forCurrentTenant();
        $settings->contact_sidebar_title = $request->contact_sidebar_title;
        $settings->map_embed_url = $request->map_embed_url;
        $settings->save();

        $page = $storefrontPages->ensureContactPage();
        $page->status = 'published';
        if ($request->has('contact_intro')) {
            $page->content = $request->input('contact_intro');
        }
        $page->save();

        return redirect()->back()->with('success', 'Contact page settings saved.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('tenant_storefront_about');
    }



    public function manage_site_settings(StorefrontBrandCssService $brandCss)
    {
        $settings = SiteSetting::forCurrentTenant();

        return view('tenants.setting.manage_site_settings', [
            'settings' => $settings,
            'storefrontBrandColor' => $brandCss->currentColor(),
            'sameContact' => $this->siteSettingsUseSameContact($settings),
        ]);
    }

    protected function siteSettingsUseSameContact(?SiteSetting $settings): bool
    {
        if (old('use_same_contact') !== null) {
            return old('use_same_contact') === '1' || old('use_same_contact') === true;
        }

        if (! $settings) {
            return true;
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn('site_settings', 'use_same_contact')
            && $settings->use_same_contact !== null) {
            return (bool) $settings->use_same_contact;
        }

        $normPhone = static fn ($v) => preg_replace('/\D+/', '', (string) ($v ?? ''));
        $norm = static fn ($v) => trim((string) ($v ?? ''));

        return $normPhone($settings->contactus_phone) === $normPhone($settings->phone)
            && $normPhone($settings->newuser_phone) === $normPhone($settings->phone)
            && $norm($settings->contactus_email) === $norm($settings->email)
            && $norm($settings->newuser_email) === $norm($settings->email);
    }

    public function website_designing(TenantFrontendThemeService $themes)
    {
        $themesList = $themes->all();
        $activeSlug = $themes->activeSlug();
        $activeThemeLabel = $themesList[$activeSlug]['label'] ?? $themesList[$activeSlug]['name'] ?? ucfirst($activeSlug);

        $home = HomeSetting::forCurrentTenant();
        $faqCount = count($home?->resolvedFaqs() ?? []);

        return view('tenants.setting.manage_website_designing', [
            'activeThemeLabel' => $activeThemeLabel,
            'faqCount' => $faqCount,
            'pageCount' => Page::cmsOnly()->count(),
            'articleCount' => Page::blogPosts()->count(),
        ]);
    }

    public function manage_frontend_theme(TenantFrontendThemeService $themes)
    {
        $settings = SiteSetting::forCurrentTenant();
        $activeTheme = $themes->activeSlug();

        return view('tenants.setting.manage_frontend_theme', [
            'settings' => $settings,
            'themes' => $themes->all(),
            'activeTheme' => $activeTheme,
            'defaultTheme' => $themes->defaultSlug(),
        ]);
    }

    public function store_frontend_theme(Request $request, TenantFrontendThemeService $themes)
    {
        $allowed = implode(',', array_keys($themes->all()));

        $request->validate([
            'frontend_theme' => "required|string|in:{$allowed}",
        ]);

        $themes->setActive($request->input('frontend_theme'));

        return redirect()
            ->route('tenant_frontend_theme')
            ->with('success', 'Storefront theme updated. Visitors will see the new design on your public site.');
    }

   public function store_site_settings(Request $request, StorefrontBrandCssService $brandCss)
{
    // 🔹 Validate inputs
    $request->validate([
        ...MediaUpload::imageFieldRules('logo'),
        ...MediaUpload::imageFieldRules('favicon', 1024),
        ...MediaUpload::imageFieldRules('og_image', 4096),
        'site_meta_title' => 'nullable|string|max:255',
        'site_meta_description' => 'nullable|string|max:1000',
        'site_meta_keywords' => 'nullable|string|max:500',
        ...MediaUpload::imageFieldRules('banner_image', 4096),
        ...MediaUpload::imageFieldRules('aboutus_image', 4096),
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
        'storefront_brand_color' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],

    ]);

    // 🔹 Fetch or create settings (scoped to current tenant)
    $settings = SiteSetting::forCurrentTenant();
    if (empty($settings->frontend_theme)) {
        $settings->frontend_theme = app(TenantFrontendThemeService::class)->defaultSlug();
    }

    $settings->logo = PublicUploadedFile::resolve($request, 'logo', $settings->logo, 'uploads/logos');
    $settings->favicon = PublicUploadedFile::resolve($request, 'favicon', $settings->favicon, 'uploads/favicons');
    $settings->og_image = PublicUploadedFile::resolve($request, 'og_image', $settings->og_image, 'uploads/og');

    // 🔹 Save text fields
    $settings->site_meta_title = $request->site_meta_title;
    $settings->site_meta_description = $request->site_meta_description;
    $settings->site_meta_keywords = $request->site_meta_keywords;
    $settings->phone = $request->phone;
    $settings->email = $request->email;

    if (\Illuminate\Support\Facades\Schema::hasColumn('site_settings', 'use_same_contact')) {
        $settings->use_same_contact = $request->boolean('use_same_contact');
    }

    if ($request->boolean('use_same_contact')) {
        $settings->contactus_phone = $request->phone;
        $settings->newuser_phone = $request->phone;
        $settings->contactus_email = $request->email;
        $settings->newuser_email = $request->email;
    } else {
        $settings->contactus_phone = $request->contactus_phone;
        $settings->newuser_phone = $request->newuser_phone;
    $settings->contactus_email = $request->contactus_email;
    $settings->newuser_email = $request->newuser_email;
    }
    $settings->address = $request->address;
    $settings->facebook = $request->facebook;
    $settings->twitter = $request->twitter;
    $settings->youtube = $request->youtube;
    $settings->instagram = $request->instagram;


    // 🔹 Save all
    $settings->save();

    $brandCss->write((string) $request->input('storefront_brand_color'));

    return redirect()->back()->with('success', 'Site settings saved successfully.');
}

    public function manage_tax_fees(TaxValuesService $taxValues, SalesTaxCountiesService $salesTaxCounties)
    {
        $taxValues->ensureDefaults();

        return view('tenants.setting.manage_tax_fees', [
            'countyCount' => $salesTaxCounties->countyCount(),
        ]);
    }

    public function manage_tax_fees_payment(TaxValuesService $taxValues)
    {
        $taxValues->ensureDefaults();

        return view('tenants.setting.manage_tax_fees_payment', [
            'values' => $this->taxFeeValues($taxValues, TaxValuesService::paymentFeeKeys()),
        ]);
    }

    public function store_tax_fees_payment(Request $request, TaxValuesService $taxValues)
    {
        $request->validate([
            'fuel_charges_value' => 'required|numeric|min:0|max:100',
            'credit_card_charges' => 'required|numeric|min:0|max:100',
            'debit_card_charges' => 'required|numeric|min:0|max:100',
            'ach_pay_charges' => 'required|numeric|min:0|max:99999',
            'sales_tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach (TaxValuesService::paymentFeeKeys() as $key => $meta) {
            if ($request->has($key)) {
                $taxValues->set($key, (string) $request->input($key), $meta['label']);
            }
        }

        return redirect()
            ->route('tenant_setting_tax_fees_payment')
            ->with('success', 'Payment and fuel fee settings saved.');
    }

    public function manage_tax_fees_shipping(TaxValuesService $taxValues)
    {
        $taxValues->ensureDefaults();

        return view('tenants.setting.manage_tax_fees_shipping', [
            'values' => $this->taxFeeValues($taxValues, TaxValuesService::shippingFeeKeys()),
        ]);
    }

    public function store_tax_fees_shipping(Request $request, TaxValuesService $taxValues)
    {
        $rules = [];
        foreach (TaxValuesService::shippingFeeKeys() as $key => $meta) {
            $rules[$key] = 'required|numeric|min:0|max:99999';
        }
        $request->validate($rules);

        foreach (TaxValuesService::shippingFeeKeys() as $key => $meta) {
            $taxValues->set($key, (string) $request->input($key), $meta['label']);
        }

        return redirect()
            ->route('tenant_setting_tax_fees_shipping')
            ->with('success', 'Shipping quote charges saved.');
    }

    public function manage_tax_fees_sales_tax(Request $request, SalesTaxCountiesService $salesTaxCounties)
    {
        app(TaxValuesService::class)->ensureDefaults();
        $salesTaxCounties->ensureFloridaDefaults();

        $perPage = TenantListPaginator::perPage($request, [10, 25, 50, 100], 10);
        $search = TenantListPaginator::search($request);

        $query = SalesTaxCounty::query()
            ->select(['id', 'counties', 'state_id', 'tax'])
            ->orderBy('id');
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('counties', 'like', '%'.$search.'%');
                if (is_numeric($search)) {
                    $q->orWhere('id', (int) $search);
                }
            });
        }

        $counties = $query->paginate($perPage)->withQueryString();
        $stateName = 'Florida';

        return view('tenants.setting.manage_tax_fees_sales_tax', compact('counties', 'stateName', 'perPage', 'search'));
    }

    public function edit_tax_fees_sales_tax(string $id)
    {
        $county = SalesTaxCounty::query()->findOrFail($id);
        $stateName = 'Florida';

        return view('tenants.setting.manage_tax_fees_sales_tax_edit', compact('county', 'stateName'));
    }

    public function update_tax_fees_sales_tax(Request $request, string $id)
    {
        $county = SalesTaxCounty::query()->findOrFail($id);

        $validated = $request->validate([
            'sales_tax_amount' => 'required|numeric|min:0|max:100',
        ]);

        $county->update(['tax' => (float) $validated['sales_tax_amount']]);

        return redirect()
            ->route('tenant_setting_tax_fees_sales_tax')
            ->with('success', 'Sales tax updated for '.$county->counties.'.');
    }

    /** @deprecated Use per-county edit on the sales tax list. */
    public function store_tax_fees_sales_tax(Request $request)
    {
        return redirect()->route('tenant_setting_tax_fees_sales_tax');
    }

    public function manage_tax_fees_paytrace(TaxValuesService $taxValues)
    {
        $taxValues->ensureDefaults();

        return view('tenants.setting.manage_tax_fees_paytrace', [
            'values' => $this->taxFeeValues($taxValues, TaxValuesService::paytraceKeys()),
        ]);
    }

    public function store_tax_fees_paytrace(Request $request, TaxValuesService $taxValues)
    {
        $request->validate([
            'paytrace_env' => 'required|in:sandbox,production',
            'paytrace_base_url' => 'nullable|string|max:255',
            'paytrace_integrator_id' => 'nullable|string|max:64',
            'paytrace_username' => 'nullable|string|max:255',
            'paytrace_password' => 'nullable|string|max:255',
        ]);

        foreach (TaxValuesService::paytraceKeys() as $key => $meta) {
            if ($key === 'paytrace_password' && ! $request->filled('paytrace_password')) {
                continue;
            }
            if ($request->has($key)) {
                $taxValues->set($key, (string) $request->input($key, ''), $meta['label']);
            }
        }

        return redirect()
            ->route('tenant_setting_tax_fees_paytrace')
            ->with('success', 'Paytrace settings saved.');
    }

    /** @deprecated Use tab-specific store routes. */
    public function store_tax_fees(Request $request, TaxValuesService $taxValues)
    {
        return $this->store_tax_fees_payment($request, $taxValues);
    }

    /** @return array<string, string|null> */
    private function taxFeeValues(TaxValuesService $taxValues, array $keys): array
    {
        $values = [];
        foreach ($keys as $key => $meta) {
            $values[$key] = $taxValues->get($key, $meta['default']);
        }

        return $values;
    }

    public function manage_commission(PointFactorDefaultsService $pointFactorDefaults)
    {
        if (PointFactorDefault::query()->count() === 0) {
            $pointFactorDefaults->syncFromCiConfig();
        }

        $roles = Role::query()
            ->whereNotIn('name', ['admin', 'customers'])
            ->orderBy('name')
            ->get();

        $defaultsByRole = [];
        foreach ($roles as $role) {
            $defaultsByRole[$role->name] = $pointFactorDefaults->defaultForRole($role->name);
        }

        $defaults = PointFactorDefault::query()
            ->pluck('point_factor_percentage', 'user_type');

        return view('tenants.setting.manage_commission', compact('roles', 'defaults', 'defaultsByRole'));
    }

    public function store_commission_defaults(Request $request)
    {
        $validated = $request->validate([
            'defaults' => 'required|array',
            'defaults.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['defaults'] as $userType => $pct) {
            if ($pct === null || $pct === '') {
                continue;
            }

            PointFactorDefault::query()->updateOrCreate(
                [
                    'tenant_id' => tenant('id'),
                    'user_type' => $userType,
                ],
                ['point_factor_percentage' => $pct]
            );
        }

        return redirect()
            ->route('tenant_setting_commission')
            ->with('success', 'Default point factors saved.');
    }

    public function update_commission_role(Request $request, string $role): JsonResponse
    {
        $validated = $request->validate([
            'default_factor' => 'required|numeric|min:0',
        ]);

        $roleKey = tenant_role_factor_key(urldecode($role));

        PointFactorDefault::query()->updateOrCreate(
            [
                'tenant_id' => tenant('id'),
                'user_type' => $roleKey,
            ],
            ['point_factor_percentage' => $validated['default_factor']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Saved',
            'role' => $roleKey,
            'default_factor' => (float) $validated['default_factor'],
            'percent' => round((float) $validated['default_factor'] * 100, 2),
        ]);
    }



    public function manage_document()
    {
        return view('tenants.setting.manage_document');
    }


    public function manage_stmp()
    {
        return redirect()->route('tenant_setting_email_settings');
    }

    public function email_settings()
    {
        app(ManageEmailsContentService::class)->ensureDefaults();

        return view('tenants.setting.email_settings');
    }

    public function manage_email()
    {
        return redirect()->route('tenant_setting_email_settings', ['tab' => 'content']);
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
    $settings = SiteSetting::forCurrentTenant();
    return view('tenants.setting.manage_home_list', compact('settings'));
}


    public function home_list_edit(string $id)
    {
        $settings = SiteSetting::forCurrentTenant();
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
        $pages = ManageOtherPageContent::query()
            ->orderBy('id')
            ->paginate(tenant_list_per_page())
            ->withQueryString();

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
