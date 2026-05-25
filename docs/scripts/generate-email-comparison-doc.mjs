/**
 * CI vs Laravel Email comparison — Word document.
 * Run: npm run generate:email-comparison
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { Document, Packer, HeadingLevel } from 'docx';
import { heading, para, bullet, tableFromRows } from './docx-helpers.mjs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const outDir = path.join(__dirname, '..');

const emailRows = [
  ['1', 'register_admin', 'Yes', 'Yes', 'OK'],
  ['2', 'register_user', 'Yes', 'Yes', 'OK'],
  ['3', 'forgot_password_user', 'Yes', 'No (uses reset link)', 'Different'],
  ['4', 'reset_password_link', 'No', 'Yes', 'Laravel+'],
  ['5', 'login_otp', 'No', 'Yes', 'Laravel+'],
  ['6', 'forgot_username', 'No', 'Yes', 'Laravel+'],
  ['7', 'password_changed', 'No', 'Yes', 'Laravel+'],
  ['8', 'tenant_registered', 'No', 'Central signup', 'Laravel+'],
  ['9', 'user_status', 'Yes', 'Yes', 'OK'],
  ['10', 'user_deactivated', 'Unclear', 'Yes', 'OK'],
  ['11', 'user_reg_by_admin', 'Yes', 'Yes', 'OK'],
  ['12', 'affiliate_register_to_user', 'Yes', 'Template only', 'Gap'],
  ['13', 'order_email_to_user', 'Yes', 'Yes', 'OK'],
  ['14', 'order_email_to_admin', 'Yes', 'Yes', 'OK'],
  ['15', 'order_email_to_warehouse', 'Yes', 'Yes (invoice body)', 'Different'],
  ['16', 'order_email_to_rep', 'Yes', 'Yes', 'OK'],
  ['17', 'order_status_to_user', 'Yes', 'Template only', 'Gap'],
  ['18', 'claim_email_to_admin', 'Yes', 'Yes', 'OK'],
  ['19', 'claim_email_to_user', 'Yes', 'Yes', 'OK'],
  ['20', 'contact_us', 'Yes', 'Generic blade only', 'Different'],
  ['21', 'user_query_to_admin', 'Yes', 'Yes', 'OK'],
  ['22', 'shipping_quote_req_to_admin', 'Yes', 'Yes', 'OK'],
  ['23', 'shipping_quote_req_to_user', 'Yes', 'Yes', 'OK'],
  ['24', 'stock_check_req_to_admin', 'Yes', 'Yes', 'OK'],
  ['25', 'stock_check_req_to_user', 'Yes', 'Yes', 'OK'],
  ['26', 'stock_check_req_to_warehouse', 'Yes', 'Yes (manual)', 'OK'],
  ['27', 'update_stock_check_req_to_admin', 'Yes', 'Template only', 'Gap'],
];

const sections = [
  heading('CodeIgniter vs Laravel — Email Templates & Sending'),
  para('Project: Team Cabinets tenant panel'),
  para('27 templates in manage_emails_content — editable under Settings → Email Settings'),
  para('Last updated: May 2026', true),

  heading('1. How email works', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Piece', 'CodeIgniter', 'Laravel'],
    ['Templates', 'manage_emails_content table', 'Same + soft deletes'],
    ['SMTP', 'manage_emails_detail (base64 password)', 'tenant_smtp_settings + per-template from'],
    ['Sending', 'Send_email (often commented out in CI)', 'TenantEmailService + Mail (usually sends)'],
    ['Macros', 'PHP str_replace', 'TenantEmailService::replaceMacros()'],
    ['Admin UI', 'Legacy PHP list pages', 'Email Settings Vue CRUD'],
  ]),

  heading('2. Summary', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Result', 'Count'],
    ['Templates in DB', '27'],
    ['CI-equivalent sending wired', '22'],
    ['Template only (not sent)', '3'],
    ['Different implementation', '2'],
    ['Laravel-only extras', '5+'],
  ]),
  para('Quick answer: All CI email templates exist in the database. Most are sent automatically. Three need code wiring (order status, stock check update, affiliate register).'),

  heading('3. Master template list', HeadingLevel.HEADING_2),
  para('Legend: OK = sent; Gap = template only; Different = sent but not identical to CI; Laravel+ = new in Laravel.'),
  tableFromRows([
    ['#', 'email_slug', 'CI sends?', 'Laravel sends?', 'Status'],
    ...emailRows,
  ]),

  heading('4. Gaps to wire (recommended)', HeadingLevel.HEADING_2),
  bullet('order_status_to_user — when admin changes order status'),
  bullet('update_stock_check_req_to_admin — when stock check is edited after submit'),
  bullet('affiliate_register_to_user — when parent creates child user (or keep user_reg_by_admin)'),
  bullet('contact_us — switch ContactController to use contact_us slug template'),
  bullet('order_email_to_warehouse — optional pick_list partial instead of invoice body'),

  heading('5. Laravel-only templates', HeadingLevel.HEADING_2),
  bullet('reset_password_link, login_otp, forgot_username, password_changed, user_deactivated'),
  bullet('tenant_registered (central Pinnacle signup)'),

  heading('6. Key Laravel files', HeadingLevel.HEADING_2),
  tableFromRows([
    ['File', 'Role'],
    ['TenantEmailService.php', 'Render + send all slug templates'],
    ['OrderWorkspaceNotificationService.php', 'Order, quote, shipping, stock submit'],
    ['ClaimWorkspaceService.php', 'Claim emails'],
    ['StockCheckAdminViewService.php', 'Warehouse + approval emails'],
    ['EmailSettingsApiController.php', 'Admin CRUD for SMTP + templates'],
  ]),
];

const doc = new Document({ sections: [{ children: sections }] });
const buffer = await Packer.toBuffer(doc);
const filename = 'CI-vs-Laravel-Email-Comparison.docx';
fs.writeFileSync(path.join(outDir, filename), buffer);
console.log('Wrote', path.join(outDir, filename));
