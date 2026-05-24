import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import {
  Document,
  Packer,
  Paragraph,
  TextRun,
  HeadingLevel,
  Table,
  TableRow,
  TableCell,
  WidthType,
} from 'docx';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const outDir = path.join(__dirname, '..');

function heading(text, level = HeadingLevel.HEADING_1) {
  return new Paragraph({ text, heading: level, spacing: { after: 200 } });
}

function para(text, bold = false) {
  return new Paragraph({
    children: [new TextRun({ text, bold })],
    spacing: { after: 120 },
  });
}

function bullet(text) {
  return new Paragraph({ text, bullet: { level: 0 }, spacing: { after: 80 } });
}

function tableFromRows(rows) {
  return new Table({
    width: { size: 100, type: WidthType.PERCENTAGE },
    rows: rows.map(
      (cells) =>
        new TableRow({
          children: cells.map(
            (text) =>
              new TableCell({
                children: [new Paragraph({ children: [new TextRun({ text: String(text) })] })],
              })
          ),
        })
    ),
  });
}

const sections = [
  heading('CI vs Laravel Tenant — Module Comparison & Setup Reference'),
  para('Date: May 24, 2026'),
  para('Project: team-cabinets (Laravel tenant) compared to ci-team-cabinets (CodeIgniter legacy)'),
  para('Purpose: Full module inventory, parity gaps, and setup details for QuickBooks, PayTrace, and email.'),

  heading('1. Architecture Overview', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Aspect', 'CI (legacy)', 'Laravel tenant'],
    ['Admin surface', 'Single Admin.php (~200 methods)', 'Split controllers + Spatie permissions'],
    ['Role portal', 'Same CI app, tenant sidebar', 'Separate role layout + permission gates'],
    ['User roles', 'user_register.user_type string', 'Spatie roles (Admin, Representative, Dealer, etc.)'],
    ['Config storage', 'site_config, manage_emails_*, hardcoded PHP', 'tax_values, tenant_quickbooks_settings, manage_emails_content, .env'],
    ['Multi-tenant', 'Single DB / single brand', 'Stancl tenancy per tenant'],
  ]),

  heading('2. Module Comparison Legend', HeadingLevel.HEADING_2),
  para('Done = working end-to-end | Partial = UI or backend incomplete | Stub = page exists, no logic | Missing = not in Laravel'),

  heading('2.1 Authentication & Account', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Login / logout', 'Yes', 'Yes', 'Done'],
    ['Registration', 'Yes', 'Yes', 'Done'],
    ['Forgot password', 'Plain password email', 'Reset link + OTP', 'Done'],
    ['Forgot username', 'No', 'Yes', 'Done'],
    ['Change password', 'Yes', 'Profile + settings', 'Done'],
    ['Profile / logo', 'Yes', 'Profile pages', 'Partial'],
  ]),

  heading('2.2 Dashboard', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Admin dashboard', 'dashboard', 'tenant_dashboard', 'Done'],
    ['Order tracker dashboard', 'dashboard2', 'Tracker on dashboard', 'Partial'],
    ['Role dashboard', 'teamcabinets_dashboard', 'Role dashboard + bulletins', 'Done'],
    ['Onboarding checklist', 'No', 'Yes', 'Done (Laravel only)'],
  ]),

  heading('2.3 Users & Roles', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['User CRUD', 'Yes', 'Yes', 'Done'],
    ['Approve / block', 'Yes', 'Status + verification', 'Done'],
    ['Import / export', 'Partial', 'CSV', 'Done'],
    ['Soft delete / restore', 'Yes', 'Yes', 'Done'],
    ['Point factor + door factors', 'Yes', 'Yes', 'Done'],
    ['Manage user role (hierarchy)', 'set_admin_under_role', 'tenant_manage_role_*', 'Partial'],
    ['Add affiliate / child user', 'Rep sidebar', 'childStore', 'Done'],
    ['Role permissions matrix', 'Fixed user_type', 'Spatie ~110 permissions', 'Done (Laravel ahead)'],
    ['Hierarchy CSV exports', 'Yes', 'No', 'Missing'],
  ]),

  heading('2.4 Products & Catalog', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Product catalogs', 'Yes', 'Yes', 'Done'],
    ['Cabinet sections', 'Yes', 'Product sections', 'Done'],
    ['Products', 'Yes', 'Yes', 'Done'],
    ['Door styles', 'Yes', 'Yes', 'Done'],
    ['Import / export', 'Yes', 'Yes', 'Done'],
    ['Accordion product search', 'Yes', 'Order workspace', 'Done'],
    ['Catalog PDF', 'Yes', 'Partial', 'Partial'],
    ['Legacy inventory module', 'Yes', 'No', 'Missing'],
  ]),

  heading('2.5 Orders & Checkout', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Order workspace', 'Yes', 'Yes', 'Done'],
    ['Checkout + PayTrace', 'Yes', 'Yes', 'Done'],
    ['Check / PO payment', 'Yes', 'Yes', 'Done'],
    ['Commission on checkout', 'Yes', 'Yes', 'Done (recent)'],
    ['Door factors in room JSON', 'Yes', 'Yes', 'Done (old orders lack data)'],
    ['Order list admin/role', 'Yes', 'Yes', 'Done'],
    ['Order print', 'Yes', 'Yes', 'Done'],
    ['Archived orders UI', 'Yes', 'Soft delete only', 'Partial'],
    ['Warehouse pick list', 'Yes', 'No', 'Missing'],
    ['Order CSV export', 'Yes', 'Partial', 'Partial'],
  ]),

  heading('2.6 Quotes, Shipping Quotes, Stock Check', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Product quotes', 'Yes', 'Yes', 'Done'],
    ['Shipping quotes', 'Yes', 'Yes', 'Done'],
    ['Stock check', 'Yes', 'Yes', 'Done'],
    ['Shipping quote → checkout', 'Yes', 'Yes', 'Done'],
    ['Print flows', 'Yes', 'Partial', 'Partial'],
  ]),

  heading('2.7 Claims', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Create claim from order', 'Yes', 'Yes', 'Done'],
    ['Claims list', 'Yes', 'Yes', 'Done'],
    ['Claim emails', 'Yes', 'Yes', 'Done'],
  ]),

  heading('2.8 Commission Reports (2 CI Documents)', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Document', 'CI', 'Laravel', 'Status'],
    ['A. Admin commission report (door-style, CSV)', 'user_commissions_report', 'commission_report/index + Vue', 'Done'],
    ['B. User-type gross sales list', 'get_select_user_type_commissions', 'commission_report/user-types', 'Done'],
    ['C. Role-scoped tenant report', 'commission_report', 'Auto-scoped for non-admin', 'Done'],
    ['D. Tax/Commission/Shipping savings', 'admin_saving_report', 'No', 'Missing'],
    ['Print commission report', 'Yes', 'No', 'Missing'],
    ['Remove order from report (state=0)', 'Yes', 'Yes', 'Done'],
    ['Restore removed orders', 'No', 'Yes', 'Done'],
    ['Role-tree commission CSVs', 'Yes', 'No', 'Missing'],
    ['Commission on storeOrder path', 'N/A', 'No', 'Missing'],
  ]),
  para('Note: Commission report is not in admin top nav — access via role sidebar or direct URL. Dealer/Showroom roles may lack commission permissions by default.'),

  heading('2.9 Bulletins', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['CRUD', 'Yes', 'Yes', 'Done'],
    ['Target by user type', 'Yes', 'Yes', 'Done'],
    ['Role dashboard visibility', 'Yes', 'Yes', 'Done'],
  ]),

  heading('2.10 Downloads & Uploads', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Admin manage documents', 'Yes', 'Stub form only', 'Stub'],
    ['User downloads', 'Yes', 'Partial (needs manage_document data)', 'Partial'],
    ['User uploads', 'Yes', 'Yes (Vue API)', 'Done'],
  ]),

  heading('2.11 Settings & CMS', HeadingLevel.HEADING_2),
  tableFromRows([
    ['CI admin menu item', 'Laravel equivalent', 'Status'],
    ['Site config', 'Site Settings', 'Done'],
    ['Credit/Debit/ACH charges', 'Tax & Fees → Payment', 'Done'],
    ['Fuel charges', 'Tax & Fees', 'Done'],
    ['Sales tax by county', 'Sales tax counties', 'Done'],
    ['PayTrace password', 'Tax & Fees → PayTrace', 'Done'],
    ['Commission / point factors', 'Settings → Commission', 'Done'],
    ['Manage emails', 'Email Settings (Vue)', 'Done'],
    ['Manage SMTP', 'Email Settings → SMTP', 'Done'],
    ['Terms & conditions', 'CMS / tax_values HTML', 'Done'],
    ['Manage home page', 'Website Designing', 'Partial'],
    ['Sortable admin nav', 'No', 'Missing'],
    ['Legacy payment gateway CRUD', 'No', 'Missing'],
  ]),

  heading('2.12 Order Tracker', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Enhanced details CRUD', 'Yes', 'Dashboard partial', 'Partial'],
    ['CSV export', 'Yes', 'No', 'Missing'],
    ['QuickBooks # display', 'Yes', 'Display only', 'Partial (no auto-sync)'],
  ]),

  heading('2.13 Support & Contact', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Module', 'CI', 'Laravel', 'Status'],
    ['Contact queries', 'Yes', 'Partial', 'Partial'],
    ['Order query email', 'Yes', 'Yes', 'Done'],
    ['Support chat', 'No', 'Yes', 'Done (Laravel only)'],
  ]),

  heading('2.14 QuickBooks', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Feature', 'CI', 'Laravel', 'Status'],
    ['OAuth connect', 'Yes (hardcoded creds)', 'Settings → QuickBooks UI', 'Partial'],
    ['Token storage', 'quickbooks_token', 'tenant_quickbooks_settings', 'Done'],
    ['Customer sync', 'Yes', 'No', 'Missing'],
    ['Invoice on order', 'Yes (often commented out)', 'No', 'Missing'],
    ['Product/inventory sync cron', 'Yes', 'No', 'Missing'],
    ['QBO item ID on products', 'Yes', 'No', 'Missing'],
    ['Manual send invoice', 'send_quickbook_order_data', 'No', 'Missing'],
  ]),

  heading('2.15 Payments (PayTrace)', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Feature', 'CI', 'Laravel', 'Status'],
    ['Credit / debit card', 'Yes', 'Yes', 'Done'],
    ['ACH', 'Yes', 'Yes', 'Done'],
    ['Check / PO', 'Yes', 'Yes', 'Done'],
    ['Credential storage', 'site_config + PHP file', 'tax_values per tenant', 'Done'],
    ['API environment', 'Sandbox URL in CI code', 'Production URL in Laravel', 'Mismatch — verify before go-live'],
  ]),

  heading('2.16 Email System', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Feature', 'CI', 'Laravel', 'Status'],
    ['DB-managed templates', 'manage_emails_content', 'Same slugs + seeder', 'Done'],
    ['Multiple SMTP accounts', 'manage_emails_details', 'tenant_smtp_settings', 'Done'],
    ['Per-template email_from', 'Yes', 'Yes', 'Done'],
    ['CI HTML invoice partials', 'PHP views', 'Blade emails/tenant/ci/*', 'Done'],
  ]),

  heading('3. Navigation Comparison', HeadingLevel.HEADING_2),
  para('CI super-admin header (29 items): Dashboard, Documents, Orders, Uploads, Products, Catalog, Sections, Bulletins, Commission Report, Tax/Commission/Shipping Totals, Users, Manage Role, Claims, Quotes, Shipping Quotes, Homepage CMS, Email, SMTP, T&C, Contact queries, Card/ACH fees, Sales tax, Stock check, PayTrace password, Fuel, Order Tracker, About, Contact.'),
  para('Laravel admin sidebar: Dashboard → Users → Roles → Products → Orders → Quotes → Stock Check → Claims → Bulletins → Support Chat → Settings (hub).'),
  para('Not in Laravel admin sidebar: Commission reports (role sidebar), Order tracker (dashboard), Downloads/uploads (role sidebar), QuickBooks/email/tax (Settings hub).'),

  heading('4. Remaining Work — Priority List', HeadingLevel.HEADING_2),
  heading('High priority', HeadingLevel.HEADING_3),
  bullet('QuickBooks invoice + product sync (OAuth works; no invoice push or inventory cron).'),
  bullet('Admin commission report link in admin navigation.'),
  bullet('Tax/Commission/Shipping savings report (admin_saving_report) — not ported.'),
  bullet('Manage documents admin CRUD — stub only; downloads depend on this table.'),
  bullet('PayTrace environment — confirm sandbox vs production per tenant.'),
  bullet('Commission on all order-creation paths (only checkout today).'),
  bullet('Optional backfill command for existing orders commission data.'),
  heading('Medium priority', HeadingLevel.HEADING_3),
  bullet('Warehouse pick list + email flow.'),
  bullet('Archived orders list + CSV.'),
  bullet('Order tracker full admin list + CSV export.'),
  bullet('Commission print view.'),
  bullet('Role hierarchy CSV exports.'),
  bullet('Dealer/Showroom commission permissions if CI parity needed.'),
  bullet('QBO product ID fields on products.'),
  heading('Low priority / legacy', HeadingLevel.HEADING_3),
  bullet('Separate inventory module.'),
  bullet('Legacy Authorize.net payment gateway CRUD.'),
  bullet('Sortable admin menu ordering.'),

  heading('5. Known Issues / Verify', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Item', 'Issue'],
    ['PayTrace URL', 'CI uses sandbox; Laravel uses https://api.paytrace.com (production)'],
    ['Old orders in commission report', 'No door-factor arrays in rooms JSON'],
    ['orders.parent_id column', 'Buyer parent at order time — not soft-delete related'],
    ['QBO on checkout', 'CI had it commented out; Laravel never calls it'],
    ['manage_documentation_* views', 'Still placeholder/static data'],
  ]),

  heading('6. QuickBooks Setup Reference', HeadingLevel.HEADING_2),
  para('Configure in tenant: Settings → QuickBooks (/quickbooks)'),
  tableFromRows([
    ['Field', 'Purpose'],
    ['Client ID', 'Intuit Developer app'],
    ['Client Secret', 'Intuit Developer app'],
    ['Redirect URI', 'Must match Intuit app exactly'],
    ['Environment', 'sandbox or production'],
  ]),
  para('.env fallback keys: QUICKBOOKS_CLIENT_ID, QUICKBOOKS_CLIENT_SECRET, QUICKBOOKS_REDIRECT_URI, QUICKBOOKS_ENVIRONMENT, QUICKBOOKS_SCOPE'),
  para('OAuth callback route: /quickbooks/callback (tenant_quickbooks_callback)'),
  para('After connect, tokens stored in tenant_quickbooks_settings: access_token, refresh_token, realm_id.'),
  heading('CI reference for migration', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Item', 'CI location / value'],
    ['OAuth callback', 'admin/quickbook'],
    ['Token table', 'quickbooks_token'],
    ['Customer field', 'user_register.quickbook_ref_id'],
    ['Product field', 'cabinets_product.quickbook_product_id'],
    ['Order field', 'my_orders.quickbook_invoice_id'],
    ['Realm ID (example in code)', '123146292581394'],
    ['QBO service item IDs', 'Assembly 21955, CC 21954, ACH 21965, Debit 21966, Fuel 22493'],
    ['Product sync cron', 'admin/update_import_inventory_data_cron'],
    ['Manual invoice', 'admin/send_quickbook_order_data/{orderId}'],
  ]),
  para('Steps: Create app at developer.intuit.com → add redirect URI → enable Accounting scope → Connect in tenant UI → map products (manual until sync built).'),

  heading('7. PayTrace Setup Reference', HeadingLevel.HEADING_2),
  para('Configure in tenant: Settings → Tax & Fees → PayTrace (tax_values table)'),
  tableFromRows([
    ['option_key', 'Label', 'Used by'],
    ['paytrace_username', 'API username', 'OAuth basic auth'],
    ['paytrace_password', 'API password', 'OAuth basic auth'],
  ]),
  para('Related fee keys (Tax & Fees): fuel_charges_value (default 2%), credit_card_charges (3%), debit_card_charges (0.5%), ach_pay_charges ($10), sales_tax_percentage (fallback).'),
  heading('Laravel PayTrace technical details', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Setting', 'Value'],
    ['OAuth URL', 'https://api.paytrace.com/oauth/token'],
    ['Card sale', 'POST /v1/transactions/sale/keyed'],
    ['ACH sale', 'POST /v1/checks/sale/keyed'],
    ['Integrator ID', '92371rHTLxWk (hardcoded in PaytracePaymentService)'],
    ['Auth', 'HTTP Basic username+password → Bearer token'],
  ]),
  heading('CI reference', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Item', 'CI value / location'],
    ['Username', 'team@teamcabinets.com (PhpApiSettings.php)'],
    ['Password', 'site_config paytrace_password key'],
    ['CI API base', 'https://api.sandbox.paytrace.com/ (SANDBOX)'],
    ['Integrator ID', 'Same PayTrace partner family'],
  ]),
  para('Checkout payment methods: by_credit_card, by_debit_card, pay_ach, check/PO — same as CI.'),

  heading('8. Email Setup Reference', HeadingLevel.HEADING_2),
  heading('8.1 SMTP (Laravel)', HeadingLevel.HEADING_3),
  para('Settings → Email Settings → SMTP. Table: tenant_smtp_settings'),
  tableFromRows([
    ['Field', 'Example'],
    ['smtp_host', 'smtp.office365.com'],
    ['smtp_port', '587'],
    ['smtp_encryption', 'tls'],
    ['smtp_username', 'mailbox login'],
    ['smtp_password', 'encrypted in DB'],
    ['from_email', 'sender address'],
    ['from_name', 'Team Cabinets'],
  ]),
  heading('8.2 CI legacy email addresses (reference)', HeadingLevel.HEADING_3),
  tableFromRows([
    ['Constant / role', 'CI value'],
    ['From name', 'Team Cabinets'],
    ['Admin email', 'Team@teamcabinets.com'],
    ['Claims email', 'Claims@teamcabinets.com'],
    ['Sales email', 'Sales@teamcabinets.com'],
    ['SMTP host', 'smtp.office365.com'],
    ['SMTP port', '587'],
    ['SMTP user', 'sales@teamcabinets.com'],
  ]),
  para('Obtain current SMTP password from your mail provider or CI site_config — do not commit passwords to git.'),

  heading('8.3 Email template slugs (manage_emails_content)', HeadingLevel.HEADING_3),
  para('Seed: php artisan db:seed --class=ManageEmailsContentSeeder'),
  tableFromRows([
    ['Slug', 'When sent', 'Main macros'],
    ['register_admin', 'New front registration', '—'],
    ['register_user', 'Registration confirmation', '{USERNAME}'],
    ['forgot_password_user', 'Legacy plain password', '{USERNAME}, {PASSWORD}'],
    ['reset_password_link', 'Password reset link', '{USERNAME}, {RESET_LINK}'],
    ['login_otp', 'OTP login', '{USERNAME}, {OTP}'],
    ['forgot_username', 'Username reminder', '{USERNAME}, {LOGIN}, {LOGIN_URL}'],
    ['password_changed', 'After password change', '{USERNAME}'],
    ['user_status', 'Account approved', '{USERNAME}'],
    ['user_deactivated', 'Account deactivated', '{USERNAME}'],
    ['user_reg_by_admin', 'Admin creates user', '{USERNAME}, {PASSWORD}, {URL}'],
    ['affiliate_register_to_user', 'Rep creates sub-user', '{PARENT_USER}, {URL}, {USERNAME}, {PASSWORD}'],
    ['order_email_to_user', 'Order placed', '{USERNAME}, {INVOICE}, {CONTENT}'],
    ['order_email_to_admin', 'Order placed', '{USERNAME}, {INVOICE}, {CONTENT}'],
    ['order_email_to_warehouse', 'Order placed', '{CONTENT}, {INVOICE}'],
    ['order_email_to_rep', 'Order by rep customer', '{REPRESENTATIVE}, {USERNAME}, {CONTENT}'],
    ['order_status_to_user', 'Status change', '{USERNAME}, {STATUS}, {INVOICE}'],
    ['claim_email_to_admin', 'Claim filed', '{USERNAME}, {CONTENT}'],
    ['claim_email_to_user', 'Claim filed', '{USERNAME}, {CONTENT}'],
    ['contact_us', 'Contact form', '{USERNAME}, {EMAIL}, {QUERY}'],
    ['user_query_to_admin', 'Order help query', '{USERNAME}, {EMAIL}, {SUBJECT}, {QUERY}'],
    ['shipping_quote_req_to_admin', 'Shipping quote', '{USERNAME}, {CONTENT}'],
    ['shipping_quote_req_to_user', 'Shipping quote update', '{USERNAME}, {CONTENT}'],
    ['stock_check_req_to_admin', 'Stock check', '{USERNAME}, {CONTENT}'],
    ['stock_check_req_to_user', 'Stock check approved', '{USERNAME}, {CONTENT}'],
    ['stock_check_req_to_warehouse', 'To warehouse', '{CONTENT}, {ID}'],
    ['update_stock_check_req_to_admin', 'Stock check updated', '{USERNAME}, {CONTENT}, {STOCK_CHECK_ID}'],
  ]),
  para('Each template email_from = tenant_smtp_settings id (0 = default mailer). Order HTML body uses Blade partial: resources/views/emails/tenant/ci/partials/invoice_email.blade.php'),

  heading('9. Summary Scorecard', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI', 'Tenant', 'Main gap'],
    ['Core ordering', '100%', '~90%', 'Pick list, archive CSV'],
    ['Quotes / shipping / stock', '100%', '~95%', 'Minor print/export'],
    ['Users & door factors', '100%', '~95%', 'Hierarchy CSV exports'],
    ['Commission (2 docs)', '100%', '~75%', 'Savings report, print, admin nav'],
    ['QuickBooks', '~80%', '~25%', 'OAuth only, no sync'],
    ['PayTrace', '100%', '~90%', 'Sandbox vs prod URL'],
    ['Email', '100%', '~95%', 'Verify SMTP routing'],
    ['CMS / homepage', '100%', '~70%', 'Partial storefront'],
    ['Permissions', 'Fixed roles', 'Flexible Spatie', 'Tenant ahead'],
    ['Support chat', 'No', 'Yes', 'Tenant ahead'],
    ['Multi-tenant', 'No', 'Yes', 'Tenant ahead'],
  ]),

  heading('10. Tenant Setup Checklist', HeadingLevel.HEADING_2),
  bullet('1. SMTP — Create account in Email Settings; test registration email.'),
  bullet('2. Email templates — Run ManageEmailsContentSeeder; assign SMTP to order/claim/warehouse templates.'),
  bullet('3. Tax & fees — Set fuel, CC, debit, ACH, Florida counties.'),
  bullet('4. PayTrace — Enter username/password; test card (match sandbox or production URL).'),
  bullet('5. QuickBooks — Enter Intuit credentials; connect company; plan manual product mapping.'),
  bullet('6. Commission — Place test order; open Commission Report; run User Type Commissions.'),
  bullet('7. Permissions — Re-run PermissionTableSeeder + TenantRoleSeeder if roles lack commission/export.'),
  bullet('8. Documents — Do not rely on Manage Document UI until CRUD is implemented.'),
];

async function main() {
  const doc = new Document({ sections: [{ children: sections }] });
  const buffer = await Packer.toBuffer(doc);
  const filename = 'CI-vs-Tenant-Module-Comparison-and-Setup.docx';
  fs.writeFileSync(path.join(outDir, filename), buffer);
  console.log('Wrote', path.join(outDir, filename));
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
