<?php

declare(strict_types=1);

use App\Http\Controllers\ManageRoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TenantAuthController;
use App\Http\Controllers\TenantBulletinController;
use App\Http\Controllers\TenantClaimController;
use App\Http\Controllers\TenantCommissionReportController;
use App\Http\Controllers\HomeSettingsController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantCreateOrderController;
use App\Http\Controllers\TenantOrderController;
use App\Http\Controllers\TenantProfileController;
use App\Http\Controllers\TenantRoleController;
use App\Http\Controllers\TenantUserController;
use App\Http\Controllers\TenantProductController;
use App\Http\Controllers\TenantProductCatalogController;
use App\Http\Controllers\TenantProductSectionController;
use App\Http\Controllers\ProductDoorstyleController;
use App\Http\Controllers\TenantQuotesController;
use App\Http\Controllers\TenantSessionCartController;
use App\Http\Controllers\TenantSettingController;
use App\Http\Controllers\TenantQuickBooksController;
use App\Http\Controllers\TenantShippingQuoteController;
use App\Http\Controllers\TenantStockCheckController;
use App\Http\Controllers\TenantNotificationController;
use App\Http\Controllers\UserColumnPreferenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\TenantPageController;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/tenant-dashboard', function () {
        return redirect()->route('tenant_dashboard');
        // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    })->name(('tenant'));




    Route::middleware(['guest'])->group(function () {
        Route::get('login', [TenantAuthController::class,'index'])->name('tenant_login');
        Route::get('forgot/username', [TenantAuthController::class, 'forgot_username'])->name('tenant_forgot_username');
        Route::post('forgot/username', [TenantAuthController::class, 'sendForgotUsername'])->name('tenant_forgot_username_send');
        Route::get('forgot/password', [TenantAuthController::class, 'forgot_password'])->name('tenant_forgot_password');
        Route::post('forgot/password', [TenantAuthController::class, 'sendTenantResetLink'])->name('tenant_forgot_password_link');
    // password reset form
    // Show reset password form
    Route::get('/show-resetform/{token}', [TenantAuthController::class, 'showResetForm'])
      ->name('tenant.password.reset');

    // reset password
    Route::post('/reset-password-update', [TenantAuthController::class, 'resetPassword'])
      ->name('tenant.password.update');

    Route::post('post-login', [TenantAuthController::class, 'postLogin'])->name('tenant_login_post');
        Route::get('registration', [TenantAuthController::class, 'registration'])->name('tenant_register');
        Route::post('post-registration', [TenantAuthController::class, 'postRegistration'])->name('tenant_register_post');
    /// OTP routes
    Route::get('verify-otp', [TenantAuthController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('verify-otp', [TenantAuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    Route::post('resend-otp', [TenantAuthController::class, 'resendOtp'])->name('otp.resend');
    });



  // routes/web.php







Route::get('/{slug?}', [\App\Http\Controllers\TenantPageController::class, 'show'])->name('cms.page');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

    Route::middleware(['auth', 'tenant.auth'])->group(function () {
        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('tenant_logout');
        Route::get('/subscription-required', function () {
            return view('tenants.billing.subscription-required');
        })->name('tenant.subscription.required');

        Route::get('/billing/checkout', [\App\Http\Controllers\Billing\StripeCheckoutController::class, 'checkout'])
            ->name('tenant.billing.checkout');
        Route::get('/billing/success', [\App\Http\Controllers\Billing\StripeCheckoutController::class, 'success'])
            ->name('tenant.billing.success');
        Route::get('/billing/cancel', [\App\Http\Controllers\Billing\StripeCheckoutController::class, 'cancel'])
            ->name('tenant.billing.cancel');
    });

         /**** Pinnacle Tenants routes */
         Route::prefix('tenants')->middleware(['auth', 'tenant.auth', 'tenant.subscribed'])->group(function () {


         Route::get('website-designing/about', [TenantPageController::class, 'editAbout'])->name('tenant_storefront_about');
         Route::get('website-designing/blog', [TenantPageController::class, 'blogManage'])->name('tenant_storefront_blog');
         Route::resource('pages', TenantPageController::class);



         Route::get('/dashboard', [TenantController::class, 'tenant_dashboard'])->name('tenant_dashboard');
         Route::post('/dashboard/order-tracker', [\App\Http\Controllers\TenantDashboardTrackerController::class, 'update'])
             ->name('tenant_dashboard_tracker_update');
         Route::post('/dashboard/order-tracker/viewed', [\App\Http\Controllers\TenantDashboardTrackerController::class, 'markViewed'])
             ->name('tenant_dashboard_tracker_viewed');
         Route::get('/panel-search', \App\Http\Controllers\TenantPanelSearchController::class)->name('tenant_panel_search');
         Route::view('coming-soon', 'errors.coming-soon')->name('coming_soon');

         Route::get('/notifications', [TenantNotificationController::class, 'index'])->name('tenant_notifications_index');
         Route::get('/notifications/poll', [TenantNotificationController::class, 'poll'])->name('tenant_notifications_poll');
         Route::post('/notifications/read-all', [TenantNotificationController::class, 'markAllRead'])->name('tenant_notifications_read_all');
         Route::post('/notifications/{id}/read', [TenantNotificationController::class, 'markRead'])->name('tenant_notifications_read');


         Route::post('import', [TenantUserController::class, 'importCSV'])->name('users_import_csv');

         /*** export and import user route */
           // import route
         Route::post('import/save', [TenantUserController::class, 'import'])->name('users.import'); // Handle POST request for file upload
         //    export route
         Route::get('export', [TenantUserController::class, 'export'])->name('users.export');
         // import route
         Route::post('/save-user-column-order', [UserColumnPreferenceController::class, 'store'])->name('save_user_column_order');

        /*** Profile Routes */
         Route::get('/profile/step_1', [TenantProfileController::class, 'step_1'])->name('tenant_profile_step_1');
         Route::get('/profile/step_2', [TenantProfileController::class, 'step_2'])->name('tenant_profile_step_2');
         Route::get('/profile/step_3', [TenantProfileController::class, 'step_3'])->name('tenant_profile_step_3');
         Route::get('/profile', [TenantProfileController::class, 'profile'])->name('tenant_profile');
         Route::post('/profile', [TenantProfileController::class, 'updateProfile'])->name('tenant_profile_update');
         Route::post('/profile/password', [TenantProfileController::class, 'updatePassword'])->name('tenant_profile_password');

        /*** Users Routes */
         Route::get('users/index', [TenantUserController::class, 'index'])->name('tenant_user_index');
         Route::get('users/child/index', [TenantUserController::class, 'role_child'])->name('tenant_user_child_index');
         Route::get('users/child/create', [TenantUserController::class, 'child_create'])->name('tenant_user_child_create');
         Route::get('/users/search', [TenantUserController::class, 'search'])->name('tenant_user_search');
         Route::get('users/role/autocomplete', [TenantUserController::class, 'roleAutoComplete'])->name('tenant_role_autocomplete');
         Route::get('users/child/role/autocomplete', [TenantUserController::class, 'childRoleAutoComplete'])->name('tenant_child_role_autocomplete');
         Route::get('users/country/autocomplete', [TenantUserController::class, 'countryAutoComplete'])->name('tenant_country_autocomplete');
         Route::get('users/state/autocomplete', [TenantUserController::class, 'stateAutoComplete'])->name('tenant_state_autocomplete');
         Route::get('users/city/autocomplete', [TenantUserController::class, 'cityAutoComplete'])->name('tenant_city_autocomplete');
         Route::get('users/county/autocomplete', [TenantUserController::class, 'countyAutoComplete'])->name('tenant_county_autocomplete');
         Route::get('users/create', [TenantUserController::class, 'create'])->name('tenant_user_create');
         Route::post('users/submit/record', [TenantUserController::class, 'store'])->name('tenant_user_store');
         Route::post('users/child/store', [TenantUserController::class, 'childStore'])->name('tenant_child_user_store');
         Route::get('users/{id}/edit', [TenantUserController::class, 'edit'])->name('tenant_user_edit');
         Route::get('users/{id}/show', [TenantUserController::class, 'show'])->name('tenant_user_show');
         Route::get('users/child/{id}/show', [TenantUserController::class, 'showChild'])->name('tenant_child_user_show');
         Route::get('/users/{id}/details', [TenantUserController::class, 'showDetails'])->name('user.details');
         Route::put('users/{id}', [TenantUserController::class, 'update'])->name('tenant_user_update');
         Route::delete('users/{id}', [TenantUserController::class, 'destroy'])->name('tenant_user_destroy');
         Route::post('/users/{id}/status', [TenantUserController::class, 'updateStatus'])->name('tenant_users_update_status');
         Route::get('users/deleted/list', [TenantUserController::class, 'deletedUsersList'])->name('tenant_deleted_users_list');
         Route::get('users/child/deleted/list', [TenantUserController::class, 'deletedChildUsersList'])->name('tenant_deleted_users_child_list');
         Route::get('users/{id}/restore', [TenantUserController::class, 'restoreDeletedUser'])->name('tenant_user_restore');
         Route::get('/download-csv', [TenantUserController::class, 'downloadCSV'])->name('download.csv');
         Route::post('/tenant/users/{id}/verify', [TenantUserController::class, 'updateVerification'])
    ->name('tenant_users_update_verification');

        /***Roles Routes */

          Route::get('roles/index', [TenantRoleController::class, 'index'])->name('tenant_role_index');
          Route::get('roles/create', [TenantRoleController::class, 'create'])->name('tenant_role_create');
          Route::post('roles', [TenantRoleController::class, 'store'])->name('tenant_role_store');
          Route::get('roles/{id}/edit', [TenantRoleController::class, 'edit'])->name('tenant_role_edit');
          Route::get('roles/{id}/show', [TenantRoleController::class, 'show'])->name('tenant_role_show');
          Route::put('roles/{id}', [TenantRoleController::class, 'update'])->name('tenant_role_update');
          Route::delete('roles/{id}', [TenantRoleController::class, 'destroy'])->name('tenant_role_destroy');
        /*** export and import Role route */

            Route::get('roles/export', [TenantRoleController::class, 'role_export'])->name('role.export');
            Route::post('roles/import', [TenantRoleController::class, 'role_import'])->name('role.import'); // Handle POST request for file upload

        /*** Products Routes */

           Route::get('products/hub', function () {
               return view('tenants.products.hub');
           })->name('tenant_products_hub');
           Route::get('/products/search', [TenantProductCatalogController::class, 'search'])->name('tenant_product_search');
           Route::get('products/index', [TenantProductController::class, 'index'])->name('tenant_product_index');
           Route::get('products/create', [TenantProductController::class, 'create'])->name('tenant_product_create');
           Route::post('products/store', [TenantProductController::class, 'store'])->name('tenant_product_store');
           Route::get('products/{id}/edit', [TenantProductController::class, 'edit'])->name('tenant_product_edit');
           Route::get('products/{id}/show', [TenantProductController::class, 'show'])->name('tenant_product_show');
           Route::post('products/{id}', [TenantProductController::class, 'update'])->name('tenant_product_update');
           Route::get('products/{id}', [TenantProductController::class, 'destroy'])->name('tenant_product_destroy');
           Route::get('products/deleted/list', [TenantProductController::class, 'deletedproductList'])->name('tenant_deleted_products_list');
           Route::get('products/{id}/restore', [TenantProductController::class, 'restoreDeletedproducts'])->name('tenant_products_restore');
       /*** export and import products route */

           Route::get('product/export', [TenantProductController::class, 'product_export'])->name('product.export');
           Route::post('product/import', [TenantProductController::class, 'product_import'])->name('product.import'); // Handle POST request for file upload

        /*** Products Catalog Routes */

           Route::get('/product-catalog/search', [TenantProductCatalogController::class, 'search'])->name('tenant_product_catalog_search');
           Route::get('products/catalog/index', [TenantProductCatalogController::class, 'index'])->name('tenant_product_catalog_index');
           Route::get('products/catalog/create', [TenantProductCatalogController::class, 'create'])->name('tenant_product_catalog_create');
           Route::post('products/catalogs/store', [TenantProductCatalogController::class, 'store'])->name('tenant_product_catalog_store');
           Route::get('products/catalog/{id}/edit', [TenantProductCatalogController::class, 'edit'])->name('tenant_product_catalog_edit');
           Route::get('products/catalog/{id}/show', [TenantProductCatalogController::class, 'show'])->name('tenant_product_catalog_show');
           Route::post('products/catalog/{id}', [TenantProductCatalogController::class, 'update'])->name('tenant_product_catalog_update');
           Route::get('products/catalog/{id}', [TenantProductCatalogController::class, 'destroy'])->name('tenant_product_catalog_destroy');
           Route::get('products_catalog/deleted/list', [TenantProductCatalogController::class, 'deletedproductcatalogList'])->name('tenant_deleted_product_catalog_list');
           Route::get('products_catalog/{id}/restore', [TenantProductCatalogController::class, 'restoreDeletedproductcatalog'])->name('tenant_product_catalog_restore');

        /*** export and import product catalog route */

          Route::get('product_catalog/export', [TenantProductCatalogController::class, 'product_catalog_export'])->name('product_catalog_export');
          Route::post('product_catalog/import', [TenantProductCatalogController::class, 'product_catalog_import'])->name('product_catalog_import'); // Handle POST request for file upload



        /*** Orders Routes */

          Route::get('orders/index', [TenantOrderController::class, 'index'])->name('tenant_order_list');
          Route::get('orders/workspace', [TenantCreateOrderController::class, 'catalog'])->name('tenant_order_workspace');
          Route::get('orders/workspace/catalog/{catalog}/build', [TenantCreateOrderController::class, 'build'])->name('tenant_order_workspace_build');
          Route::post('orders/workspace/catalog/{catalog}/door/{door}/accordion-search', [TenantCreateOrderController::class, 'accordionSearch'])->name('tenant_order_workspace_accordion_search');
          Route::post('orders/workspace/catalog/{catalog}/cart-autosave', [TenantCreateOrderController::class, 'autoSaveCart'])->name('tenant_order_workspace_cart_autosave');
          Route::get('orders/workspace/catalog/{catalog}/clear-cart', [TenantCreateOrderController::class, 'clearCart'])->name('tenant_order_workspace_clear_cart');
          Route::post('orders/workspace/print', [TenantCreateOrderController::class, 'storePrint'])->name('tenant_order_workspace_print');
          Route::post('orders/workspace/process', [TenantCreateOrderController::class, 'storeProcess'])->name('tenant_order_workspace_process');
          Route::get('orders/workspace/checkout', [TenantCreateOrderController::class, 'checkout'])->name('tenant_order_workspace_checkout');
          Route::get('orders/workspace/checkout/sales-tax', [TenantCreateOrderController::class, 'checkoutSalesTax'])->name('tenant_order_workspace_checkout_sales_tax');
          Route::post('orders/workspace/checkout', [TenantCreateOrderController::class, 'checkoutSubmit'])->name('tenant_order_workspace_checkout_submit');
          Route::get('orders/workspace/{id}/print', [TenantCreateOrderController::class, 'printOrder'])->name('tenant_order_workspace_print_page');
          Route::get('orders/workspace/catalog/{catalog}/doors', [TenantCreateOrderController::class, 'doors'])->name('tenant_order_workspace_doors');
          Route::get('orders/workspace/catalog/{catalog}/door/{door}', [TenantCreateOrderController::class, 'buildLegacyDoorUrl'])->name('tenant_order_workspace_build_legacy');
          Route::get('orders/workspace/catalog/{catalog}/door/{door}/search', [TenantCreateOrderController::class, 'searchProducts'])->name('tenant_order_workspace_search');
          Route::post('orders/workspace/store', [TenantCreateOrderController::class, 'storeOrder'])->name('tenant_order_workspace_store');
          Route::post('orders/workspace/quote', [TenantCreateOrderController::class, 'storeQuote'])->name('tenant_order_workspace_quote');
          Route::post('orders/workspace/shipping-quote', [TenantCreateOrderController::class, 'storeShippingQuote'])->name('tenant_order_workspace_shipping_quote');
          Route::post('orders/workspace/stock-check', [TenantCreateOrderController::class, 'storeStockCheck'])->name('tenant_order_workspace_stock_check');
          Route::get('orders/create', [TenantOrderController::class, 'create'])->name('tenant_order_create_static');
          Route::get('orders/create/1', [TenantOrderController::class, 'create_step_1'])->name('tenant_order_create');
          Route::get('orders/create/2/{id}', [TenantOrderController::class, 'create_step_2'])->name('tenant_order_create_step_2');
          Route::get('orders/create/3/{catalog_id}/{door_id}', [TenantOrderController::class, 'create_step_3'])->name('tenant_order_create_step_3');
          Route::get('orders/create/search', [TenantOrderController::class, 'search'])->name('tenant_order_create_search');
          Route::get('orders/create/{id}/step-2', [TenantOrderController::class, 'step_2'])->name('tenant_order_step_2');
          Route::post('orders', [TenantOrderController::class, 'store'])->name('tenant_order_store');
          Route::get('orders/{id}/edit', [TenantOrderController::class, 'edit'])->name('tenant_order_edit');
          Route::get('orders/{id}/show', [TenantOrderController::class, 'show'])->name('tenant_order_show');
          Route::put('orders/{id}', [TenantOrderController::class, 'update'])->name('tenant_order_update');
          Route::delete('orders/{id}', [TenantOrderController::class, 'destroy'])->name('tenant_order_destroy');
          Route::get('orders/deleted/list', [TenantOrderController::class, 'deletedorderList'])->name('tenant_deleted_order_list');
          Route::get('orders/{id}/restore', [TenantOrderController::class, 'restoreDeletedorder'])->name('tenant_order_restore');

             /*** export and import order route */

            Route::get('order/export', [TenantOrderController::class, 'order_export'])->name('order_export');
            Route::post('order/import', [TenantOrderController::class, 'order_import'])->name('order_import');

            /*** Cart Routes (session cart — used by order workspace / legacy step-3 flows) */

            Route::post('/cart/saveJobName', [TenantSessionCartController::class, 'saveJobName'])->name('cart.saveJobName');
            Route::post('/cart/addRoom', [TenantSessionCartController::class, 'addRoom'])->name('cart.addRoom');
            Route::post('/cart/removeRoom', [TenantSessionCartController::class, 'removeRoom'])->name('cart.removeRoom');
            Route::post('/cart/addProduct', [TenantSessionCartController::class, 'addProduct'])->name('cart.addProduct');
            Route::post('/cart/removeProduct', [TenantSessionCartController::class, 'removeProduct'])->name('cart.removeProduct');
            Route::post('/cart/clearCart', [TenantSessionCartController::class, 'clearCart'])->name('cart.clearCart');
            Route::post('/cart/saveTotals', [TenantSessionCartController::class, 'saveTotals'])->name('cart.saveTotals');
            Route::get('/cart/getCart', [TenantSessionCartController::class, 'getCart'])->name('cart.getCart');
           /*** claims Routes */

         Route::get('claims/index', [TenantClaimController::class, 'index'])->name('tenant_claim_index');
         Route::get('claims/create', [TenantClaimController::class, 'create'])->name('tenant_claim_create');
         Route::post('claims', [TenantClaimController::class, 'store'])->name('tenant_claim_store');
         Route::get('claims/{id}/edit', [TenantClaimController::class, 'edit'])->name('tenant_claim_edit');
         Route::get('claims/{id}/show', [TenantClaimController::class, 'show'])->name('tenant_claim_show');
         Route::put('claims/{id}', [TenantClaimController::class, 'update'])->name('tenant_claim_update');
         Route::delete('claims/{id}', [TenantClaimController::class, 'destroy'])->name('tenant_claim_destroy');
         Route::get('claims/deleted/list', [TenantClaimController::class, 'deletedclaimList'])->name('tenant_deleted_claim_list');
         Route::get('claims/{id}/restore', [TenantClaimController::class, 'restoreDeletedclaim'])->name('tenant_claim_restore');

         /*** Bulletins Routes */

         Route::get('bulletins/index', [TenantBulletinController::class, 'index'])->name('tenant_bulletin_index');
         Route::get('bulletins/create', [TenantBulletinController::class, 'create'])->name('tenant_bulletin_create');
         Route::post('bulletins', [TenantBulletinController::class, 'store'])->name('tenant_bulletin_store');
         Route::get('bulletins/{id}/edit', [TenantBulletinController::class, 'edit'])->name('tenant_bulletin_edit');
         Route::get('bulletins/{id}/show', [TenantBulletinController::class, 'show'])->name('tenant_bulletin_show');
         Route::post('bulletins/{id}', [TenantBulletinController::class, 'update'])->name('tenant_bulletin_update');
         Route::get('bulletins/{id}', [TenantBulletinController::class, 'destroy'])->name('tenant_bulletin_destroy');
         Route::get('bulletins/deleted/list', [TenantBulletinController::class, 'deletedbulletinList'])->name('tenant_deleted_bulletin_list');
         Route::get('bulletins/{id}/restore', [TenantBulletinController::class, 'restoreDeletedbulletin'])->name('tenant_bulletin_restore');

           /*** export and import bulletins route */

         Route::get('bulletin/export', [TenantBulletinController::class, 'bulletin_export'])->name('bulletin_export');
         Route::post('bulletin/import', [TenantBulletinController::class, 'bulletin_import'])->name('bulletin_import'); // Handle POST request for file upload

           /*** manage role Routes */

         Route::get('manage_role/index', [ManageRoleController::class, 'index'])->name('tenant_manage_role_index');
         Route::get('manage_role/create', [ManageRoleController::class, 'create'])->name('tenant_manage_role_create');
         Route::post('manage_role', [ManageRoleController::class, 'store'])->name('tenant_manage_role_store');
         Route::get('manage_role/{id}/edit', [ManageRoleController::class, 'edit'])->name('tenant_manage_role_edit');
         Route::get('manage_role/{id}/show', [ManageRoleController::class, 'show'])->name('tenant_manage_role_show');
         Route::put('manage_role/{id}', [ManageRoleController::class, 'update'])->name('tenant_manage_role_update');
         Route::delete('manage_role/{id}', [ManageRoleController::class, 'destroy'])->name('tenant_manage_role_destroy');

         /*** Products section  Routes */

         Route::get('products_section/index', [TenantProductSectionController::class, 'index'])->name('tenant_product_section_index');
         Route::get('products_section/create', [TenantProductSectionController::class, 'create'])->name('tenant_product_section_create');
         Route::post('products_section', [TenantProductSectionController::class, 'store'])->name('tenant_product_section_store');
         Route::get('products_section/{id}/edit', [TenantProductSectionController::class, 'edit'])->name('tenant_product_section_edit');
         Route::get('products_section/{id}/show', [TenantProductSectionController::class, 'show'])->name('tenant_product_section_show');
         Route::get('products_section/deleted/list', [TenantProductSectionController::class, 'deletedproductsectionList'])->name('tenant_deleted_product_section_list');
         Route::get('products_section/{id}/restore', [TenantProductSectionController::class, 'restoreDeletedproductsection'])->name('tenant_product_section_restore');
         Route::get('products_section/{id}', [TenantProductSectionController::class, 'destroy'])->name('tenant_products_section_destroy');
         Route::get('products_section/{id}/update', [TenantProductSectionController::class, 'update'])->name('tenant_product_section_update');

         Route::get('door_style/index', [ProductDoorstyleController::class, 'index'])->name('tenant_door_style_index');
         Route::get('door_style/create', [ProductDoorstyleController::class, 'create'])->name('tenant_door_style_create');
         Route::post('door_style', [ProductDoorstyleController::class, 'store'])->name('tenant_door_style_store');
         Route::get('door_style/{id}/edit', [ProductDoorstyleController::class, 'edit'])->name('tenant_door_style_edit');
         Route::get('door_style/{id}/show', [ProductDoorstyleController::class, 'show'])->name('tenant_door_style_show');

         // ✅ Correct DELETE route
         Route::post('door_style/{id}', [ProductDoorstyleController::class, 'destroy'])->name('tenant_door_style_destroy');

         // Optional: Restore and soft-deleted listing
         Route::get('door_style/deleted/list', [ProductDoorstyleController::class, 'deletedproductsectionList'])->name('tenant_door_style_delete');
         Route::get('door_style/{id}/restore', [ProductDoorstyleController::class, 'restoreDeletedproductsection'])->name('tenant_door_style_restore');



         Route::post('door_style/{id}/update', [ProductDoorstyleController::class, 'update'])->name('tenant_door_style_update');

         /*** export and import user route */

         Route::get('product_section/export', [TenantProductSectionController::class, 'product_section_export'])->name('product_section.export');
         Route::post('product_section/import', [TenantProductSectionController::class, 'product_section_import'])->name('product_section_import'); // Handle POST request for file upload

          /*** Setting  Routes */

          Route::get('setting/hub', function () {
              return redirect()->route('tenant_site_setting');
          })->name('tenant_settings_hub');

          Route::get('setting/profile', [TenantProfileController::class, 'settingsProfile'])->name('tenant_setting_profile');
          Route::post('setting/profile', [TenantProfileController::class, 'updateSettingsProfile'])->name('tenant_setting_profile_update');
          Route::post('setting/profile/password', [TenantProfileController::class, 'updatePassword'])->name('tenant_setting_profile_password');

          Route::get('setting/website-designing', [TenantSettingController::class, 'website_designing'])->name('tenant_website_designing');

          Route::get('setting/home-setting', [HomeSettingsController::class, 'index'])->name('tenant_home_setting_index');
          Route::post('setting/home-setting-store', [HomeSettingsController::class, 'home_setting_store'])->name('tenant_home_setting_srore');
          Route::get('setting/index', [TenantSettingController::class, 'index'])->name('tenant_setting_manage_index');
          Route::get('setting/contact-page', [TenantSettingController::class, 'contactPageSettings'])->name('tenant_contact_page_settings');
          Route::post('setting/contact-page', [TenantSettingController::class, 'storeContactPageSettings'])->name('tenant_contact_page_settings_store');
          Route::get('setting/contact-queries', [\App\Http\Controllers\TenantContactQueryController::class, 'index'])->name('tenant_contact_queries_index');
          Route::get('setting/contact-queries/{contactQuery}', [\App\Http\Controllers\TenantContactQueryController::class, 'show'])->name('tenant_contact_queries_show');
          Route::delete('setting/contact-queries/{contactQuery}', [\App\Http\Controllers\TenantContactQueryController::class, 'destroy'])->name('tenant_contact_queries_destroy');
          Route::get('setting/create', [TenantSettingController::class, 'create'])->name('tenant_setting_manage_create');
          Route::get('setting/manage_home', [TenantSettingController::class, 'manage_site_settings'])->name('tenant_site_setting');
          Route::post('setting/manage_home_store', [TenantSettingController::class, 'store_site_settings'])->name('tenant_site_settings_store');
          Route::get('setting/frontend-theme', [TenantSettingController::class, 'manage_frontend_theme'])->name('tenant_frontend_theme');
          Route::post('setting/frontend-theme', [TenantSettingController::class, 'store_frontend_theme'])->name('tenant_frontend_theme_store');
          Route::get('setting/manage_document', [TenantSettingController::class, 'manage_document'])->name('tenant_setting_manage_document');
          Route::get('setting/manage_stmp', [TenantSettingController::class, 'manage_stmp'])->name('tenant_setting_manage_stmp');
          Route::post('setting/manage_stmp_store', [TenantSettingController::class, 'manage_stmp_store'])->name('tenant_setting_manage_stmp_create');
          Route::post('setting/test_smtp', [TenantSettingController::class, 'test_smtp_connection'])->name('tenant_setting_test_smtp');
          Route::get('setting/manage_email_content', [TenantSettingController::class, 'manage_email'])->name('tenant_setting_manage_email_content');
          Route::get('setting/manage_term_condition', [TenantSettingController::class, 'manage_term_condition'])->name('tenant_setting_manage_term_condition');
          Route::get('setting/manage_tax_fees', [TenantSettingController::class, 'manage_tax_fees'])->name('tenant_setting_tax_fees');
          Route::get('setting/tax-fees/payment', [TenantSettingController::class, 'manage_tax_fees_payment'])->name('tenant_setting_tax_fees_payment');
          Route::post('setting/tax-fees/payment', [TenantSettingController::class, 'store_tax_fees_payment'])->name('tenant_setting_tax_fees_payment_store');
          Route::get('setting/tax-fees/shipping', [TenantSettingController::class, 'manage_tax_fees_shipping'])->name('tenant_setting_tax_fees_shipping');
          Route::post('setting/tax-fees/shipping', [TenantSettingController::class, 'store_tax_fees_shipping'])->name('tenant_setting_tax_fees_shipping_store');
          Route::get('setting/tax-fees/sales-tax', [TenantSettingController::class, 'manage_tax_fees_sales_tax'])->name('tenant_setting_tax_fees_sales_tax');
          Route::get('setting/tax-fees/sales-tax/{id}/edit', [TenantSettingController::class, 'edit_tax_fees_sales_tax'])->name('tenant_setting_tax_fees_sales_tax_edit');
          Route::put('setting/tax-fees/sales-tax/{id}', [TenantSettingController::class, 'update_tax_fees_sales_tax'])->name('tenant_setting_tax_fees_sales_tax_update');
          Route::post('setting/tax-fees/sales-tax', [TenantSettingController::class, 'store_tax_fees_sales_tax'])->name('tenant_setting_tax_fees_sales_tax_store');
          Route::get('setting/tax-fees/paytrace', [TenantSettingController::class, 'manage_tax_fees_paytrace'])->name('tenant_setting_tax_fees_paytrace');
          Route::post('setting/tax-fees/paytrace', [TenantSettingController::class, 'store_tax_fees_paytrace'])->name('tenant_setting_tax_fees_paytrace_store');
          Route::post('setting/manage_tax_fees_store', [TenantSettingController::class, 'store_tax_fees'])->name('tenant_setting_tax_fees_store');
          Route::get('setting/manage_commission', [TenantSettingController::class, 'manage_commission'])->name('tenant_setting_commission');
          Route::post('setting/manage_commission', [TenantSettingController::class, 'store_commission_defaults'])->name('tenant_setting_commission_store');
          Route::get('setting/manage_credit', [TenantSettingController::class, 'manage_credit'])->name('tenant_setting_manage_credit');
          Route::get('setting/manage_fuel', [TenantSettingController::class, 'manage_fuel'])->name('tenant_setting_manage_fuel');
          Route::get('quickbooks', [TenantQuickBooksController::class, 'index'])->name('tenant_quickbooks_index');
          Route::post('quickbooks/credentials', [TenantQuickBooksController::class, 'storeCredentials'])->name('tenant_quickbooks_store_credentials');
          Route::post('quickbooks/test', [TenantQuickBooksController::class, 'testConnection'])->name('tenant_quickbooks_test');
          Route::get('quickbooks/connect', [TenantQuickBooksController::class, 'connect'])->name('tenant_quickbooks_connect');
          Route::get('quickbooks/callback', [TenantQuickBooksController::class, 'callback'])->name('tenant_quickbooks_callback');
          Route::post('quickbooks/disconnect', [TenantQuickBooksController::class, 'disconnect'])->name('tenant_quickbooks_disconnect');
          Route::get('setting/manage_success', [TenantSettingController::class, 'manage_success'])->name('tenant_setting_manage_success');
          Route::get('setting', [TenantSettingController::class, 'store'])->name('tenant_setting_store');
          Route::get('setting/{id}/edit', [TenantSettingController::class, 'edit'])->name('tenant_setting_edit');
          Route::get('setting/{id}/show', [TenantSettingController::class, 'show'])->name('tenant_setting_show');

           /*** Setting List page Routes */

          Route::get('setting/manage_home_list', [TenantSettingController::class, 'manage_home_list'])->name('tenant_setting_manage_home_list');
          Route::get('setting/{id}/home_list_edit', [TenantSettingController::class, 'home_list_edit'])->name('tenant_setting_home_list_edit');
          Route::get('setting/{id}/manage_show_home', [TenantSettingController::class, 'manage_show_home'])->name('tenant_setting_manage_show_home');
          Route::get('setting/deleted/manage_home_list', [TenantSettingController::class, 'deletedmanagehomelist'])->name('tenant_deleted_manage_home_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restoredeletedmanagelist'])->name('tenant_manage_home_restore');

          Route::get('setting/manage_documentation_list', [TenantSettingController::class, 'manage_documentation_list'])->name('tenant_setting_manage_documentation_list');
          Route::get('setting/{id}/manage_documentation_edit', [TenantSettingController::class, 'manage_documentation_edit'])->name('tenant_setting_manage_documentation_edit');
          Route::get('setting/{id}/manage_documentation_show', [TenantSettingController::class, 'manage_documentation_show'])->name('tenant_setting_manage_documentation_show');
          Route::get('setting/deleted/manage_documentation_list', [TenantSettingController::class, 'deletedmanagedocumentlist'])->name('tenant_deleted_manage_document_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restoredeletedmanagedocumentlist'])->name('tenant_manage_document_restore');

          Route::get('setting/manage_stmp_list', [TenantSettingController::class, 'manage_stmp_list'])->name('tenant_setting_manage_stmp_list');
          Route::get('setting/{id}/manage_stmp_edit', [TenantSettingController::class, 'manage_stmp_edit'])->name('tenant_setting_manage_stmp_edit');
          Route::get('setting/{id}/manage_stmp_show', [TenantSettingController::class, 'manage_stmp_show'])->name('tenant_setting_manage_stmp_show');
          Route::get('setting/deleted/manage_stmp_list', [TenantSettingController::class, 'deletedmanagestmplist'])->name('tenant_deleted_manage_stmp_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restoredeletedmanagestmplist'])->name('tenant_manage_stmp_restore');

          Route::get('setting/manage_email_content_list', [TenantSettingController::class, 'manage_email_content_list'])->name('tenant_setting_manage_email_content_list');
          Route::get('setting/{id}/manage_email_content_edit', [TenantSettingController::class, 'manage_email_content_edit'])->name('tenant_setting_manage_email_content_edit');
          Route::get('setting/{id}/manage_email_content_show', [TenantSettingController::class, 'manage_email_content_show'])->name('tenant_setting_manage_email_content_show');
          Route::get('setting/deleted/manage_email_list', [TenantSettingController::class, 'deleted_manage_email_list'])->name('tenant_deleted_manage_email_content_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restoredeletedmanageemaillist'])->name('tenant_manage_email_content_restore');

          Route::get('setting/manage_term_condition_list', [TenantSettingController::class, 'manage_term_condition_list'])->name('tenant_setting_manage_term_condition_list');
          Route::get('setting/{id}/manage_term_condition_edit', [TenantSettingController::class, 'manage_term_condition_edit'])->name('tenant_setting_manage_term_condition_edit');
          Route::get('setting/{id}/manage_term_condition_show', [TenantSettingController::class, 'manage_term_condition_show'])->name('tenant_setting_manage_term_condition_show');
          Route::get('setting/deleted/manage_term_condition_list', [TenantSettingController::class, 'deleted_manage_termcondition_list'])->name('tenant_deleted_manage_term_condition_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_termcondition_list'])->name('tenant_manage_term_condition_restore');

          Route::get('setting/manage_credit_list', [TenantSettingController::class, 'manage_credit_list'])->name('tenant_setting_manage_credit_list');
          Route::get('setting/{id}/manage_credit_edit', [TenantSettingController::class, 'manage_credit_edit'])->name('tenant_setting_manage_credit_edit');
          Route::get('setting/{id}/manage_credit_show', [TenantSettingController::class, 'manage_credit_show'])->name('tenant_setting_manage_credit_show');
          Route::get('setting/deleted/manage_credit_list', [TenantSettingController::class, 'deleted_manage_credit_list'])->name('tenant_deleted_manage_credit_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_credit_list'])->name('tenant_manage_credit_restore');

          Route::get('setting/manage_fuel_list', [TenantSettingController::class, 'manage_fuel_list'])->name('tenant_setting_manage_fuel_list');
          Route::get('setting/{id}/manage_fuel_edit', [TenantSettingController::class, 'manage_fuel_edit'])->name('tenant_setting_manage_fuel_edit');
          Route::get('setting/{id}/manage_fuel_show', [TenantSettingController::class, 'manage_fuel_show'])->name('tenant_setting_manage_fuel_show');
          Route::get('setting/deleted/manage_fuel_list', [TenantSettingController::class, 'deleted_manage_fuel_list'])->name('tenant_deleted_manage_fuel_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_fuel_list'])->name('tenant_manage_fuel_restore');

          Route::get('setting/manage_success_list', [TenantSettingController::class, 'manage_success_list'])->name('tenant_setting_manage_success_list');
          Route::get('setting/{id}/manage_success_edit', [TenantSettingController::class, 'manage_success_edit'])->name('tenant_setting_manage_success_edit');
          Route::post('setting/{id}/manage_success_update', [TenantSettingController::class, 'manage_success_update'])->name('tenant_setting_manage_success_update');
          Route::get('setting/{id}/manage_success_show', [TenantSettingController::class, 'manage_success_show'])->name('tenant_setting_manage_success_show');
          Route::get('setting/deleted/manage_success_list', [TenantSettingController::class, 'deleted_manage_success_list'])->name('tenant_deleted_manage_success_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_success_list'])->name('tenant_manage_success_restore');

          Route::get('setting/manage_contact_list', [TenantSettingController::class, 'manage_contact_list'])->name('tenant_setting_manage_contact_list');
          Route::get('setting/{id}/manage_contact_edit', [TenantSettingController::class, 'manage_contact_edit'])->name('tenant_setting_manage_contact_edit');
          Route::get('setting/{id}/manage_contact_show', [TenantSettingController::class, 'manage_contact_show'])->name('tenant_setting_manage_contact_show');
          Route::get('setting/deleted/manage_contact_list', [TenantSettingController::class, 'deleted_manage_contact_list'])->name('tenant_deleted_manage_contact_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_contact_list'])->name('tenant_manage_contact_restore');

          Route::get('setting/manage_about_List', [TenantSettingController::class, 'manage_about_list'])->name('tenant_setting_manage_about_List');
          Route::get('setting/{id}/manage_about_edit', [TenantSettingController::class, 'manage_about_edit'])->name('tenant_setting_manage_about_edit');
          Route::get('setting/{id}/manage_about_show', [TenantSettingController::class, 'manage_about_show'])->name('tenant_setting_manage_about_show');
          Route::get('setting/deleted/manage_about_list', [TenantSettingController::class, 'deleted_manage_about_list'])->name('tenant_deleted_manage_about_list');
          Route::get('setting/{id}/restore', [TenantSettingController::class, 'restore_deleted_manage_about_list'])->name('tenant_manage_contact_restore');

          /*** Stock Check page Routes */

          Route::get('stock_check/index', [TenantStockCheckController::class, 'index'])->name('tenant_stock_check_index');
          Route::get('stock_check/{id}/edit', [TenantStockCheckController::class, 'edit'])->name('tenant_stock_check_edit');
          Route::get('stock_check/{id}/show', [TenantStockCheckController::class, 'show'])->name('tenant_stock_check_show');
          Route::put('stock_check/{id}', [TenantStockCheckController::class, 'update'])->name('tenant_stock_check_update');
          Route::delete('stock_check/{id}', [TenantStockCheckController::class, 'destroy'])->name('tenant_stock_check_destroy');
          Route::get('stock_check/deleted/stock_check_list', [TenantStockCheckController::class, 'deleted_stock_check_list'])->name('tenant_deleted_stock_check_list');
          Route::get('stock_check/{id}/restore', [TenantStockCheckController::class, 'restore_deleted_stock_check_list'])->name('tenant_Stock_check_restore');

        /*** Quotes page Routes */

        Route::get('quotes/index', [TenantQuotesController::class, 'index'])->name('tenant_quotes_index');
        Route::post('quotes', [TenantQuotesController::class, 'store'])->name('tenant_quotes_store');
        Route::get('quotes/{id}/edit', [TenantQuotesController::class, 'edit'])->name('tenant_quotes_edit');
        Route::get('quotes/{id}/show', [TenantQuotesController::class, 'show'])->name('tenant_quotes_show');
        Route::put('quotes/{id}', [TenantQuotesController::class, 'update'])->name('tenant_quotes_update');
        Route::delete('quotes/{id}', [TenantQuotesController::class, 'destroy'])->name('tenant_quotes_destroy');
        Route::get('quotes/deleted/quotes_list', [TenantQuotesController::class, 'deleted_quotes_list'])->name('tenant_deleted_quotes_list');
        Route::get('quotes/{id}/restore', [TenantQuotesController::class, 'restore_deleted_quotes_list'])->name('tenant_quotes_restore');

        /***Shipping  Quotes page Routes */

        Route::get('shipping_quotes/index', [TenantShippingQuoteController::class, 'index'])->name('tenant_shipping_quotes_index');
        Route::post('shipping_quotes', [TenantShippingQuoteController::class, 'store'])->name('tenant_shipping_quotes_store');
        Route::get('shipping_quotes/{id}/edit', [TenantShippingQuoteController::class, 'edit'])->name('tenant_shipping_quotes_edit');
        Route::get('shipping_quotes/{id}/show', [TenantShippingQuoteController::class, 'show'])->name('tenant_shipping_quotes_show');
        Route::post('shipping_quotes/{id}/proceed-checkout', [TenantShippingQuoteController::class, 'proceedToCheckout'])->name('tenant_shipping_quotes_proceed_checkout');
        Route::put('shipping_quotes/{id}/shipping-costs', [TenantShippingQuoteController::class, 'updateShippingCosts'])->name('tenant_shipping_quotes_update_costs');
        Route::delete('shipping_quotes/{id}', [TenantShippingQuoteController::class, 'destroy'])->name('tenant_shipping_quotes_destroy');
        Route::get('shipping_quotes/deleted/quotes_list', [TenantQuotesController::class, 'deleted_shipping_quotes_list'])->name('tenant_deleted_shipping_quotes_list');

        /*** Commission report page Routes */

        Route::get('commission_report/index', [TenantCommissionReportController::class, 'index'])->name('tenant_commission_report_index');
        Route::get('commission_report/create', [TenantCommissionReportController::class, 'create'])->name('tenant_commission_report_create');
        Route::post('commission_report', [TenantCommissionReportController::class, 'store'])->name('tenant_commission_report_store');
        Route::get('commission_report/{id}/edit', [TenantCommissionReportController::class, 'edit'])->name('tenant_commission_report_edit');
        Route::get('commission_report/{id}/show', [TenantCommissionReportController::class, 'show'])->name('tenant_commission_report_show');
        Route::put('commission_report/{id}', [TenantCommissionReportController::class, 'update'])->name('tenant_commission_report_update');
        Route::delete('commission_report/{id}', [TenantCommissionReportController::class, 'destroy'])->name('tenant_commission_report_destroy');
        Route::get('commission_report/deleted/list', [TenantCommissionReportController::class, 'deleted_commission_report_list'])->name('tenant_deleted_commission_report_list');
        Route::get('commission_report/{id}/restore', [TenantCommissionReportController::class, 'restore_deleted_commission_report_list'])->name('tenant_commission_report_restore');


    });
});



