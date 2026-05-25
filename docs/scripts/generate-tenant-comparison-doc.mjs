/**
 * CI vs Laravel Tenant comparison — Word document (same style as generate-ci-gap-doc.mjs).
 * Run: npm run generate:tenant-comparison
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { Document, Packer, HeadingLevel } from 'docx';
import { heading, para, bullet, tableFromRows, spacer } from './docx-helpers.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const outDir = path.join(__dirname, '..');

const sections = [
  heading('CodeIgniter vs Laravel Tenant — Feature & Calculation Comparison'),
  para('Project: Team Cabinets multi-tenant portal'),
  para('CI reference: ci-team-cabinets/app/Controllers/Admin.php, Manage_settings.php'),
  para('Laravel reference: team-cabinets/ (Stancl tenancy, Spatie permissions, Vue CRUD)'),
  para('Last updated: May 2026', true),

  heading('1. Architecture overview', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Aspect', 'CodeIgniter (CI)', 'Laravel tenant'],
    ['App structure', 'Single Admin.php (10k+ lines) + Manage_settings.php', 'Controllers + app/Services/*'],
    ['Auth', '$_SESSION[logged_in]', 'Laravel session + TenantAuthSessionService'],
    ['Roles', 'user_register.user_type', 'Spatie roles + users.user_type + getCiRole()'],
    ['Database', 'One DB per deployment', 'Central DB; tenant context via Stancl'],
    ['Admin UI', 'PHP views + jQuery', 'Blade + Vue 3 + Alpine on dashboard'],
    ['Routes', 'admin/method segments', 'routes/tenant.php (tenant_* names)'],
    ['Files', 'public/assets/...', 'Same paths via tenant_static_asset()'],
  ]),

  heading('2. Roles & permissions', HeadingLevel.HEADING_2),
  para('CI user_type values: admin, representatives, distributors, dealers, showrooms, affiliate, sub-affiliate, customers.'),
  tableFromRows([
    ['CI', 'Laravel'],
    ['user_type column', 'users.user_type synced via User::assignCiRole()'],
    ['View role checks', 'Spatie hasRole() + tenant_user_is_panel_admin(), isAdmin(), getCiRole()'],
    ['Permissions', 'config/tenant_permissions.php module-action keys'],
    ['Defaults', 'PermissionTableSeeder + default_role_permissions'],
  ]),
  para('Service: TenantRoleService::DEFAULT_ROLES, ensureDefaultRoles().'),

  heading('3. Admin navigation (frontend)', HeadingLevel.HEADING_2),
  para('Configured in config/tenant_admin_nav.php'),
  tableFromRows([
    ['Nav item', 'Laravel route(s)', 'Status'],
    ['Dashboard', 'tenant_dashboard', 'Partial — dashboard2 catalog widget added'],
    ['Users', 'tenant_user_*', 'Migrated'],
    ['Roles', 'tenant_role_*, tenant_hierarchy_*', 'Migrated + hierarchy'],
    ['Products', 'tenant_products_hub', 'Migrated'],
    ['Orders', 'tenant_order_*', 'Migrated'],
    ['Quotes', 'tenant_quotes_*, tenant_shipping_quotes_*', 'Migrated'],
    ['Stock check', 'tenant_stock_check_*', 'Migrated'],
    ['Claims', 'tenant_claim_*', 'Migrated'],
    ['Bulletins', 'tenant_bulletin_*', 'Migrated'],
    ['Support chat', 'tenant_support_chat_*', 'Laravel only'],
    ['Settings', 'tenant_settings_hub', 'Migrated'],
  ]),

  heading('4. Settings sidebar (frontend)', HeadingLevel.HEADING_2),
  para('Configured in config/tenant_settings_menu.php'),
  tableFromRows([
    ['Settings label', 'Laravel route', 'Notes'],
    ['My Profile', 'tenant_setting_profile', ''],
    ['Menu Layout', 'tenant_nav_menu_edit', 'Admin only'],
    ['Site Settings', 'tenant_site_setting', ''],
    ['Website Designing', 'tenant_website_designing', 'Theme, pages, homepage'],
    ['Tax & Fees', 'tenant_setting_tax_fees_*', 'Payment, shipping, sales tax'],
    ['Commission & Point Factors', 'tenant_setting_commission', ''],
    ['QuickBooks', 'tenant_quickbooks_*', ''],
    ['Roles & Permissions', 'tenant_role_index', 'Spatie'],
    ['Email Settings', 'tenant_setting_email_settings', 'Vue CRUD + SMTP'],
    ['Documentation', 'tenant_setting_manage_documentation_list', 'Vue CRUD'],
    ['Admin File Uploads', 'tenant_admin_uploads_index', 'New admin_uploads table'],
    ['Inventory Admin', 'tenant_inventory_admin_index', 'manage_inventories'],
  ]),

  heading('5. Module comparison (summary)', HeadingLevel.HEADING_2),

  heading('5.1 Dashboard', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Feature', 'CI', 'Laravel'],
    ['Admin home', 'Dashboard + bulletins', 'tenant_dashboard — widgets, tracker, recent orders'],
    ['Catalog sales (dashboard2)', 'room_data + misc per catalog + previous period SQL', 'CatalogSalesAnalyticsService — line totals; current period windows'],
    ['Order tracker', 'CI tracker', 'TenantOrderTrackerService on dashboard'],
  ]),
  para('Dashboard2 difference: CI allocates order-level tax/shipping/fees to catalog Misc; Laravel sums product line totals only.'),

  heading('5.2–5.8 Core modules', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Module', 'CI', 'Laravel'],
    ['Users', 'user_register CRUD', 'TenantUserController + hierarchy'],
    ['Products', 'catalog/section/door', 'ProductSetupApiController + Vue'],
    ['Orders', 'insert_new_order, room_data', 'Order workspace + buildCiRoomData()'],
    ['Quotes / shipping', 'my_quote', 'QuoteWorkspaceService, shipping quotes'],
    ['Stock check', 'stock check requests', 'TenantStockCheckController'],
    ['Claims', 'claims on orders', 'ClaimWorkspaceService'],
    ['Commission report', 'door style grouping', 'CommissionReportService + CSV export'],
  ]),

  heading('5.9–5.12 Admin settings modules', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Module', 'CI', 'Laravel'],
    ['manage_document', 'user_type + document_name', 'Same + status, soft deletes, Vue CRUD'],
    ['admin_uploads', 'Not separate in CI downloads', 'admin_uploads table + Admin File Uploads'],
    ['user_uploads', 'list_upload_file', 'UserUploadApiController'],
    ['manage_inventory', 'inventory_img + pagination', 'manage_inventories Vue CRUD (no image yet)'],
  ]),

  heading('6. Calculation & checkout flows', HeadingLevel.HEADING_2),

  heading('6.1 Order checkout pipeline', HeadingLevel.HEADING_3),
  bullet('Laravel: Order Workspace → parsePayload → buildCiRoomData → tax/fees/shipping → CommissionCalculationService → save order (rooms JSON, commission_parent_id).'),
  bullet('CI: insert_new_order → cart → cart_checkout_product → order_data_insert with POST room_data and commCalculation().'),

  heading('6.2 Door factor & line pricing', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Step', 'CI', 'Laravel'],
    ['Factor source', 'point_factor on user/parent/rep', 'OrderPricingService / UserDoorFactorService'],
    ['On order JSON', 'POST arrays in room_data', 'user_door_factor[], user_door_price[], sel_catalogue_name[]'],
    ['Report price', 'actual × qty × user_door_factor', 'Same in CommissionReportService'],
  ]),

  heading('6.3 Cart-level commission (commCalculation)', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Output', 'Formula (concept)'],
    ['mgfCommission', 'cartAmount × admin.point_factor'],
    ['repCommission', 'Rep customer or parent-is-rep path'],
    ['affCommission', 'Dealer/affiliate path × parent factor'],
    ['sub_aff_commission', 'Sub-affiliate × user factor'],
  ]),
  para('Laravel: CommissionCalculationService::calculate(). Persisted on checkout via TenantCreateOrderController.'),

  heading('6.4 Commission report', HeadingLevel.HEADING_3),
  bullet('Groups completed orders (state=1) by door style (product_cabinets_color).'),
  bullet('aff_commission = user_door_price − parent_door_price; rep_commission = parent − rep.'),
  bullet('Shows N/A when parent factor/price is zero. Weekly default: last Thursday → Wednesday.'),

  heading('6.5 Sales tax & shipping', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Setting', 'CI', 'Laravel'],
    ['FL county tax', 'taxcal()', 'sales_tax_counties + salesTaxPercent()'],
    ['Payment fees', 'site_config', 'TaxValuesService on checkout'],
    ['Weight surcharge', 'checkout rules', 'weightShippingSurcharge() — light/heavy thresholds'],
    ['Fuel / assemble', 'order fields', 'Workspace totals + dashboard tracker'],
  ]),

  heading('7. Data storage', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Data', 'CI', 'Laravel'],
    ['Room lines', 'my_orders.room_data (JSON string)', 'orders.rooms (JSON array)'],
    ['Completed order', 'state = 1', 'orders.state = 1'],
    ['User role', 'user_register.user_type', 'users.user_type + Spatie'],
  ]),

  heading('8. Parity gaps', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'Status', 'Notes'],
    ['Dashboard2 misc charges', 'Different', 'Laravel product-line revenue only'],
    ['Dashboard2 periods', 'Different', 'CI previous quarter/month/week vs Laravel current period'],
    ['admin_uploads', 'Laravel extension', 'CI uses manage_document for rep downloads'],
    ['Inventory images', 'Partial', 'No image column in Laravel CRUD yet'],
    ['Order status email', 'Template only', 'See email comparison doc'],
  ]),
  para('Related: CI-vs-Laravel-Email-Comparison.docx, E2E-Test-Report.md'),
];

const doc = new Document({ sections: [{ children: sections }] });
const buffer = await Packer.toBuffer(doc);
const filename = 'CI-vs-Laravel-Tenant-Comparison.docx';
fs.writeFileSync(path.join(outDir, filename), buffer);
console.log('Wrote', path.join(outDir, filename));
