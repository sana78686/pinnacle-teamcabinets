# Team Cabinets — E2E Smoke Test Report

**Generated:** 2026-05-25 03:03:46
**Command:** `php artisan tenant:e2e-smoke`
**Tenant:** e2e-2qw44jvm

## Summary

| Result | Count |
|--------|-------|
| PASS | 18 |
| FAIL | 0 |

**Overall:** Automated smoke test **passed**. No blocking errors in provisioning, multi-role users, email templates, commission service, catalog analytics, migrations, or route registration.

### Notes (non-failing)

- **Commission `mfg=0, rep=0`:** Expected on a fresh tenant until admin/dealer `point_factor` values are set under Settings → Commission & Point Factors.
- **Catalog sales `0` catalogs:** No completed orders (`state = 1`) in the test tenant yet — place a test order in the UI to validate dashboard2 widget data.
- **Tenant cleanup:** Deleting the ephemeral test tenant may log `Can't drop database tenant_*` if separate DB was never created (`separate_by_tenant` is false in this install). Safe to ignore or delete tenant row manually.
- **Browser flows** (login, checkout, Vue CRUD save, SMTP send) require manual verification — see checklist below.

## Steps

| Step | Status | Detail |
|------|--------|--------|
| Central migrations | PASS | migrate completed |
| Permission seeder (roles) | PASS | PermissionTableSeeder ran |
| Create tenant | PASS | id=e2e-2qw44jvm |
| Create / find tenant admin | PASS | e2e-admin-e2e-2qw44jvm@smoke.test (admin) |
| Create user role: representatives | PASS | e2e-representatives-e2e-2qw44jvm@smoke.test (representatives) |
| Create user role: distributors | PASS | e2e-distributors-e2e-2qw44jvm@smoke.test (distributors) |
| Create user role: dealers | PASS | e2e-dealers-e2e-2qw44jvm@smoke.test (dealers) |
| Create user role: customers | PASS | e2e-customers-e2e-2qw44jvm@smoke.test (customers) |
| Create user role: affiliate | PASS | e2e-affiliate-e2e-2qw44jvm@smoke.test (affiliate) |
| Tenant context initialized | PASS | tenant id: e2e-2qw44jvm |
| Email templates seeded | PASS | 27 templates in manage_emails_content |
| Commission calculation (cart) | PASS | mfg=0, rep=0 |
| Catalog sales analytics | PASS | periods ok; catalogs in total: 0 |
| Orders table + state scope | PASS | completed orders: 0 |
| Admin uploads table | PASS | admin_uploads exists |
| Manage document table | PASS | manage_document exists |
| Manage inventories table | PASS | manage_inventories exists |
| Tenant routes registered | PASS | 9 routes present |

## Manual UI checks (not automated)

- Log in as admin on tenant domain → Dashboard, order tracker, catalog sales widget
- Settings → Email Settings → edit template + test SMTP
- Settings → Documentation / Admin uploads / Inventory admin (Vue CRUD)
- Rep user → My Downloads / My Uploads
- Order workspace → create order through checkout (browser)
- Commission report → filter + CSV export
