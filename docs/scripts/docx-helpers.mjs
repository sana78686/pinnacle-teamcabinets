import { Paragraph, TextRun, HeadingLevel, Table, TableRow, TableCell, WidthType } from 'docx';

const PAGE_WIDTH_DXA = 9360;

export function heading(text, level = HeadingLevel.HEADING_1) {
  return new Paragraph({ text, heading: level, spacing: { before: level === HeadingLevel.HEADING_1 ? 0 : 160, after: 200 } });
}

export function para(text, bold = false) {
  return new Paragraph({
    children: [new TextRun({ text, bold })],
    spacing: { after: 120 },
  });
}

export function bullet(text) {
  return new Paragraph({ text, bullet: { level: 0 }, spacing: { after: 80 } });
}

/** Tables with proportional column widths so cells do not stack vertically. */
export function tableFromRows(rows) {
  const colCount = Math.max(...rows.map((r) => r.length), 1);
  const columnWidths = Array(colCount).fill(Math.floor(PAGE_WIDTH_DXA / colCount));

  return new Table({
    width: { size: 100, type: WidthType.PERCENTAGE },
    columnWidths,
    rows: rows.map((cells, rowIndex) =>
      new TableRow({
        children: cells.map((text, colIndex) =>
          new TableCell({
            width: { size: columnWidths[colIndex], type: WidthType.DXA },
            children: [
              new Paragraph({
                children: [
                  new TextRun({
                    text: String(text ?? ''),
                    bold: rowIndex === 0,
                    size: colCount > 4 ? 18 : 20,
                  }),
                ],
              }),
            ],
          })
        ),
      })
    ),
  });
}

export function spacer() {
  return new Paragraph({ text: '', spacing: { after: 80 } });
}
