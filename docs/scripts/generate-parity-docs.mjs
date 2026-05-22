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

const doc1Sections = [
  heading('Order Workspace — Baseline Differences vs CI Specification'),
  para('Date: May 19, 2026'),
  para('Scope: Laravel tenant order workspace compared to the Cursor Agent Prompt for CodeIgniter Create Order Page (/admin/insert_new_order/{catalogue_id}).'),
  para('Note: JSON API save endpoints are intentionally different from CI form POST insert_order_val; all other gaps are listed below.'),
  heading('1. Layout & page shell', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Page chrome', 'Full admin layout (sidebar/header)', 'Standalone page — Back bar only, no tenant header/footer'],
    ['Entry URL', '/admin/insert_new_order/{catalogue_id}', '/orders/workspace then /orders/workspace/catalog/{id}/build'],
    ['Catalog step', 'Direct to order page', 'Extra catalog picker step before build'],
  ]),
  heading('2. Section 1 — Door strip', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Door data source', 'cabinets_product where cabinets_name = 25', 'door_colors table (schema equivalent)'],
    ['Door click', 'AJAX reload accordion on same page', 'Full page navigation via ?door= query'],
    ['Left heading/preview', 'Updates via JS on door click', 'Not in left column; strip only'],
  ]),
  heading('3. Section 2A — Left panel', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Product Details card', 'Category, label, SKU, weight, cost, details, diagram', 'Missing'],
    ['Single-click row', 'Populates preview only', 'Not implemented — double-click only adds to cart'],
    ['Pricing', 'cost × user point_factor server-side', 'Raw product.cost from DB'],
    ['data-* attributes', 'cost1, details, product-img, door/parent/rep points', 'Partial / zeros'],
  ]),
  heading('4. Section 2B — Cart', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Submit transport', 'Form POST insert_order_val with indexed hidden fields', 'JSON POST to separate workspace endpoints (intentional)'],
    ['Hidden fields', 'cus_rep_id, cus_parent_id, product_sku{N}[], etc.', 'Not on page; JSON rooms[] only'],
    ['Assemble values', 'Radio values 1 / 2 in CI store', 'yes / no strings'],
    ['Room headers', 'Both room + column rows #2e6da4 per tbody', 'Blue room row; separate light header row'],
    ['Qty control', 'type=number between −/+', 'Readonly text input between buttons'],
    ['Checkbox names', 'checkbox_val1{N}[] / checkbox_val2{N}[]', 'chk-single / chk-double; JSON checkbox_status'],
  ]),
  heading('5. Validation & buttons', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Validation UI', 'Inline Required Field only', 'Mostly inline; some flows use SweetAlert on errors'],
    ['Print / Process / Quote / Shipping / Stock', 'Single form submit branches', 'Separate JSON endpoints + modals'],
    ['Checkout', 'Full cart-checkout payment flow', 'Placeholder checkout view'],
    ['Shipping fees', 'Commercial +$75, liftgate +$150 rules', 'Not calculated server-side'],
    ['Emails', 'Quote, shipping, stock mailables + blades', 'Stock mail partial; quote/shipping incomplete'],
  ]),
  heading('6. Controller & persistence', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current Laravel implementation'],
    ['Controller', 'Admin\\OrderController', 'TenantCreateOrderController'],
    ['Affiliate URL', 'Optional affiliate_id param', 'Not wired on build'],
    ['Rep chain', 'cus_rep_id walk until parent_id = 4', 'Not passed to view'],
    ['Catalog visibility', 'Checked in create()', 'Not enforced'],
    ['cart_data JSON', 'CI room_data keyed by room name', 'room_index + products array shape'],
  ]),
  heading('7. Intentional / user-requested differences', HeadingLevel.HEADING_2),
  bullet('Standalone fullscreen order page (no tenant header/footer) — conflicts with doc line “use Laravel admin theme with chrome”.'),
  bullet('JSON API saves instead of form POST — retained by project decision.'),
];

const doc2Sections = [
  heading('Order Workspace — Remaining Differences After Parity Update'),
  para('Date: May 19, 2026'),
  para('This document lists gaps that still remain after aligning UI/behavior with the CI specification, while keeping JSON API save endpoints.'),
  heading('1. Intentionally retained', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current implementation'],
    ['Save transport', 'Form POST insert_order_val with save_quote_mod_btn / print_btn', 'JSON POST to tenant_order_workspace_* routes'],
    ['Payload shape', 'roomlabel_id[] + product_sku{N}[] hidden fields', 'JSON { job_name, rooms[], assemble, comment, ... }'],
    ['Checkbox POST names', 'checkbox_val1{N}[] / checkbox_val2{N}[]', 'checkbox_status in JSON (single/double/none)'],
  ]),
  heading('2. Structural / routing (acceptable equivalents)', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current implementation'],
    ['Routes', '/admin/insert_new_order/{id}', '/orders/workspace/catalog/{id}/build'],
    ['Door table', 'cabinets_product cabinets_name=25', 'door_colors (Laravel schema)'],
    ['Catalog entry', 'Direct to catalogue order', 'Catalog picker step retained'],
    ['Page shell', 'Admin layout with sidebar', 'Standalone Back bar (user request)'],
  ]),
  heading('3. May still need follow-up', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Area', 'CI specification', 'Current implementation'],
    ['Checkout payment', 'Full cart_checkout_product flow', 'Checkout summary page — payment gateway not ported'],
    ['Affiliate impersonation', 'insert_new_order/{catalog}/{affiliate}', 'Optional affiliate_id query — partial'],
    ['Shipping cost engine', '+$75 commercial, +$150 liftgate on server', 'Stored options only; fees not auto-applied'],
    ['Quote saved email', 'Dedicated quote_saved template', 'Uses manage_emails if slug exists; may be absent in tenant DB'],
    ['Door/parent/rep point factors on parent chain', 'Full parent/rep door factor walk', 'User door factor + point_factor default; parent/rep door points may be 0 until chain logic added'],
    ['Backend totals recalc', 'Uses posted line costs', 'OrderWorkspaceService may recalc from DB cost — client should send unit_cost in JSON for exact parity'],
  ]),
  heading('4. Implemented in parity pass (no longer gaps)', HeadingLevel.HEADING_2),
  bullet('Product Details preview box + single-click on product row.'),
  bullet('Door strip AJAX (no full page reload) + left door heading/preview.'),
  bullet('Point-factor adjusted costs on picker rows (data-cost / data-cost1).'),
  bullet('Cart room/column #2e6da4 styling, yellow active room, cb-yellow/cb-green, qty number input.'),
  bullet('SKU empty search via AJAX reset; Enter triggers search.'),
  bullet('cus_rep_id / cus_parent_id hidden fields on page.'),
  bullet('Catalog visibility check on build.'),
  bullet('Shipping + stock emails wired where templates exist.'),
  bullet('Checkout page shows room/line summary from session.'),
];

async function writeDoc(filename, sections) {
  const doc = new Document({ sections: [{ children: sections }] });
  const buffer = await Packer.toBuffer(doc);
  fs.writeFileSync(path.join(outDir, filename), buffer);
  console.log('Wrote', filename);
}

const which = process.argv[2] || 'both';
if (which === '1' || which === 'both') await writeDoc('Order-Workspace-Baseline-Differences.docx', doc1Sections);
if (which === '2' || which === 'both') await writeDoc('Order-Workspace-Remaining-Differences.docx', doc2Sections);
