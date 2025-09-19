#!/usr/bin/env node
import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';

const [, , inputMd, outputPdf] = process.argv;
if (!inputMd || !outputPdf) {
	console.error('Usage: node scripts/render-pdf.js <input.md> <output.pdf>');
	process.exit(1);
}

const mdPath = path.resolve(inputMd);
const pdfPath = path.resolve(outputPdf);
if (!fs.existsSync(mdPath)) {
	console.error('Input markdown not found:', mdPath);
	process.exit(1);
}

let markdown = fs.readFileSync(mdPath, 'utf8');
const today = new Date().toISOString().slice(0, 10);
markdown = markdown.replaceAll('{TODAY}', today);

function escapeHtml(s){
	return s.replace(/[&<>]/g, c => ({'&': '&amp;', '<': '&lt;', '>': '&gt;'}[c]));
}

function renderMarkdownToHtml(md) {
	const lines = md.split(/\r?\n/);
	let html = '';
	let inList = false;
	const flushList = () => { if (inList) { html += '</ul>'; inList = false; } };
	for (const raw of lines) {
		const line = raw.trimEnd();
		if (line.startsWith('## ')) { flushList(); html += `<h2>${escapeHtml(line.slice(3))}</h2>`; continue; }
		if (line.startsWith('### ')) { flushList(); html += `<h3>${escapeHtml(line.slice(4))}</h3>`; continue; }
		if (line.startsWith('- ')) { if (!inList) { html += '<ul>'; inList = true; } html += `<li>${escapeHtml(line.slice(2))}</li>`; continue; }
		if (line === '') { flushList(); html += '<br />'; continue; }
		flushList(); html += `<p>${escapeHtml(line)}</p>`;
	}
	flushList();
	return html;
}

const bodyHtml = renderMarkdownToHtml(markdown);
const html = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QA Summary Report</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; margin: 24px; }
    h1, h2, h3 { color: #111; }
    code, pre { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
    ul { margin-top: 6px; margin-bottom: 6px; }
    section { margin-bottom: 16px; }
  </style>
</head>
<body>
${bodyHtml}
</body>
</html>`;

const tempHtml = path.join(process.cwd(), 'docs', 'QA', 'QA-Summary.tmp.html');
fs.mkdirSync(path.dirname(tempHtml), { recursive: true });
fs.writeFileSync(tempHtml, html, 'utf8');

const browser = await chromium.launch();
const page = await browser.newPage();
await page.goto('file://' + tempHtml, { waitUntil: 'load' });
await page.pdf({ path: pdfPath, printBackground: true, format: 'A4', margin: { top: '20mm', bottom: '20mm', left: '12mm', right: '12mm' } });
await browser.close();

fs.unlinkSync(tempHtml);
console.log('Wrote PDF:', pdfPath);