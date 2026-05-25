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
import { gapModules } from './ci-laravel-gap-modules.mjs';

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
  heading('CodeIgniter vs Laravel — Complete Feature Gap Analysis'),
  para('Project: Team Cabinets tenant portal'),
  para('Reference CI codebase: ci-teamcabinets-with-old-db-worked-fine (Admin.php, Manage_settings.php, Homepage_manage.php, Quickbooks.php, Paytrace.php)'),
  para('Laravel codebase: team-cabinets (routes/tenant.php, config/tenant_admin_nav.php, config/tenant_settings_menu.php)'),
  para('Generated: May 24, 2026'),
  para(
    'Legend — Present: implemented and wired; Partial: subset or different UX/schema; Missing: no Laravel equivalent found; Laravel-only: new capability not in CI.',
    true
  ),
  heading('How to verify commission report & order tracker locally', HeadingLevel.HEADING_2),
  tableFromRows([
    ['Step', 'Action', 'Expected result'],
    [
      '1',
      'Run php artisan migrate (shared DB) so order_enhanced_details exists',
      'Migration 2026_05_19_120000_create_order_enhanced_details_table',
    ],
    [
      '2',
      'Log in as tenant admin → Dashboard',
      '“Order tracker details” card with rows when orders/quotes/stock checks exist',
    ],
    [
      '3',
      'Edit a tracker field (e.g. Customer paid = Yes)',
      'Auto-save via POST /tenants/dashboard/order-tracker; row persists on refresh',
    ],
    [
      '4',
      'Settings → Commission & Point Factors → Commission reports (or sidebar Commission)',
      'Vue list loads JSON; filter by rep and dates; Export CSV downloads',
    ],
    [
      '5',
      'If commission list is empty',
      'Orders need room_data with door lines and commission-related order fields; seed or place test order',
    ],
  ]),
];

for (const mod of gapModules) {
  sections.push(heading(mod.title, HeadingLevel.HEADING_2));
  if (mod.intro) {
    sections.push(para(mod.intro));
  }
  sections.push(tableFromRows(mod.rows));
}

sections.push(
  heading('Related documents', HeadingLevel.HEADING_2),
  para('Order workspace UI/API gaps (detailed): docs/Order-Workspace-Baseline-Differences.docx and Order-Workspace-Remaining-Differences.docx (npm run generate:parity in docs/).')
);

const doc = new Document({ sections: [{ children: sections }] });
const buffer = await Packer.toBuffer(doc);
const filename = 'CI-vs-Laravel-Feature-Gap-Analysis.docx';
fs.writeFileSync(path.join(outDir, filename), buffer);
console.log('Wrote', path.join(outDir, filename));
