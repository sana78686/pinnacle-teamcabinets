# CodeIgniter vs Laravel — Email Templates & Sending Comparison

**Last updated:** May 2026  
**CI reference:** `ci-team-cabinets/app/Controllers/Admin.php`, `Home.php`, `App\Libraries\Send_email`  
**Laravel reference:** `manage_emails_content` table, `TenantEmailService`, `app/Mail/*`, Settings → **Email Settings**

---

## Table of contents

1. [How email works in each stack](#1-how-email-works-in-each-stack)
2. [SMTP & admin UI](#2-smtp--admin-ui)
3. [Master template list (all slugs)](#3-master-template-list-all-slugs)
4. [Trigger map — when each email fires](#4-trigger-map--when-each-email-fires)
5. [Email body partials (`{CONTENT}`)](#5-email-body-partials-content)
6. [Summary: do we have all CI emails?](#6-summary-do-we-have-all-ci-emails)
7. [Laravel-only emails](#7-laravel-only-emails)
8. [Gaps to wire (recommended)](#8-gaps-to-wire-recommended)
9. [File reference](#9-file-reference)

---

## 1. How email works in each stack

| Piece | CodeIgniter | Laravel tenant |
|-------|-------------|----------------|
| Template storage | DB table `manage_emails_content` (`email_slug`, `email_subject`, `email_content`, `macro`, `email_from`) | Same table + soft deletes |
| SMTP profiles | `manage_emails_detail` (per-template or global from id) | `tenant_smtp_settings` + optional per-template `email_from` |
| Send library | `Send_email::process_email()` (often **commented out** in Admin.php) | `TenantEmailService::send()` / Laravel `Mail` |
| Macros | Replace `{USERNAME}`, `{CONTENT}`, etc. in PHP | `TenantEmailService::replaceMacros()` |
| HTML wrapper | CI views under `admin/teamcabinets/email_template/` | `emails/tenant/ci/layout.blade.php` — tenant logo from Site Settings; Pinnacle logo + tagline *Your cabinets website — {tenant}* when no logo |
| Admin edit | Manage email content list (legacy PHP views) | **Settings → Email Settings** — Vue CRUD (`EmailSettingsApiController`) |

**Important:** In CI, many `process_email()` calls are commented (`// $result = $this->send_email->process_email(...)`). Laravel generally **does send** when the feature runs (with try/catch + log on failure).

---

## 2. SMTP & admin UI

### CI

- Routes like `admin/manage_stmp`, `manage_email_content_list`
- Password stored base64 in `manage_emails_detail`
- `getEmailsDetail($email_from_id)` picks SMTP for a template

### Laravel

| Feature | Route / file |
|---------|----------------|
| Email settings hub | `tenant_setting_email_settings` |
| SMTP CRUD API | `tenant_email_settings_api_*` → `EmailSettingsApiController` |
| Template CRUD API | same controller, type `email-content` |
| Test SMTP | `tenant_email_settings_api_test_smtp` |
| Default templates seed | `ManageEmailsContentService::ensureDefaults()` on provision + settings load |
| Per-tenant SMTP mailer | `TenantSmtpService::MAILER_NAME` |
| Fallback from address | Platform `MAIL_FROM_*` with Reply-To = tenant contact email |

**Parity:** SMTP + editable templates — **yes**, with a modern Vue UI instead of static list blades.

---

## 3. Master template list (all slugs)

Legend:

| Status | Meaning |
|--------|---------|
| **OK** | Template exists and is sent in Laravel on the same (or better) trigger as CI |
| **Template only** | In DB / editable in admin; **not sent** by application code yet |
| **Different** | Sent, but behaviour differs from CI (called out in notes) |
| **Laravel+** | Not in CI; Laravel addition |

| # | `email_slug` | CI type label | CI sends? | Laravel sends? | Status |
|---|--------------|---------------|-----------|----------------|--------|
| 1 | `register_admin` | Registration Email For Admin | Yes (`Home`, affiliate create) | Yes — `AdminNewUserNotificationMail` on self-registration | **OK** |
| 2 | `register_user` | Registration Email For User | Yes (`Home`) | Yes — `PendingUserVerificationMail` on register | **OK** |
| 3 | `forgot_password_user` | Forgot Password (plain `{PASSWORD}`) | Yes (`Home::forgot`) | No — replaced by reset link flow | **Different** |
| 4 | `reset_password_link` | — | No | Yes — `TenantResetPasswordMail` | **Laravel+** (preferred over plain password) |
| 5 | `login_otp` | — | No | Yes — `SendOtpMail` on OTP login | **Laravel+** |
| 6 | `forgot_username` | — | No | Yes — `TenantForgotUsernameMail` | **Laravel+** |
| 7 | `password_changed` | — | No | Yes — `PasswordChanged` on profile password update | **Laravel+** |
| 8 | `tenant_registered` | — | No | Central only (`TenantRegistrationMailer`) | **Laravel+** (Pinnacle signup, not tenant panel) |
| 9 | `user_status` | Account approved | Yes (admin approves user) | Yes — `UserAccountActivationMail` / `UserAccountVerificationMail` | **OK** |
| 10 | `user_deactivated` | Account deactivated | Unclear in CI grep | Yes — `UserAccountDeactivationMail` | **OK** / **Laravel+** |
| 11 | `user_reg_by_admin` | User created by admin | Yes (`Admin` insert user; send often commented) | Yes — `UserRegisteredByAdminMail` | **OK** |
| 12 | `affiliate_register_to_user` | Child user created by parent | Yes (`Admin` affiliate flow) | Yes — parent/affiliate create + admin create with `parent_id` | **OK** |
| 13 | `order_email_to_user` | Order confirmation to customer | Yes (`order_data_insert`) | Yes — `OrderWorkspaceNotificationService::sendOrderPlacedEmails` | **OK** |
| 14 | `order_email_to_admin` | New order to admin | Yes | Yes — `sendToAdmin` same service | **OK** |
| 15 | `order_email_to_warehouse` | New order to warehouse | Yes (with pick-list HTML in `{CONTENT}`) | Yes — `sendToAdmin(SLUG_ORDER_WAREHOUSE)` uses **invoice** partial, not pick-list partial | **Different** |
| 16 | `order_email_to_rep` | New order to rep | Yes | Yes — if `rep_id` on cart | **OK** |
| 17 | `order_status_to_user` | Order status changed | Yes (`Admin` status update) | Yes — `OrderObserver` when `orders.status` changes | **OK** |
| 18 | `claim_email_to_admin` | New claim | Yes | Yes — `ClaimWorkspaceService` | **OK** |
| 19 | `claim_email_to_user` | Claim confirmation | Yes | Yes — `ClaimWorkspaceService` | **OK** |
| 20 | `contact_us` | Storefront contact to admin | Yes (`Admin` contact) | Yes — `ContactController` → `contact_us` managed template | **OK** |
| 21 | `user_query_to_admin` | Order help / query | Yes | Yes — `TenantOrderQueryController` | **OK** |
| 22 | `shipping_quote_req_to_admin` | New shipping quote | Yes | Yes — `OrderWorkspaceNotificationService::sendShippingQuoteEmails` | **OK** |
| 23 | `shipping_quote_req_to_user` | Shipping quote updated | Yes | Yes — same service (on submit/update path) | **OK** |
| 24 | `stock_check_req_to_admin` | New stock check | Yes (`email_type` on insert) | Yes — `sendStockCheckEmails` | **OK** |
| 25 | `stock_check_req_to_user` | Stock check approved | Yes | Yes — on admin approval (`StockCheckAdminViewService::finalizeApproval`) | **OK** |
| 26 | `stock_check_req_to_warehouse` | Stock check to warehouse | Yes | Yes — manual send from admin UI (`sendWarehouseEmail`) | **OK** |
| 27 | `update_stock_check_req_to_admin` | Stock check updated | Yes (on update) | Yes — admin stock check update (`TenantStockCheckController`) | **OK** |

**Count:** 27 DB templates seeded in Laravel. **22** have active send paths for CI-equivalent flows. **3** are template-only gaps. **2** differ in implementation. **5+** are Laravel enhancements.

---

## 4. Trigger map — when each email fires

### Authentication & users

| Event | CI | Laravel |
|-------|-----|---------|
| Public registration | `register_user` + `register_admin` | `PendingUserVerificationMail` + `AdminNewUserNotificationMail` |
| Admin approves user | `user_status` | `UserAccountActivationMail` |
| Admin deactivates user | — | `UserAccountDeactivationMail` |
| Admin creates user | `user_reg_by_admin` | `UserRegisteredByAdminMail` (all roles; not separate affiliate slug) |
| Parent creates affiliate/downline | `affiliate_register_to_user` + `register_admin` | Same as admin create today (**gap** if you need parent name in body) |
| Forgot password | `forgot_password_user` (new password in email) | `TenantResetPasswordMail` (`reset_password_link`) |
| Forgot username | — | `TenantForgotUsernameMail` |
| Login OTP | — | `SendOtpMail` (`login_otp`) |
| Profile password change | — | `PasswordChanged` |

### Orders & quotes

| Event | CI | Laravel |
|-------|-----|---------|
| Checkout / order placed | User, admin, warehouse, rep templates | `OrderWorkspaceNotificationService::sendOrderPlacedEmails` |
| Quote saved (workspace) | Similar to order user email | `sendQuoteSavedEmails` (reuses order user/admin slugs + quote partial) |
| Order status change | `order_status_to_user` | Panel notifications only — **email not wired** |
| Warehouse pick list email on place | Pick list HTML inside warehouse template | Warehouse email uses `order_workspace_invoice` partial; pick list view is **print UI only** |

### Claims, stock, shipping

| Event | CI | Laravel |
|-------|-----|---------|
| Claim submitted | claim admin + user | `ClaimWorkspaceService` |
| Stock check submitted | admin (+ warehouse in some paths) | `sendStockCheckEmails` (admin + user) |
| Stock check updated | `update_stock_check_req_to_admin` | **Not sent** |
| Stock check approved | `stock_check_req_to_user` | `StockCheckAdminViewService::finalizeApproval` |
| Warehouse stock email | `stock_check_req_to_warehouse` | Admin button → `sendWarehouseEmail` |
| Shipping quote | admin + user slugs | `sendShippingQuoteEmails` |

### Contact & queries

| Event | CI | Laravel |
|-------|-----|---------|
| Contact form | `contact_us` slug | Stores `ContactQuery` + sends generic `emails.contact` |
| Order query / help | `user_query_to_admin` | `TenantOrderQueryController` → `tenant_email()->sendToAdmin(SLUG_USER_QUERY)` |

### Central (not tenant DB templates)

| Event | Laravel only |
|-------|----------------|
| New tenant on Pinnacle | `TenantRegistrationMailer` → central mailables |

---

## 5. Email body partials (`{CONTENT}`)

Laravel injects HTML into `{CONTENT}` via `config/tenant_email.php`:

| Partial key | Blade view | Used for |
|-------------|------------|----------|
| `order_workspace_invoice` | `emails.tenant.workspace.order_invoice_body` | Order placed (user/admin/warehouse/rep) |
| `order_workspace_quote` | `emails.tenant.workspace.order_quote_body` | Quote saved |
| `stock_check_workspace` | `emails.tenant.workspace.stock_check_body` | Stock check user/admin |
| `shipping_quote_workspace` | `emails.tenant.workspace.shipping_quote_body` | Shipping quote |
| `stock_check_warehouse` | `emails.tenant.ci.partials.stock_check_email_to_warehouse` | Warehouse stock email |
| `pick_list` | `emails.tenant.ci.partials.pick_list_email` | **Defined but not used** in send path (CI used this inside warehouse order email) |
| `invoice` | `emails.tenant.ci.partials.invoice_email` | Legacy CI-style invoice block |
| `claims` / `user_claims` | `emails.tenant.partials.claims_body` | Claims |

CI used PHP views under `admin/teamcabinets/email_template/` (e.g. `pick_list_email.php`, `invoice` blocks). Laravel workspace partials are the modern equivalent for new orders.

---

## 6. Summary: do we have all CI emails?

### Yes — covered (template + send)

- Registration (user + admin)
- User approved / deactivated (Laravel adds explicit deactivate)
- User created by admin
- Order placed (user, admin, warehouse, rep)
- Claims (admin + user)
- Shipping quote (admin + user)
- Stock check (admin on submit, user on approve, warehouse on demand)
- Order query to admin

### Partially covered

| CI email | Laravel situation |
|----------|-------------------|
| `forgot_password_user` | Replaced by **reset link** (more secure); old slug kept in DB for editing |
| `contact_us` | Email goes out, but not via managed `contact_us` template |
| `order_email_to_warehouse` | Sent, but body is **invoice** layout, not CI **pick list** layout |
| `affiliate_register_to_user` | Template exists; affiliate/parent create uses **user_reg_by_admin** |

### Not sent yet (template in DB only)

1. **`order_status_to_user`** — wire when admin changes order status (CI `Admin.php` ~5523).
2. **`update_stock_check_req_to_admin`** — wire when stock check is edited after submit (CI ~2715).
3. **`affiliate_register_to_user`** — wire when hierarchy/parent creates downline (optional if `user_reg_by_admin` is enough).

### Pick list

- **CI:** Emailed pick list HTML on order place (warehouse template + `pick_list_email.php`).
- **Laravel:** Pick list is a **page/print** (`tenant_order_pick_list`); warehouse email does not use `pick_list` partial yet.

---

## 7. Laravel-only emails

These slugs exist in tenant email settings but were not found in CI `email_slug` usage:

| Slug | Purpose |
|------|---------|
| `reset_password_link` | Secure password reset |
| `login_otp` | OTP login |
| `forgot_username` | Username reminder |
| `password_changed` | Security notice after password change |
| `user_deactivated` | Explicit deactivation notice |
| `tenant_registered` | Central tenant welcome (panel uses central mailer) |

---

## 8. Gaps to wire (recommended)

Priority order for full CI parity:

1. **Order status email** — On order status update in `TenantOrderController` (or admin order service):

   ```php
   tenant_email()->send(ManageEmailsContent::SLUG_ORDER_STATUS, $user->email, [
       'USERNAME' => $user->name,
       'STATUS' => $newStatus,
       'INVOICE' => (string) $order->id,
   ]);
   ```

2. **Stock check update → admin** — When admin/user edits an existing stock check request, call `SLUG_STOCK_UPDATE_ADMIN` with `{STOCK_CHECK_ID}` and workspace partial.

3. **Contact form → `contact_us` slug** — Change `ContactController::send()` to use `tenant_email()->sendToAdmin(ManageEmailsContent::SLUG_CONTACT_US, [...])` instead of raw `emails.contact`.

4. **Affiliate registration** — When parent creates child user, use `SLUG_AFFILIATE_REGISTER` with `{PARENT_USER}`, `{URL}`, `{PASSWORD}`.

5. **Warehouse order email + pick list** — Option A: send warehouse mail with partial `pick_list` instead of `order_workspace_invoice`. Option B: separate pick-list email after checkout (match CI).

6. **`forgot_password_user`** — Leave deprecated or remove from UI; document that CI plain-password flow is intentionally replaced.

---

## 9. File reference

### Laravel — sending

| File | Role |
|------|------|
| `app/Services/TenantEmailService.php` | Render template, macros, send, admin inbox |
| `app/Services/TenantSmtpService.php` | Tenant SMTP mailer |
| `app/Services/ManageEmailsContentService.php` | Default 27 templates |
| `app/Services/OrderWorkspaceNotificationService.php` | Order, quote, shipping, stock submit |
| `app/Services/ClaimWorkspaceService.php` | Claim emails |
| `app/Services/StockCheckAdminViewService.php` | Warehouse + approval user email |
| `app/Http/Controllers/TenantOrderQueryController.php` | User query |
| `app/Http/Controllers/TenantAuthController.php` | OTP, reset, forgot username |
| `app/Http/Controllers/TenantUserController.php` | Register, approve, admin create |
| `app/Mail/*` + `BuildsCiTenantEmail` | Mailable wrappers around slugs |

### Laravel — admin UI

| File | Role |
|------|------|
| `resources/views/tenants/setting/email_settings.blade.php` | Settings page |
| `public/js/email-settings-vue.js` | Vue CRUD |
| `app/Support/EmailSettingsVueConfig.php` | Column/field config |
| `app/Http/Controllers/EmailSettingsApiController.php` | API |

### CI — reference

| File | Role |
|------|------|
| `app/Controllers/Admin.php` | Most `email_slug` lookups |
| `app/Controllers/Home.php` | `register_user`, `register_admin`, `forgot_password_user` |
| `app/Libraries/Send_email.php` | Mailer |
| `app/Models/Admin_Model.php` | `get_upload_document1`, user uploads (separate from template slugs) |

---

## Quick answer

**Do we have all CI emails?**

- **Templates:** Yes — all known CI slugs are in `manage_emails_content` (plus Laravel security extras).
- **Actually sending:** **~22/27** CI-equivalent flows are wired; **3** need code hooks (`order_status_to_user`, `update_stock_check_req_to_admin`, `affiliate_register_to_user`); **2** differ (`contact_us`, warehouse/pick-list body).
- **Admin can edit all templates** in Settings → Email Settings (better than CI static list pages).

See also: [CI-vs-Laravel-Tenant-Comparison.md](./CI-vs-Laravel-Tenant-Comparison.md) for module and calculation context.
