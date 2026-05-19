<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TenantBulletinController;
use App\Http\Controllers\TenantClaimController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantOrderController;
use App\Http\Controllers\TenantProfileController;
use App\Http\Controllers\TenantRoleController;
use App\Http\Controllers\TenantUserController;
use App\Http\Controllers\TenantProductController;
use App\Http\Controllers\TenantProductCatalogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TenantResourceController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ManageRoleController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Pinnacle\ContactController as PinnacleContactController;
use App\Http\Controllers\Pinnacle\MarketingController;


foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        // your actual routes

        Route::get('/check-google-api', function () {
            // $apiKey = config('services.google.maps_api_key');
            // dd($apiKey);
            $url2 = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=test&key=AIzaSyCZDgTTb7vm0co-2yHGinkgSs_yDTNtbSo";
            // $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=test&key={$apiKey}";

            try {
                $client = new \GuzzleHttp\Client(['verify' => false]);
                $response = $client->get($url2);
                return response()->json(json_decode($response->getBody()->getContents(), true));
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });

        Route::get('/clear-cache', function() {
            Artisan::call('config:cache');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            return "Cache is cleared";
        })->name('clear.cache');

        /*** Authentiction Route */
        Route::get('/', [MarketingController::class, 'home'])->name('/');
        Route::get('/services', [MarketingController::class, 'services'])->name('pinnacle.services');
        Route::redirect('/features', '/services', 301);
        Route::redirect('/pricing', '/services', 301);
        Route::get('/team-cabinets', [MarketingController::class, 'teamCabinets'])->name('pinnacle.team-cabinets');
        Route::get('/contact', [MarketingController::class, 'contact'])->name('pinnacle.contact');
        Route::post('/contact', [PinnacleContactController::class, 'send'])->name('pinnacle.contact.send');
        Route::get('/find-tenant', [PinnacleContactController::class, 'findTenant'])->name('pinnacle.find-tenant');
        Route::post('/find-tenant', [PinnacleContactController::class, 'findTenantLookup'])->name('pinnacle.find-tenant.lookup');
        Route::get('/privacy', [MarketingController::class, 'privacy'])->name('pinnacle.privacy');
        Route::get('/terms', [MarketingController::class, 'terms'])->name('pinnacle.terms');
        Route::get('/cookies', [MarketingController::class, 'cookies'])->name('pinnacle.cookies');
        Route::get('/subscription-terms', [MarketingController::class, 'subscriptionTerms'])->name('pinnacle.subscription-terms');
    //    Route::get('/registeration',function(){
    //     return view('auth.register');
    //    });

    Route::get('/get-states/{country_id}', [TenantController::class, 'getStates']);
Route::get('/get-cities/{state_id}', [TenantController::class, 'getCities']);

Route::get('/registeration', [TenantController::class, 'showTenantRegistrationForm'])->name('registeration');
Route::post('/tenant/register/save', [TenantController::class, 'register_tenant'])->name('pinnacle_tenant_register');
                Route::post('/stripe/webhook', [\App\Http\Controllers\Billing\StripeCheckoutController::class, 'webhook'])->name('stripe.webhook');

    // Route::get('/',function(){
    //     return redirect()->route('auth_login');
    // })->name('/');
    Route::middleware('guest')->group(function () {

        Route::get('/super-user/login', [AuthController::class, 'login'])->name('auth_login');
        Route::post('/super-user/post-login', [AuthController::class, 'postLogin'])->name('login_post');
    });






        Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth_logout');

        Route::middleware('auth', 'verified', 'master.user')->group(function ()
        {



                Route::get('/super-user/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
                Route::resource('product_catalogs', ProductController::class);
                /*** Tenant Register Form */

                /****Roles & Permissions Routes */
                Route::resource('roles', RoleController::class);
                Route::resource('users', UserController::class);

                /*** Profile Routes */
                Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
                Route::post('edit/profile', [ProfileController::class, 'editProfile'])->name('edit_profile');
                Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change_password');
                Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile_update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

                /***** Global Admin Tenant Routes */
                Route::get('/tenant/index', [TenantController::class, 'index'])->name('tenant_index');
                Route::redirect('/tenants', '/tenant/index')->name('tenants.index');
                Route::get('/tenants/create', [TenantResourceController::class, 'create'])->name('tenants.create');
                Route::post('/tenants', [TenantResourceController::class, 'store'])->name('tenants.store');
                Route::patch('/tenants/{tenant}/subscription', [\App\Http\Controllers\Admin\TenantSubscriptionController::class, 'update'])
                    ->name('admin.tenants.subscription.update');
                Route::get('/check/permission', [UserController::class, 'checkAuthPermissions'])->name('checkAuthPermissions');

                /**** Pinnacle Tenants routes */
                // Route::prefix('tenants')->group(function () {
                //     Route::get('index', [TenantController::class, 'tenant_index'])->name('tenant_index');
                //     Route::get('products/index', [ProductController::class, 'index'])->name('tenant_product_index');
                //     Route::get('products/create', [ProductController::class, 'create'])->name('tenant_product_create');
                //     Route::get('users/index', [TenantUserController::class, 'index'])->name('tenant_user_index');
                //     Route::get('users/create', [TenantUserController::class, 'create'])->name('tenant_user_create');
                //     Route::get('index', [TenantController::class, 'tenant_index'])->name('tenant_tenant_index');
                //     Route::get('index', [TenantController::class, 'tenant_index'])->name('tenant_tenant_index');
                // });

        require __DIR__.'/auth.php';
        });
    });
}

