import { test, expect } from '@playwright/test';

test.describe('Export downloads', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill('01900000000');
    await page.locator('input[name="password"]').fill('secret123');
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
    await expect(page.getByText('Welcome')).toBeVisible();
  });

  test('sales report PDF download works', async ({ page, context }, testInfo) => {
    await page.goto('/report/sales');
    const [ download ] = await Promise.all([
      page.waitForEvent('download'),
      page.getByRole('link', { name: 'PDF' }).click(),
    ]);
    const path = await download.path();
    expect(path).toBeTruthy();
    const suggested = download.suggestedFilename();
    expect(suggested).toMatch(/sales_report_.*\.pdf$/);
    await download.saveAs(`${testInfo.outputDir}/${suggested}`);
  });

  test('stock report PDF download works', async ({ page }, testInfo) => {
    await page.goto('/report/stock');
    const today = new Date().toISOString().slice(0, 10);
    await page.locator('input[name="start_date"]').fill(today);
    await page.locator('input[name="end_date"]').fill(today);
    await Promise.all([
      page.waitForLoadState('networkidle'),
      page.getByRole('button', { name: 'View' }).click(),
    ]);
    const clickPromise = page.getByRole('link', { name: 'PDF' }).click({ noWaitAfter: true });
    const downloadPromise = page.waitForEvent('download', { timeout: 45000 }).catch(() => null);
    const responsePromise = page.waitForResponse((resp) => resp.url().includes('/report/stock/export') && (resp.status() === 200), { timeout: 45000 });
    const [ download, response ] = await Promise.all([downloadPromise, responsePromise, clickPromise]);
    if (download) {
      const path = await download.path();
      expect(path).toBeTruthy();
      const suggested = download.suggestedFilename();
      expect(suggested).toMatch(/stock_report_.*\.pdf$/);
      await download.saveAs(`${testInfo.outputDir}/${suggested}`);
    } else {
      expect(await response.headerValue('content-type')).toContain('application/pdf');
    }
  });

  test('purchase report PDF download works', async ({ page }, testInfo) => {
    await page.goto('/report/purchase');
    const [ download ] = await Promise.all([
      page.waitForEvent('download'),
      page.getByRole('link', { name: 'PDF' }).click(),
    ]);
    const path = await download.path();
    expect(path).toBeTruthy();
    const suggested = download.suggestedFilename();
    expect(suggested).toMatch(/purchase_report_.*\.pdf$/);
    await download.saveAs(`${testInfo.outputDir}/${suggested}`);
  });
});

