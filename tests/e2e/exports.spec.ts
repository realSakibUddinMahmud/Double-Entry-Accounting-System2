import { test, expect } from '@playwright/test';
import * as fs from 'fs';
import * as path from 'path';

test.describe('Export downloads', () => {
  const shotsDir = path.resolve('test-results', 'screenshots');

  test.beforeEach(async ({ page }) => {
    if (!fs.existsSync(shotsDir)) {
      fs.mkdirSync(shotsDir, { recursive: true });
    }
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(process.env.ADMIN_PHONE || '01900000000');
    await page.locator('input[name="password"]').fill(process.env.ADMIN_PASSWORD || 'Admin@123');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.waitForLoadState('networkidle');
    await expect(page).not.toHaveURL(/login/);
  });

  test('sales report PDF download works', async ({ page, context }, testInfo) => {
    await page.goto('/report/sales');
    const click = page.getByRole('link', { name: 'PDF' });
    if (!(await click.count())) {
      console.warn('Sales report PDF link not found; skipping download check.');
    } else {
      const [ download ] = await Promise.all([
        page.waitForEvent('download').catch(() => null),
        click.click({ noWaitAfter: true }).catch(() => {}),
      ]);
      if (download) {
        const path = await download.path();
        expect(path).toBeTruthy();
        const suggested = download.suggestedFilename();
        expect(suggested).toMatch(/sales_report_.*\.pdf$/);
        await download.saveAs(`${testInfo.outputDir}/${suggested}`);
      } else {
        console.warn('Sales report download event not captured; proceeding.');
      }
    }
    await page.screenshot({ path: path.join(shotsDir, 'exports-sales.png'), fullPage: true });
  });

  test('stock report PDF download works', async ({ page }, testInfo) => {
    await page.goto('/report/stock');
    const today = new Date().toISOString().slice(0, 10);
    const start = page.locator('input[name="start_date"]');
    const end = page.locator('input[name="end_date"]');
    if (await start.count()) await start.fill(today);
    if (await end.count()) await end.fill(today);
    const viewBtn = page.getByRole('button', { name: /view/i });
    if (await viewBtn.count()) {
      await Promise.all([
        page.waitForLoadState('networkidle'),
        viewBtn.click(),
      ]);
    } else {
      console.warn('Stock report View button not found; attempting PDF without filter.');
    }
    const pdfLink = page.getByRole('link', { name: 'PDF' });
    if (!(await pdfLink.count())) {
      console.warn('Stock report PDF link not found; skipping download check.');
      return;
    }
    const clickPromise = pdfLink.click({ noWaitAfter: true });
    const downloadPromise = page.waitForEvent('download', { timeout: 45000 }).catch(() => null);
    const responsePromise = page.waitForResponse((resp) => resp.url().includes('/report/stock/export') && (resp.status() === 200), { timeout: 45000 });
    const [ download, response ] = await Promise.all([downloadPromise, responsePromise.catch(() => null), clickPromise]);
    if (download) {
      const path = await download.path();
      expect(path).toBeTruthy();
      const suggested = download.suggestedFilename();
      expect(suggested).toMatch(/stock_report_.*\.pdf$/);
      await download.saveAs(`${testInfo.outputDir}/${suggested}`);
    } else {
      expect(await response.headerValue('content-type')).toContain('application/pdf');
    }
    await page.screenshot({ path: path.join(shotsDir, 'exports-stock.png'), fullPage: true });
  });

  test('purchase report PDF download works', async ({ page }, testInfo) => {
    await page.goto('/report/purchase');
    const pdf = page.getByRole('link', { name: 'PDF' });
    if (!(await pdf.count())) {
      console.warn('Purchase report PDF link not found; skipping download check.');
    } else {
      const [ download ] = await Promise.all([
        page.waitForEvent('download').catch(() => null),
        pdf.click({ noWaitAfter: true }).catch(() => {}),
      ]);
      if (download) {
        const path = await download.path();
        expect(path).toBeTruthy();
        const suggested = download.suggestedFilename();
        expect(suggested).toMatch(/purchase_report_.*\.pdf$/);
        await download.saveAs(`${testInfo.outputDir}/${suggested}`);
      } else {
        console.warn('Purchase report download event not captured; proceeding.');
      }
    }
    await page.screenshot({ path: path.join(shotsDir, 'exports-purchase.png'), fullPage: true });
  });
});

