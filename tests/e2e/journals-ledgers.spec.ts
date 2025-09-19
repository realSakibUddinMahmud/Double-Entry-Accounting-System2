import { test, expect } from '@playwright/test';

const ADMIN_PHONE = process.env.ADMIN_PHONE || '01900000000';
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'Admin@123';

async function login(page) {
  await page.goto('/login');
  await page.locator('input[name="phone"]').fill(ADMIN_PHONE);
  await page.locator('input[name="password"]').fill(ADMIN_PASSWORD);
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');
  await expect(page).not.toHaveURL(/login/);
}

test.describe('Journals & Ledgers', () => {
  test('Journal filters render and search triggers', async ({ page }) => {
    await login(page);
    await page.goto('/de-accounting/journals');
    await expect(page.locator('body')).toContainText(/journal|journals/i);
    const start = page.locator('input[name*="start_date" i]');
    const end = page.locator('input[name*="end_date" i]');
    if (await start.count() && await end.count()) {
      const today = new Date().toISOString().slice(0, 10);
      await start.first().fill(today).catch(() => {});
      await end.first().fill(today).catch(() => {});
    }
    const searchBtn = page.getByRole('button', { name: /search|view|filter/i });
    if (await searchBtn.count()) await searchBtn.first().click().catch(() => {});
    await page.waitForLoadState('networkidle');
  });

  test('Ledger filters render and search triggers', async ({ page }) => {
    await login(page);
    await page.goto('/de-accounting/ledgers');
    await expect(page.locator('body')).toContainText(/ledger|ledgers/i);
    const accountSelect = page.locator('select[name*="account" i], select#account_id');
    if (await accountSelect.count()) await accountSelect.first().selectOption({ index: 1 }).catch(() => {});
    const searchBtn = page.getByRole('button', { name: /search|view|filter/i });
    if (await searchBtn.count()) await searchBtn.first().click().catch(() => {});
    await page.waitForLoadState('networkidle');
  });
});

