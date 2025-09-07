import { test, expect } from '@playwright/test';

const validPhone = '01900000000';
const validPassword = 'secret123';

test.describe('Reports E2E', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('input[name="phone"]').fill(validPhone);
    await page.locator('input[name="password"]').fill(validPassword);
    await Promise.all([
      page.waitForURL('**/home'),
      page.getByRole('button', { name: 'Sign In' }).click(),
    ]);
  });

  test('open stock report and sales report pages', async ({ page }) => {
    await page.goto('/report/stock');
    await expect(page.locator('body')).toContainText(/stock|report/i);

    await page.goto('/report/sales');
    await expect(page.locator('body')).toContainText(/sales|report/i);
  });
});

